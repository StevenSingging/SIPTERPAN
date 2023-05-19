@extends('template.master')
<title>Dashboard Mahasiswa</title>
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
                    <li class="breadcrumb-item"><a href="{{route('mahasiswa')}}">Beranda</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-list"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total Project</span>
                    <span class="info-box-number">
                    {{$cprjct}}

                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- /.col -->

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fa-solid fa-check"></i></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Proyek Selesai</span>
                    <span class="info-box-number">
                    {{$cprjctd}}
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fa-solid fa-spinner"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Proyek Dalam Progres</span>
                    <span class="info-box-number">
                    {{$cprjcto}}
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fa-solid fa-xmark"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Proyek Gagal</span>
                    <span class="info-box-number">
                    {{$cprjctf}}
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Proyek</h3>
        </div>
        <div class="card-body p-0">
            <table id="project" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>
                            No
                        </th>
                        <th>
                            Nama Proyek
                        </th>
                        <th style="width: 20%">
                            Anggota Tim
                        </th>
                        <th>
                            Dosen Pembimbing
                        </th>
                        <th>
                            Deadline
                        </th>
                        <th>
                            Status
                        </th>
                        <th>

                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php $no=1; @endphp
                    @foreach($project as $dprjct)
                    <tr>
                        <td scope="row"><?php echo e($no++) + (($project->currentPage() - 1) * $project->perPage()) ?></td>
                        <td>
                            <a>
                                {{$dprjct->nama}}
                            </a>
                            <br />
                            <small>
                                Dibuat {{date('d F Y', strtotime($dprjct->created_at))}}
                            </small>
                        </td>
                        @foreach($history as $no_induk)
                        @if(!empty($dprjct->mahasiswa1 == $no_induk))
                        @php
                        $mahasiswa = \App\Models\History::where('no_induk', $no_induk)->first();
                        @endphp
                        <td>{{$mahasiswa->nama}}<br>
                            @endif

                            @if(!empty($dprjct->mahasiswa2 == $no_induk))
                            @php
                            $mahasiswa = \App\Models\History::where('no_induk', $no_induk)->first();
                            @endphp
                            {{$mahasiswa->nama}}
                            @endif

                            @if(!empty($dprjct->mahasiswa3 == $no_induk))
                            @php
                            $mahasiswa = \App\Models\History::where('no_induk', $no_induk)->first();
                            @endphp
                            {{$mahasiswa->nama}}</br>
                            @endif
                            @endforeach
                        </td>


                        @foreach($pterpan as $dpter)
                        @if($dprjct-> dosen == $dpter->no_induk)
                        <td>{{$dpter->name}}</td>
                        @endif
                        @endforeach
                        <td>{{date('d F Y', strtotime($dprjct->jatuh_tempo))}}</td>
                        @if($dprjct->status == '1')
                        <td><span class="badge badge-success">Done</span></td>
                        @elseif($dprjct->status == '0')
                        <td><span class="badge badge-warning">On Progress</span></td>
                        @endif
                        @if($dprjct->status == '0')
                        <td class="project-actions text-right">
                            <a class="btn btn-primary btn-sm" href="{{url('mahasiswa/vproject',$dprjct->id)}}">
                                <i class="fas fa-folder">
                                </i>
                                View
                            </a> 
                        </td>
                        @else
                        <td></td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
</div>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script>
    $(function() {
        $('#project').DataTable({
            "dom": '<"top"i>rt<"bottom"p><"clear">',
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": false,
            "autoWidth": false,
            "responsive": true,
            "pageLength": 10,
        });
    });
</script>
@endsection