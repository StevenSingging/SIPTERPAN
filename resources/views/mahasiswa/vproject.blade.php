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

    <div class="card" x-data="{ currentTab: $persist('milestone') }">
        <div class="card-header p-2">
            <ul class="nav nav-pills" wire:ignore>
                <li @click.prevent="currentTab = 'milestone'" class="nav-item"><a class="nav-link" :class="currentTab === 'milestone' ? 'active' : ''" href="#milestone" data-toggle="tab"><i class="fa fa-flag mr-1"></i> Milestone</a></li>
                <li @click.prevent="currentTab = 'konsul'" class="nav-item"><a class="nav-link" :class="currentTab === 'konsul' ? 'active' : ''" href="#konsul" data-toggle="tab"><i class="fa fa-id-card mr-1"></i> Kartu Konsul</a></li>
                <li @click.prevent="currentTab = 'dashboard'" class="nav-item"><a class="nav-link" :class="currentTab === 'dashboard' ? 'active' : ''" href="#dashboard" data-toggle="tab"><i class="fa fa-tachometer-alt mr-1"></i> Dashboard</a></li>
                <li @click.prevent="currentTab = 'logbook'" class="nav-item"><a class="nav-link" :class="currentTab === 'logbook' ? 'active' : ''" href="#logbook" data-toggle="tab"><i class="fa fa-book mr-1"></i> Logbook</a></li>
                <li @click.prevent="currentTab = 'files'" class="nav-item"><a class="nav-link" :class="currentTab === 'files' ? 'active' : ''" href="#files" data-toggle="tab"><i class="fa fa-file mr-1"></i> File</a></li>
                <li @click.prevent="currentTab = 'conversation'" class="nav-item"><a class="nav-link" :class="currentTab === 'conversation' ? 'active' : ''" href="#conversation" data-toggle="tab"><i class="fa fa-comments mr-1"></i> Diskusi</a></li>
                <li @click.prevent="currentTab = 'timeline'" class="nav-item"><a class="nav-link" :class="currentTab === 'timeline' ? 'active' : ''" href="#timeline" data-toggle="tab"><i class="fa fa-calendar"></i> Linimasa</a></li>
                <li @click.prevent="currentTab = 'detail'" class="nav-item"><a class="nav-link" :class="currentTab === 'detail' ? 'active' : ''" href="#detail" data-toggle="tab"><i class="fa fa-info mr-1"></i> Detail</a></li>
            </ul>
        </div><!-- /.card-header -->
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane" :class="currentTab === 'milestone' ? 'active' : ''" id="milestone" wire:ignore.self>
                    <div id="accordion">
                        @foreach($milestonemhs as $milemhs=>$value)
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link" data-toggle="collapse" data-target="#milestone{{$value->id}}" aria-expanded="true" aria-controls="collapseOne" style="color:black">
                                                {{$value->nama}}
                                            </button>

                                        </h5>
                                    </div>
                                    <div class="col">
                                        @if($value->status == 1)
                                        <h5 style="float: right;"><span class="badge badge-success">Mengumpulkan</span></h5>
                                        @elseif($value->status == 2)
                                        <h5 style="float: right;"><span class="badge badge-danger">Tidak Mengumpulkan</span></h5>
                                        @else
                                        <h5 style="float: right;"><span class="badge badge-warning">On Progress</span></h5>
                                        @endif
                                    </div>
                                </div>


                            </div>

                            <div id="milestone{{$value->id}}" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                <div class="card-body">
                                    {{$value->deskripsi}}</br>
                                    Ketentuan Tugas : <br>
                                    - Tugas Terakhir dikumpukan <b> tanggal {{date('d F Y', strtotime($value->jatuh_tempo))}}</b><br>
                                    - Tugas boleh dikumpul ulang <small>(file terakhir kumpul yang akan dinilai)</small>
                                    <form action="{{url('/mahasiswa/updatemilestone',[$value->id, $value->file_id])}}" method="post" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label>Kumpul File</label>
                                            @if(!empty($value->filem))
                                            <p>{{ $value->filem->file_name }}</p>
                                            @endif

                                            @if($value->status == '2')

                                            @elseif($value->status == '1' && $value->jatuh_tempo < date('Y-m-d')) 

                                            @elseif($value->status == '1' && $value->jatuh_tempo >= date('Y-m-d'))
                                                <input type="file" name="filec" class="form-control">
                                            @elseif($value->status == '0' )
                                                <input type="file" name="filec" class="form-control">
                                            @endif

                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                @if($value->status == '2')

                                                @elseif($value->status == '1' && $value->jatuh_tempo < date('Y-m-d')) 

                                                @elseif($value->status == '1' && $value->jatuh_tempo >= date('Y-m-d'))
                                                <input type="reset" value="Reset" class="btn btn-danger ">
                                                <input type="submit" value="Submit" class="btn btn-success ">
                                                @elseif($value->status == '0' )
                                                <input type="reset" value="Reset" class="btn btn-danger ">
                                                <input type="submit" value="Submit" class="btn btn-success ">
                                                @endif
                                                    
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane" :class="currentTab === 'konsul' ? 'active' : ''" id="konsul" wire:ignore.self>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <nav class="navbar navbar ">

                                        </nav>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <table id="example2" class="table table-bordered table-hover">
                                            <thead>
                                                <tr align="center">
                                                    <th>No</th>
                                                    <th>Tanggal</th>
                                                    <th>Nama Konsultasi</th>
                                                    <th>Deskripsi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $no=1; @endphp

                                                @foreach($konsulmhs as $kkmhs)
                                                @foreach($idArray as $id)
                                                @if($id == auth()->user()->no_induk)
                                                <tr align="center">
                                                    <td scope="row"><?php echo e($no++) + (($konsulmhs->currentPage() - 1) * $konsulmhs->perPage()) ?></td>
                                                    <td>{{date('d F Y', strtotime($kkmhs->tgl_konsul))}}</td>
                                                    <td>{{$kkmhs->name}}</td>
                                                    <td>{{$kkmhs->deskripsi}}</td>
                                                </tr>
                                                @endif
                                                @endforeach
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                </div>
                <div class="tab-pane" :class="currentTab === 'dashboard' ? 'active' : ''" id="dashboard" wire:ignore.self>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6 col-6">
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3>{{$cmile}}</h3>
                                        <h4>Total Milestone</h4>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-flag"></i>
                                    </div>
                                   
                                </div>
                            </div>

                            <div class="col-sm-6 col-6">
                                <div class="small-box bg-success">
                                    <div class="inner">
                                        <h3>{{$clog}}</h3>
                                        <h4>Total Logbook</h4>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-book"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header border-0">
                                    </div>
                                    <div class="card-body">
                                    {!! $chart->container() !!}
                                    </div>
                                </div>
                                <!-- /.card -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" :class="currentTab === 'logbook' ? 'active' : ''" id="logbook" wire:ignore.self>
                    <div class="card">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card-header card-outline card-primary">
                                    Tambah Logbook
                                </div>
                                <div class="card-body ">

                                    <form action="{{route('simpanlogbook')}}" method="post">
                                        {{ csrf_field() }}
                                        @foreach($prjk as $prj)
                                        <div class="form-group" hidden>
                                            <label for="inputName">Project id</label>
                                            <input type="text" name="project_id" class="form-control" value="{{$prj->id}}" readonly>
                                        </div>
                                        @endforeach
                                        <div class="form-group">
                                            <label for="inputName">Tanggal</label>
                                            <input type="date" name="tgl_logbook" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="inputName">Kegiatan</label>
                                            <input type="text" name="kegiatan" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="inputDescription">Description</label>
                                            <textarea name="deskripsi" class="form-control" rows="4"></textarea>
                                        </div>


                                        <div class="row">
                                            <div class="col-12">
                                                <input type="reset" value="Reset" class="btn btn-danger ">
                                                <input type="submit" value="Buat Logbook Baru" class="btn btn-success ">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-6 ">
                                <div class="card card-primary card-outline card-outline-tabs">
                                    <div class="card-header p-0 border-bottom-0">
                                        <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="olog-tab" data-toggle="tab" href="#olog" role="tab" aria-controls="olog" aria-selected="true">Logbook Lainnya</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content" id="custom-tabs-four-tabContent">
                                            <div class="tab-pane fade show active" id="olog" role="tabpanel" aria-labelledby="olog-tab">
                                                <div class="card">

                                                    <table id="otherl" class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 10px">No</th>
                                                                <th>Kegiatan</th>
                                                                <th>Tanggal</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php $no=1; @endphp
                                                            @foreach($logmhs as $lmhs)
                                                            <tr align="center">
                                                                <td scope="row"><?php echo e($no++) + (($logmhs->currentPage() - 1) * $logmhs->perPage()) ?></td>
                                                                <td>{{$lmhs->kegiatan}}</td>
                                                                <td>{{date('d F Y', strtotime($lmhs->tgl_logbook))}}</td>
                                                                <td>
                                                                    <a href="#editlogbook{{$lmhs->id}}" data-toggle="modal"><i class="fas fa-edit"></i></a> |
                                                                    <a href="{{url('mahasiswa/deletelogbook',$lmhs->id)}}" onclick="return confirm('Apakah Anda yakin data akan dihapus ?')" role="button"><i class="fas fa-trash" style="color : red"></i></a>
                                                                </td>
                                                            </tr>
                                                            <div class="modal fade" id="editlogbook{{$lmhs->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLabel">Edit Logbook</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form action="{{url('mahasiswa/updatelogbook',$lmhs->id)}}" method="post" enctype="multipart/form-data">
                                                                                {{ csrf_field() }}
                                                                                @foreach($prjk as $prj)
                                                                                <div class="form-group" hidden>
                                                                                    <label for="inputName">Project id</label>
                                                                                    <input type="text" name="project_id" class="form-control" value="{{$prj->id}}" readonly>
                                                                                </div>
                                                                                @endforeach
                                                                                <div class="form-group">
                                                                                    <label for="inputName">Tanggal</label>
                                                                                    <input type="date" value="{{$lmhs->tgl_logbook}}" name="tgl_logbook" class="form-control">
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label>Kegiatan</label>
                                                                                    <input type="text" value="{{$lmhs->kegiatan}}" name="kegiatan" class="form-control">
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label>Deskripsi</label>
                                                                                    <textarea name="deskripsi" class="form-control" rows="4">{{$lmhs->deskripsi}}</textarea>
                                                                                </div>

                                                                                <div class="modal-footer justify-content-between">
                                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                                                                        <i class="fa fa-times"> </i> Tutup
                                                                                    </button>

                                                                                    <button type="submit" class="btn btn-primary">
                                                                                        <i class="fa fa-save"></i> Simpan Data
                                                                                    </button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card -->
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="tab-pane" :class="currentTab === 'files' ? 'active' : ''" id="files" wire:ignore.self>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <table id="file" class="table table-bordered table-hover">
                                            <thead>
                                                <tr align="center">
                                                    <th>No</th>
                                                    <th>Nama File</th>
                                                    <th>Tanggal Upload</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $no=1; @endphp
                                                @foreach($file as $dfile)
                                                <tr align="center">
                                                    <td scope="row"><?php echo e($no++) + (($file->currentPage() - 1) * $file->perPage()) ?></td>
                                                    <td>{{$dfile->file_name}}</td>
                                                    <td>{{$dfile->updated_at}}</td>
                                                    <td>
                                                        <a class="btn btn-primary btn-sm" href="{{ route('downloadfile', ['id' => $dfile->id]) }}" ><i class="fas fa-download"></i></a>
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
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                </div>
                <div class="tab-pane" :class="currentTab === 'conversation' ? 'active' : ''" id="conversation" wire:ignore.self>
                    <div class="card">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card-header card-outline card-primary">
                                    Memulai Diskusi
                                </div>
                                <div class="card-body ">

                                    <form action="{{route('simpanconvers')}}" method="post" enctype="multipart/form-data" id="save-form">
                                        {{ csrf_field() }}
                                        @foreach($prjk as $prj)
                                        <div class="form-group" hidden>
                                            <input type="text" name="project_id" class="form-control" value="{{$prj->id}}" readonly>
                                        </div>
                                        @endforeach
                                        <div class="form-group">
                                            <input type="text" name="judul" class="form-control" placeholder="Masukkan Judul">
                                        </div>
                                        <div class="form-group">
                                            <textarea name="teks" class="form-control" rows="4" placeholder="Masukkan Pesan"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <input type="file" name="filec" class="form-control">
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <input type="reset" value="Reset" class="btn btn-danger ">
                                                <input type="submit" value="Buat Diskusi baru" class="btn btn-success ">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="col-md-6 ">
                                @foreach($conver as $convers)
                                <!-- DIRECT CHAT -->
                                <div class="card direct-chat direct-chat-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">{{ $convers->judul }}</h3>

                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <!-- Conversations are loaded here -->
                                        <div class="direct-chat-messages">
                                            @if($convers->user_id == auth()->user()->id)
                                            <!-- Message. Default to the left -->
                                            <div class="direct-chat-msg right">
                                                <div class="direct-chat-infos clearfix">
                                                    <span class="direct-chat-name float-right">{{ $convers->user->name }}</span>
                                                    <span class="direct-chat-timestamp float-left">{{date('j F Y h:i A', strtotime($convers->created_at))}}</span>
                                                </div>
                                                <!-- /.direct-chat-img -->
                                                <div class="direct-chat-text">
                                                    @if($convers->file_id != null)
                                                    <h6>{{$convers->file->file_name }}</h6><span><a href="{{ route('downloadfile', ['id' => $convers->file->id]) }}" role="button"><i class="fas fa-download" style="color : white"></i></a></span><br>
                                                    @endif
                                                    {{ $convers->teks }}
                                                </div>
                                                <!-- /.direct-chat-text -->
                                            </div>
                                            @endif
                                            @if($convers->user_id != auth()->user()->id)
                                            <!-- Message. Default to the left -->
                                            <div class="direct-chat-msg">
                                                <div class="direct-chat-infos clearfix">
                                                    <span class="direct-chat-name float-left">{{ $convers->user->name }}</span>
                                                    <span class="direct-chat-timestamp float-right">{{date('j F Y h:i A', strtotime($convers->created_at))}}</span>
                                                </div>

                                                <!-- /.direct-chat-img -->
                                                <div class="direct-chat-text">
                                                    @if($convers->file_id != null)
                                                    <h6>{{$convers->file->file_name }}</h6><span><a href="{{ route('downloadfile', ['id' => $convers->file->id]) }}" role="button"><i class="fas fa-download"></i></a></span><br>
                                                    @endif
                                                    {{ $convers->teks }}
                                                </div>
                                                <!-- /.direct-chat-text -->
                                            </div>
                                            @endif
                                            <!-- /.direct-chat-msg -->
                                            @foreach($converr as $item)
                                            @if($item->conversation_id == $convers->id && $item->user_id == auth()->user()->id)
                                            <!-- Message to the right -->
                                            <div class="direct-chat-msg right">
                                                <div class="direct-chat-infos clearfix">
                                                    <span class="direct-chat-name float-right">{{ $item->user->name }}</span>
                                                    <span class="direct-chat-timestamp float-left">{{date('j F Y h:i A', strtotime($item->created_at))}}</span>
                                                </div>
                                                <!-- /.direct-chat-infos -->

                                                <!-- /.direct-chat-img -->
                                                <div class="direct-chat-text">
                                                    @if($item->file_id != null)
                                                    <h6>{{$item->file->file_name }}</h6><span><a href="{{ route('downloadfile', ['id' => $item->file->id]) }}" role="button"><i class="fas fa-download" style="color : white"></i></a></span><br>
                                                    @endif
                                                    {{ $item->teks }}
                                                </div>
                                                <!-- /.direct-chat-text -->
                                            </div>
                                            <!-- /.direct-chat-msg -->
                                            @endif
                                            @if($item->conversation_id == $convers->id && $item->user_id != auth()->user()->id)
                                            <div class="direct-chat-msg ">
                                                <div class="direct-chat-infos clearfix">
                                                    <span class="direct-chat-name float-left">{{ $item->user->name }}</span>
                                                    <span class="direct-chat-timestamp float-right">{{date('j F Y h:i A', strtotime($item->created_at))}}</span>
                                                </div>
                                                <!-- /.direct-chat-infos -->
                                                <!-- /.direct-chat-img -->
                                                <div class="direct-chat-text">
                                                    @if($item->file_id != null)
                                                    <h6>{{$item->file->file_name }}</h6><span><a href="{{ route('downloadfile', ['id' => $item->file->id]) }}" role="button"><i class="fas fa-download" style="color : blue"></i></a></span><br>
                                                    @endif
                                                    {{ $item->teks }}
                                                </div>
                                                <!-- /.direct-chat-text -->
                                            </div>
                                            <!-- /.direct-chat-msg -->
                                            @endif
                                            @endforeach

                                        </div>
                                        <!--/.direct-chat-messages-->

                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <form action="{{route('simpanconverreply')}}" method="post" enctype="multipart/form-data" id="save-form">
                                            {{ csrf_field() }}
                                            @foreach($prjk as $prj)
                                            <input type="text" name="project_id" class="form-control" value="{{$prj->id}}" readonly hidden>
                                            @endforeach
                                            <input type="text" name="conver_id" class="form-control" value="{{$convers->id}}" readonly hidden>
                                            <div class="form-group">
                                                `<textarea name="teks" class="form-control" rows="2" placeholder="Enter Message"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <input type="file" name="filec" class="form-control">
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <input type="reset" value="Reset" class="btn btn-danger ">
                                                    <input type="submit" value="Submit" class="btn btn-success ">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /.card-footer-->
                                </div>
                                <!--/.direct-chat -->
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>
                <div class="tab-pane" :class="currentTab === 'timeline' ? 'active' : ''" id="timeline" wire:ignore.self>
                    <div class="container-fluid">
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
                </div>
                <div class="tab-pane" :class="currentTab === 'detail' ? 'active' : ''" id="detail" wire:ignore.self>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Detail Project</h3>
                        </div>
                        <div class="card-body">
                            @foreach($prjk as $prj)
                            <b>Project name</b> &emsp; &emsp; &emsp; &emsp; &emsp; {{$prj->nama}}</br>
                            <b>Deskripsi</b> &emsp; &emsp; &emsp; &emsp; &emsp; &emsp; &ensp;{{$prj->deskripsi}}</br>
                            @foreach($pterpan as $dpter)
                            @if($prj->dosen == $dpter->no_induk)
                            <b>Dosen Pembimbing</b> &emsp; &emsp; &emsp;{{$dpter->name}}</br>
                            @endif
                            @endforeach

                            @foreach($history as $no_induk)
                            @php
                            $mahasiswa = \App\Models\History::where('no_induk', $no_induk)->first();
                            @endphp
                            @if(!empty($prj->mahasiswa1 == $no_induk))
                            <b>Mahasiswa 1</b>&emsp; &emsp; &emsp; &emsp; &emsp; &ensp;{{$mahasiswa->nama}}</br>
                            @endif
                            @endforeach

                            @foreach($history as $no_induk)
                            @php
                            $mahasiswa = \App\Models\History::where('no_induk', $no_induk)->first();
                            @endphp
                            @if(!empty($prj->mahasiswa2 == $no_induk))
                            <b>Mahasiswa 2</b>&emsp; &emsp; &emsp; &emsp; &emsp; &ensp;{{$mahasiswa->nama}}</br>
                            @endif
                            @endforeach

                            @foreach($history as $no_induk)
                            @php
                            $mahasiswa = \App\Models\History::where('no_induk', $no_induk)->first();
                            @endphp
                            @if(!empty($prj->mahasiswa3 == $no_induk))
                            <b>Mahasiswa 3</b>&emsp; &emsp; &emsp; &emsp; &emsp; &ensp;{{$mahasiswa->nama}}</br>
                            @endif
                            @endforeach
                            <b>Tanggal Mulai</b>   &ensp; &emsp; &emsp; &emsp; &ensp; &ensp; {{date('d F Y', strtotime($prj->mulai))}}</br>
                            <b>Tanggal Selesai</b>   &ensp; &emsp; &emsp; &emsp; &ensp; {{date('d F Y', strtotime($prj->jatuh_tempo))}}</br>
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

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
@push('alpine-plugins')
<!-- Alpine Plugins -->
<script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/persist@3.x.x/dist/cdn.min.js"></script>
@endpush
<script>
    $(function() {
        $('#example2').DataTable({
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
        $('#file').DataTable({
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
        $('#otherl').DataTable({
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
<script src="{{ $chart->cdn() }}"></script>

{{ $chart->script() }}

@endsection