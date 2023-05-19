@extends('template.master')
<title>Notifikasi</title>
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Notifikasi</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Beranda</a></li>
          <li class="breadcrumb-item active">Notifikasi</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
<div class="container-fluid">

  <!-- Timelime example  -->
  <div class="row">
    <div class="col-md-12">
      <!-- The time line -->
      <div class="timeline">
        <!-- timeline time label -->
        @foreach($notif as $notifikasi => $aktivitas)
        <div class="time-label">
          <span class="bg-red">{{date('d F Y', strtotime($notifikasi))}}</span>
        </div>
        <!-- /.timeline-label -->
        <!-- timeline item -->
        @foreach($aktivitas as $item)
        <div>
          <i class="fas fa-envelope bg-blue"></i>
          <div class="timeline-item">
            <span class="time"><i class="fas fa-clock"></i>{{date('h:i a', strtotime($item->created_at))}}</span>
            <h3 class="timeline-header"><a href="#">{{$item->usern->name}}</a> </h3>

            <div class="timeline-body">
              {{$item->judul}} pada proyek {{ optional($item->projectn)->nama }}
            </div>
          </div>
        </div>
        @endforeach
        @endforeach
        <!-- END timeline item -->
        <div>
          <i class="fas fa-clock bg-gray"></i>
        </div>
      </div>
    </div>
    <!-- /.col -->
  </div>
</div>
@endsection