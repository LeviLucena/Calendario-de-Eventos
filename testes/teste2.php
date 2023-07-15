<!DOCTYPE html>
<html>
<head>
  <title>Calendário de Eventos</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.print.min.css" media="print" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css" rel="stylesheet">
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

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
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
            start: '2023-07-01'
          },
          {
            title: 'Evento 2',
            start: '2023-07-05'
          },
          {
            title: 'Evento 3',
            start: '2023-07-15',
            end: '2023-07-17'
          }
          // Adicione mais eventos aqui...
        ],
        eventClick: function(calEvent, jsEvent, view) {
          var eventTitle = document.getElementById('eventTitle');
          var eventTime = document.getElementById('eventTime');
          var eventDescription = document.getElementById('eventDescription');

          eventTitle.textContent = calEvent.title;
          eventTime.textContent = moment(calEvent.start).format('DD/MM/YYYY');
          eventDescription.textContent = calEvent.description;

          document.getElementById('eventDetails').style.display = 'block';
        }
      });
    });
  </script>
</body>
</html>
