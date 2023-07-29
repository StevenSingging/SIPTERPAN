@extends('template.master')
<title>Dashboard Dosen</title>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
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
          <span class="info-box-text">Total Proyek</span>
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
          <span class="info-box-number">{{$cprjcts}}</span>
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
          <span class="info-box-number">{{$cprjcto}}</span>
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
          <span class="info-box-number">{{$cprjctf}}</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
  </div>
  <div class="container-fluid">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Daftar Proyek</h3>
      </div>
      <div class="card-body p-0">
        <table id="lproject" class="table table-striped projects">
          <thead>
            <tr>
              <th>
                No
              </th>
              <th>
                Nama Proyek
              </th>
              <th style="width: 20%">
                Anggota
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
              
              <td>
                @foreach($history as $no_induk)
                @if(!empty($dprjct->mahasiswa1 == $no_induk))
                @php
                $mahasiswa1 = \App\Models\History::where('no_induk', $no_induk)->first();
                @endphp
                {{$mahasiswa1->nama}}<br>
                @endif

                @if(!empty($dprjct->mahasiswa2 == $no_induk))
                @php
                $mahasiswa2= \App\Models\History::where('no_induk', $no_induk)->first();
                @endphp
                {{$mahasiswa2->nama}}<br>
                @endif

                @if(!empty($dprjct->mahasiswa3 == $no_induk))
                @php
                $mahasiswa3 = \App\Models\History::where('no_induk', $no_induk)->first();
                @endphp
                {{$mahasiswa3->nama}}</br>
                @endif
                @endforeach
              </td>

              @foreach($pterpan as $dpter)
              @if($dprjct-> dosen == $dpter->no_induk)
              <td>{{$dpter->name}}</td>
              @endif
              @endforeach

              <td>{{date('d F Y', strtotime($dprjct->jatuh_tempo))}}</td>

              <td class="project-state">
                @if($dprjct->status == '1')
                <span class="badge badge-success">Selesai</span>
                @elseif($dprjct->status == '0')
                <span class="badge badge-warning">Dalam Progress</span>
                @elseif($dprjct->status == '2')
                <span class="badge badge-warning">Gagal</span>
                @endif
              </td>
              <td class="project-actions text-right">
                @if($dprjct->status == '0')
                <a class="btn btn-primary btn-sm" href="{{url('dosen/vprojectdsn',$dprjct->id)}}">
                  <i class="fas fa-folder">
                  </i>
                </a>
                @endif
                <a class="btn btn-primary btn-sm" href="{{url('dosen/downloadrekap',$dprjct->id)}}" target="_blank">
                  <i class="fas fa-download"></i>
                </a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script>
  $(function() {
    $('#lproject').DataTable({
      "dom": '<"top"i>rt<"bottom"p><"clear">',
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": false,
      "autoWidth": false,
      "responsive": true,
      "pageLength": 3,
    });
  });
</script>
@endsection