@extends('template.master')
<title>kalender</title>
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0"></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Beranda</a></li>
          <li class="breadcrumb-item active">kalender</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="container-fluid">
  <div class="card card-primary">
    <div class="card-body p-0">
      <!-- THE CALENDAR -->
      <div id="calendar"></div>
    </div>
  </div>
</div><!-- /.container-fluid -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script type="text/javascript">
  $(function() {

    /* initialize the external events
     -----------------------------------------------------------------*/

    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date()
    var d = date.getDate(),
      m = date.getMonth(),
      y = date.getFullYear()

    var Calendar = FullCalendar.Calendar;

    var calendarEl = document.getElementById('calendar');

    // initialize the external events
    // -----------------------------------------------------------------
    //var title = calendar.nama;
    var events = @json($events);
    // var milestone = ;
    // console.log(project);
    var calendar = new Calendar(calendarEl, {
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      themeSystem: 'bootstrap',
      //Random default events

      events: events,
      editable: false,
      droppable: false, // this allows things to be dropped onto the calendar !!!
    });

    calendar.render();
    // $('#calendar').fullCalendar()

  })
</script>
@endsection