<!DOCTYPE html>
<html>
<head>
  <title>Calendário de Eventos</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <style>
    /* Estilos para o layout */
    .container {
      display: flex;
    }

    .calendar {
      width: 300px;
    }

    .events {
      flex: 1;
      padding-left: 20px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="calendar">
      <!-- Calendário aqui -->
      <div id="datepicker"></div>
    </div>
    <div class="events">
      <!-- Eventos aqui -->
      <h2 id="selectedDate"></h2>
      <button onclick="showEventForm()">Inserir Evento</button>
      <div id="eventForm" style="display: none;">
        <input type="text" id="eventTitle" placeholder="Título">
        <input type="text" id="eventTime" placeholder="Horário">
        <textarea id="eventDescription" placeholder="Descrição"></textarea>
        <button onclick="saveEvent()">Salvar</button>
      </div>
      <ul id="eventList"></ul>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script>
    // Configuração do calendário
    flatpickr("#datepicker", {
      inline: true,
      dateFormat: "d/m/Y",
      onChange: function(selectedDates, dateStr, instance) {
        document.getElementById('selectedDate').innerHTML = dateStr;
      }
    });

    // Função para exibir o formulário de evento
    function showEventForm() {
      document.getElementById('eventForm').style.display = 'block';
    }

    // Função para salvar o evento
    function saveEvent() {
      var title = document.getElementById('eventTitle').value;
      var time = document.getElementById('eventTime').value;
      var description = document.getElementById('eventDescription').value;
      var event = {
        title: title,
        time: time,
        description: description
      };
      // Aqui você pode salvar o evento em um banco de dados ou fazer qualquer outra operação necessária
      addEventToList(event);
      document.getElementById('eventForm').style.display = 'none';
    }

    // Função para adicionar um evento à lista de eventos
    function addEventToList(event) {
      var eventList = document.getElementById('eventList');
      var li = document.createElement('li');
      li.innerHTML = '<strong>' + event.title + '</strong><br>' + event.time + '<br>' + event.description;
      eventList.appendChild(li);
    }
  </script>
</body>
</html>
