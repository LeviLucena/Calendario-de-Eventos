<!DOCTYPE html>
<html>
<head>
  <title>Calendário de Eventos</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.print.min.css" media="print" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
  <style>
    /* Estilos para o layout */
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .calendar-container {
      width: 800px;
    }

    .event-details {
      padding: 10px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      background-color: #f5f5f5;
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
  </style>
</head>
<body>
  <div class="calendar-container">
    <div id="calendar"></div>
  </div>

  <div id="eventDetails" class="event-details" style="display: none;">
    <h3 id="eventTitle"></h3>
    <p id="eventTime"></p>
    <p id="eventDescription"></p>
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
    <input type="text" id="newEventTitle" placeholder="Título">
    <div class="row">
      <div class="col-md-6">
        <div class="color-selector">
          <span>Equipe:</span>
          <select id="newEventTeam">
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
          <input type="text" id="newEventTime" placeholder="Hora">
        </div>
      </div>
    </div>
    <textarea id="newEventDescription" placeholder="Descrição"></textarea>
    <button onclick="createEvent()">Criar</button>
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
          var eventTitle = document.getElementById('eventTitle');
          var eventTime = document.getElementById('eventTime');
          var eventDescription = document.getElementById('eventDescription');

          eventTitle.textContent = calEvent.title;
          eventTime.textContent = moment(calEvent.start).format('DD/MM/YYYY HH:mm');
          eventDescription.textContent = calEvent.description;

          document.getElementById('eventDetails').style.display = 'block';
        },
        locale: 'pt-br', // Definindo o idioma para português do Brasil
        dayClick: function(date, jsEvent, view) {
          showEventForm(date);
        }
      });

      function showEventForm(date) {
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

        var dayOfWeek = moment(date).format('dddd'); // Obtém o dia da semana
        var formattedDate = moment(date).format('D MMMM YYYY'); // Formata a data

        selectedDateContainer.innerHTML = formattedDate + ' (' + dayOfWeek + ')'; // Exibe a data e o dia da semana

        document.getElementById('eventForm').style.display = 'block';
      }

      function createEvent() {
        var newEventTitle = document.getElementById('newEventTitle').value;
        var newEventTeam = document.getElementById('newEventTeam').value;
        var newEventTime = document.getElementById('newEventTime').value;
        var newEventDescription = document.getElementById('newEventDescription').value;

        var selectedDate = calendar.fullCalendar('getDate');
        var newEventDateTime = moment(selectedDate).format('YYYY-MM-DD') + ' ' + newEventTime;

        var selectedColor = $('.color-option.selected').css('background-color');

        var newEvent = {
          title: newEventTitle,
          start: newEventDateTime,
          description: newEventDescription,
          team: newEventTeam,
          color: selectedColor
        };

        calendar.fullCalendar('renderEvent', newEvent);
        calendar.fullCalendar('unselect');

        document.getElementById('eventForm').style.display = 'none';
      }

      $('.color-option').on('click', function() {
        $('.color-option').removeClass('selected');
        $(this).addClass('selected');
      });
    });
  </script>
</body>
</html>
