<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
  <link rel="icon" href="https://eclass.ukdw.ac.id/images/favicon.png" type="image/png">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <!-- <link rel="stylesheet" href="{{asset('AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css')}}"> -->
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('AdminLTE-3.2.0/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('AdminLTE-3.2.0/dist/css/adminlte.min.css')}}">
  <!-- daterange picker -->
  <link rel="stylesheet" href="{{asset('AdminLTE-3.2.0/plugins/daterangepicker/daterangepicker.css')}}">
  <!-- fullCalendar -->
  <link rel="stylesheet" href="{{asset('AdminLTE-3.2.0/plugins/fullcalendar/main.css')}}">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{asset('AdminLTE-3.2.0/plugins/toastr/toastr.min.css')}}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
 <!-- Ionicons -->
 <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">



    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        @if(auth()->user()->role == "Admin")
        <li class="nav-item mt-2">
          <a class="nav-link" href="{{route('timelineadm')}}">
            <i class="far fa-bell fa-lg"></i>
          </a>
        </li>
        @endif
        @if(auth()->user()->role == "Dosen")
        <li class="nav-item mt-2">
          <a class="nav-link" href="{{route('timelinedsn')}}">
            <i class="far fa-bell fa-lg"></i>
          </a>
        </li>
        @endif
        @if(auth()->user()->role == "Mahasiswa")
        <li class="nav-item mt-2 ">
          <a class="nav-link" href="{{route('timelinemhs')}}">
            <i class="far fa-bell fa-lg"></i>
          </a>
        </li>
        @endif

        @php
        $periode = \App\Models\Periode::where('status', '1')->first();
        @endphp
        @if($periode != null)
        <li class="nav-item mt-1 mr-2">
        <b>{{ substr($periode->tahun_ajaran,4) == '1' ? 'Ganjil' : 'Genap' }} {{ substr($periode->tahun_ajaran,0,4) }}</b>
        </li>
        
        <li class="nav-item mt-1 mr-4">
          <b>[<b>{{auth()->user()->no_induk}}</b>]</b>
          <b>{{auth()->user()->name}}</b>
        </li>
       
        @endif
        <ul class="navbar-nav ml-auto">
          <li class="nav-item d-none d-sm-inline-block">
            <a class="btn btn-danger" href="{{route('logout')}}" onclick="return confirm('Apakah Anda yakin akan logout ?')" role="button">Log Out</a>
          </li>
        </ul>
        <!-- <li class="nav-item mt-1">
          <a href="{{route('logout')}}" onclick="return confirm('Apakah Anda yakin akan logout ?')">Logout</a>
        </li> -->
        <!-- <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <b>[<b>{{auth()->user()->no_induk}}</b>]</b>
            <b>{{auth()->user()->name}}</b>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <div class="dropdown-divider"></div>
            <a href="{{route('logout')}}" onclick="return confirm('Apakah Anda yakin akan logout ?')" class="dropdown-item dropdown-footer " style="color:red">Logout</a>
          </div>
        </li> -->

      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="" class="brand-link">
        <img src="{{asset('AdminLTE-3.2.0\dist\img\LOGO UKDW WARNA PNG.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">SIPTERPAN</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="info">
            <span class="d-block text-white">{{auth()->user()->name}}</span>
            <span class="d-block text-white">{{auth()->user()->role}}</span>
          </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            @include('template.sidebar')
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      @yield('content')

    </div>
    <!-- /.content-wrapper -->


    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="{{asset('AdminLTE-3.2.0/plugins/jquery/jquery.min.js')}}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{asset('AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <!-- AdminLTE App -->
  <script src="{{asset('AdminLTE-3.2.0/dist/js/adminlte.min.js')}}"></script>
  <!-- date-range-picker -->
  <script src="{{asset('AdminLTE-3.2.0/plugins/daterangepicker/daterangepicker.js')}}"></script>
  <!-- fullCalendar 2.2.5 -->
  <script src="{{asset('AdminLTE-3.2.0/plugins/moment/moment.min.js')}}"></script>
  <script src="{{asset('AdminLTE-3.2.0/plugins/fullcalendar/main.js')}}"></script>
  <!-- ChartJS -->
  <script src="{{asset('AdminLTE-3.2.0/plugins/chart.js/Chart.min.js')}}"></script>
  <!-- jQuery Knob Chart -->
  <script src="{{asset('AdminLTE-3.2.0/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
  <!-- DataTables  & Plugins -->
  <script src="{{asset('AdminLTE-3.2.0/plugins/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('AdminLTE-3.2.0/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>

  <!-- Toastr -->
  <script src="{{asset('AdminLTE-3.2.0/plugins/toastr/toastr.min.js')}}"></script>

  <script type="text/javascript">
    var message = "{{ Session::get('message') }}";
    var type = "{{ Session::get('alert-type','info') }}";

    console.log(message, type);

    if (message) {
      switch (type) {
        case "info":
          toastr.info(message);
          break;
        case "success":
          toastr.success(message);
          break;
        case "warning":
          toastr.warning(message);
          break;
        case "error":
          toastr.error(message);
          break;
      }
    }
  </script>
  @stack('alpine-plugins')
  <!-- Alpine Core -->
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</body>

</html>