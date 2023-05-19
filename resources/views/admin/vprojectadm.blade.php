@extends('template.master')
<title>Proyek</title>
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                @foreach($prjk as $prj)
                <h1 class="m-0">Proyek {{$prj->nama}}</h1>

            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Beranda</a></li>
                    <li class="breadcrumb-item active">Proyek {{$prj->nama}}</li>
                </ol>
            </div><!-- /.col -->
            @endforeach
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="container-fluid">
    <div class="card" x-data="{ currentTab: $persist('dashboard') }">
        <div class="card-header p-2">
            <ul class="nav nav-pills" wire:ignore>
                <li @click.prevent="currentTab = 'dashboard'" class="nav-item"><a class="nav-link" :class="currentTab === 'dashboard' ? 'active' : ''" href="#dashboard" data-toggle="tab"><i class="fa fa-tachometer-alt mr-1"></i> Dashboard</a></li>
                <li @click.prevent="currentTab = 'timeline'" class="nav-item"><a class="nav-link" :class="currentTab === 'timeline' ? 'active' : ''" href="#timeline" data-toggle="tab"><i class="fa fa-calendar mr-1"></i> Linimasa</a></li>
                <li @click.prevent="currentTab = 'detail'" class="nav-item"><a class="nav-link" :class="currentTab === 'detail' ? 'active' : ''" href="#detail" data-toggle="tab"><i class="fa fa-info mr-1"></i> Detail</a></li>
            </ul>
        </div><!-- /.card-header -->
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane" :class="currentTab === 'dashboard' ? 'active' : ''" id="dashboard" wire:ignore.self>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="info-box">
                                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-list"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Project</span>
                                        <span class="info-box-number">

                                        </span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="info-box mb-3">
                                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-user-tie"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Dosen</span>
                                        <span class="info-box-number"></span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->

                            <!-- fix for small devices only -->
                            <div class="clearfix hidden-md-up"></div>

                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="info-box mb-3">
                                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-user-graduate"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Mahasiswa</span>
                                        <span class="info-box-number"></span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="info-box mb-3">
                                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Total User</span>
                                        <span class="info-box-number"></span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-header border-0">
                                    </div>
                                    <div class="card-body">

                                    </div>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!-- /.col-md-6 -->
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-header border-0">
                                    </div>
                                    <div class="card-body">

                                    </div>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!-- /.col-md-6 -->
                        </div>
                    </div>
                </div>
                <div class="tab-pane" :class="currentTab === 'timeline' ? 'active' : ''" id="timeline" wire:ignore.self>
                    <div class="row">
                        <div class="col-md-12">
                            <!-- The time line -->
                            <div class="timeline">
                                <!-- timeline time label -->
                                @foreach($notifp as $notifikasi => $aktivitas)
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
                                            {{$item->judul}}
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
                <div class="tab-pane" :class="currentTab === 'detail' ? 'active' : ''" id="detail" wire:ignore.self>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Detail Proyek</h3>
                        </div>
                        <div class="card-body">

                            @foreach($prjk as $prj)
                            <b>Project name</b> &emsp; &emsp; &emsp; &emsp; &emsp; {{$prj->nama}}</br>
                            <b>Deskripsi</b> &emsp; &emsp; &emsp; &emsp; &emsp; &emsp; &ensp;{{$prj->deskripsi}}</br>
                            @foreach($pterpan1 as $dpters)
                            @if($prj->dosen == $dpters->no_induk)
                            <b>Dosen Pembimbing</b> &emsp; &emsp; &emsp;{{$dpters->name}}</br>
                            @endif
                            @endforeach

                            @foreach($history as $no_induk)
                            @if(!empty($prj->mahasiswa1) && $prj->mahasiswa1 == $no_induk)
                            @php
                            $mahasiswa = \App\Models\History::where('no_induk', $no_induk)->first();
                            @endphp
                            <b>Mahasiswa 1</b>&emsp; &emsp; &emsp; &emsp; &emsp; &ensp;{{$mahasiswa->nama}}</br>
                            @endif
                            @endforeach

                            @foreach($history as $no_induk)
                            @if(!empty($prj->mahasiswa2) && $prj->mahasiswa2 == $no_induk)
                            @php
                            $mahasiswa = \App\Models\History::where('no_induk', $no_induk)->first();
                            @endphp
                            <b>Mahasiswa 2</b>&emsp; &emsp; &emsp; &emsp; &emsp; &ensp;{{$mahasiswa->nama}}</br>
                            @endif
                            @endforeach

                            @foreach($history as $no_induk)
                            @if(!empty($prj->mahasiswa3) && $prj->mahasiswa3 == $no_induk)
                            @php
                            $mahasiswa = \App\Models\History::where('no_induk', $no_induk)->first();
                            @endphp
                            <b>Mahasiswa 3</b>&emsp; &emsp; &emsp; &emsp; &emsp; &ensp;{{$mahasiswa->nama}}</br>
                            @endif
                            @endforeach

                            <b>Start</b>&emsp; &emsp; &emsp; &emsp; &emsp; &emsp; &emsp; &ensp; &ensp; {{date('d-m-Y', strtotime($prj->mulai))}}</br>
                            <b>End</b>&emsp; &emsp; &emsp; &emsp; &emsp; &emsp; &emsp; &emsp; &ensp; {{date('d-m-Y', strtotime($prj->jatuh_tempo))}}</br>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div><!-- /.card-body -->
    </div>
    <!-- /.card -->

</div>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

<script>
    $(function() {
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>
@push('alpine-plugins')
<!-- Alpine Plugins -->
<script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/persist@3.x.x/dist/cdn.min.js"></script>
@endpush


@endsection