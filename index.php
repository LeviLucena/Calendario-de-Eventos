<!DOCTYPE html>
<html>
<!-- ====================================================================== -->
<!--  Desenvolvido por Levi Lucena - linkedin.com/in/levilucena -->
<!-- ====================================================================== -->
<head>
  <title>Calendário de Eventos</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.print.min.css" media="print" rel="stylesheet">
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
  <style>
    /* Estilos para o layout */

    body {
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      zoom: 0.9; /* Define o nível de zoom da página */
    }

    .calendar-container {
      width: 80%;
      max-width: 800px;
      margin: 0 auto;
    }

    .event-details {
      position: absolute; /* Adiciona um posicionamento absoluto para o quadro de detalhes */
      top: 10px;
      left: 1200px; /* Define a posição à direita do calendário */
      width: 300px;
      padding: 10px;
      border: 1px solid #ccc;
      background-color: #f5f5f5;
      z-index: 9999; /* Define uma camada de empilhamento alta para que o quadro fique acima do calendário */
    }

    .event-details h3 {
      margin-top: 0;
    }

    .event-details p {
      margin: 0;
    }

    .event-form-container {
      max-width: 400px;
      margin: 0 auto;
      padding: 20px;
      background-color: #f5f5f5;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .event-form-container h3 {
      margin-top: 0;
      display: flex;
      align-items: center;
    }

    .event-form-container h3 .color-selector {
      margin-left: 10px;
    }

    .event-form-container input,
    .event-form-container select,
    .event-form-container textarea,
    .event-form-container button {
      width: 100%;
      margin-bottom: 10px;
    }

    .color-selector {
      display: flex;
      align-items: center;
      margin-bottom: 10px;
    }

    .color-selector span {
      margin-right: 10px;
    }

    .color-selector .color-option {
      width: 20px;
      height: 20px;
      border-radius: 50%;
      margin-right: 5px;
      cursor: pointer;
      border: 1px solid #ccc;
      transition: border-width 0.3s;
    }

    .color-selector .color-option.selected {
      border-width: 3px;
      transform: scale(1.2);
      box-shadow: 0 0 5px #000;
    }

    .day-of-week {
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .delete-event-button {
      background-color: #dc3545;
      color: #fff;
      border: none;
      padding: 5px 10px;
      border-radius: 3px;
      cursor: pointer;
    }

    .event-description {
      max-height: 100px;
      overflow: auto;
    }
  </style>
</head>
<body>
  <div class="calendar-container">
    <div id="calendar"></div>
    <div id="eventDetails" class="event-details" style="display: none;">
      <h3 id="eventTitle"></h3>
      <p id="eventTime"></p>
      <div id="eventDescription" class="event-description"></div>
      <p id="eventTeam"></p>
      <button id="deleteEventButton" class="btn btn-danger">Deletar Evento</button>
    </div>
  </div>

  <div id="eventForm" class="event-form-container" style="display: none;">
    <h3>
      Novo Evento
      <div class="color-selector">
        <div class="color-option" style="background-color: green;" onclick="selectColor(this)"></div>
        <div class="color-option" style="background-color: yellow;" onclick="selectColor(this)"></div>
        <div class="color-option" style="background-color: red;" onclick="selectColor(this)"></div>
      </div>
    </h3>
    <div id="selectedDateContainer" class="day-of-week"></div>
    <input type="text" id="newEventTitle" placeholder="Título" class="form-control">
    <div class="row">
      <div class="col-md-6">
        <div class="color-selector">
          <span>Equipe:</span>
          <select id="newEventTeam" class="form-control">
            <option value="Banco de Dados">BD</option>
            <option value="Linux">Linux</option>
            <option value="Windows">Windows</option>
            <option value="Redes">Redes</option>
          </select>
        </div>
      </div>
      <div class="col-md-6">
        <div class="color-selector">
          <span>Hora:</span>
          <input type="text" id="newEventTime" placeholder="Hora" class="form-control">
        </div>
      </div>
    </div>
    <textarea id="newEventDescription" placeholder="Descrição" class="form-control"></textarea>
    <button id="createEventButton" class="btn btn-primary">Criar</button>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/locale/pt-br.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script>
    $(document).ready(function() {
      var calendar = $('#calendar').fullCalendar({
        header: {
          left: 'prev,next today',
          center: 'title',
          right: 'month,agendaWeek,agendaDay'
        },
        defaultView: 'month',
        navLinks: true,
        editable: true,
        eventLimit: true,
        events: [
          {
            title: 'Evento 1',
            start: '2023-07-01',
            color: 'green'
          },
          {
            title: 'Evento 2',
            start: '2023-07-05',
            color: 'yellow'
          },
          {
            title: 'Evento 3',
            start: '2023-07-15',
            end: '2023-07-17',
            color: 'red'
          }
          // Adicione mais eventos aqui...
        ],
        eventClick: function(calEvent, jsEvent, view) {
          showEventDetails(calEvent);
        },
        locale: 'pt-br', // Definindo o idioma para português do Brasil
        dayClick: function(date, jsEvent, view) {
          showEventForm(date);
        }
      });

      var selectedDate; // Variável para armazenar a data selecionada

      function showEventForm(date) {
        selectedDate = date;

        var eventDetails = document.getElementById('eventDetails');
        var eventForm = document.getElementById('eventForm');

        if (eventDetails.style.display === 'block') {
          eventDetails.style.display = 'none';
        }

        var newEventTitle = document.getElementById('newEventTitle');
        var newEventTeam = document.getElementById('newEventTeam');
        var newEventTime = document.getElementById('newEventTime');
        var newEventDescription = document.getElementById('newEventDescription');
        var selectedDateContainer = document.getElementById('selectedDateContainer');

        newEventTitle.value = '';
        newEventTeam.value = '';
        newEventTime.value = '';
        newEventDescription.value = '';

        var flatpickrOptions = {
          enableTime: true,
          noCalendar: true,
          dateFormat: 'H:i',
          defaultDate: date.toDate(),
          time_24hr: true,
          onChange: function(selectedDates, dateStr, instance) {
            newEventTime.value = dateStr;
          }
        };

        flatpickr('#newEventTime', flatpickrOptions);

        var dayOfWeek = moment(date).format('dddd');
        var formattedDate = moment(date).format('D MMMM YYYY');

        selectedDateContainer.innerHTML = formattedDate + ' (' + dayOfWeek + ')';

        eventForm.style.display = 'block';
      }

      function createEvent() {
        var newEventTitle = document.getElementById('newEventTitle').value;
        var newEventTeam = document.getElementById('newEventTeam').value;
        var newEventTime = document.getElementById('newEventTime').value;
        var newEventDescription = document.getElementById('newEventDescription').value;

        var newEventDateTime = moment(selectedDate).format('YYYY-MM-DD') + ' ' + newEventTime;

        var selectedColor = $('.color-option.selected').css('background-color');

        var newEvent = {
          title: newEventTitle,
          start: newEventDateTime,
          description: newEventDescription,
          team: newEventTeam,
          color: selectedColor
        };

        // Envie os dados do evento para o servidor usando AJAX
        $.ajax({
          url: 'inserir_evento.php', // Substitua pelo caminho para o arquivo PHP responsável pela inserção no banco de dados
          type: 'POST',
          data: newEvent,
          success: function(response) {
            // O evento foi inserido com sucesso no banco de dados
            newEvent.id = response; // Defina o ID do evento retornado pelo servidor
            calendar.fullCalendar('renderEvent', newEvent); // Renderize o evento no calendário
            calendar.fullCalendar('unselect');
            document.getElementById('eventForm').style.display = 'none';
          },
          error: function(xhr, status, error) {
            // Ocorreu um erro ao inserir o evento no banco de dados
            console.error(error);
          }
        });
      }

      function showEventDetails(event) {
        var eventDetails = document.getElementById('eventDetails');
        var eventForm = document.getElementById('eventForm');

        if (eventForm.style.display === 'block') {
          eventForm.style.display = 'none';
        }

        var eventTitle = document.getElementById('eventTitle');
        var eventTime = document.getElementById('eventTime');
        var eventDescription = document.getElementById('eventDescription');
        var eventTeam = document.getElementById('eventTeam');
        var deleteEventButton = document.getElementById('deleteEventButton');

        eventTitle.textContent = event.title;
        eventTime.textContent = moment(event.start).format('DD/MM/YYYY HH:mm');
        eventDescription.textContent = event.description;
        eventTeam.textContent = 'Equipe: ' + event.team;

        deleteEventButton.addEventListener('click', function() {
          // Remova o evento do banco de dados usando AJAX
          $.ajax({
            url: 'remover_evento.php', // Substitua pelo caminho para o arquivo PHP responsável pela remoção no banco de dados
            type: 'POST',
            data: { id: event.id }, // Envie o ID do evento para o servidor
            success: function(response) {
              // O evento foi removido com sucesso do banco de dados
              calendar.fullCalendar('removeEvents', event.id); // Remova o evento do calendário
              eventDetails.style.display = 'none';
            },
            error: function(xhr, status, error) {
              // Ocorreu um erro ao remover o evento do banco de dados
              console.error(error);
            }
          });
        });

        eventDetails.style.display = 'block';
      }

      $('.color-option').on('click', function() {
        $('.color-option').removeClass('selected');
        $(this).addClass('selected');
      });

      document.getElementById('createEventButton').addEventListener('click', createEvent);
    });
  </script>
</body>
</html>
