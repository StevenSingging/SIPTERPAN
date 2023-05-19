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
                    <div class="card">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card-header card-outline card-primary">
                                    Tambah Milestone
                                </div>
                                <div class="card-body ">

                                    <form action="{{route('simpanmilestone')}}" method="post">
                                        {{ csrf_field() }}
                                        @foreach($prjk as $prj)
                                        <div class="form-group" hidden>
                                            <label for="inputName">Project id</label>
                                            <input type="text" name="project_id" class="form-control" value="{{$prj->id}}" readonly>
                                        </div>
                                        @endforeach
                                        <div class="form-group">
                                            <label for="inputName">Nama Milestone</label>
                                            <input type="text" name="nama" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="inputDescription">Deskripsi</label>
                                            <textarea name="deskripsi" class="form-control" rows="4"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputName">Tanggal Mulai</label>
                                            <input type="date" name="mulai" class="form-control @error('mulai') is-invalid @enderror" value="{{old('mulai')}}">
                                            @error('mulai')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="inputName">Tanggal Selesai</label>
                                            <input type="date" name="jatuh_tempo" class="form-control @error('jatuh_tempo') is-invalid @enderror" value="{{old('jatuh_tempo')}}">
                                            @error('jatuh_tempo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <input type="reset" value="Reset" class="btn btn-danger ">
                                                <input type="submit" value="Buat Milestone baru" class="btn btn-success ">
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
                                                <a class="nav-link active" id="sproject-tab" data-toggle="pill" href="#sproject" role="tab" aria-controls="sproject" aria-selected="true">Proyek Terpilih</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="omilestone-tab" data-toggle="pill" href="#omilestone" role="tab" aria-controls="omilestone" aria-selected="false">Milestone Lainnya</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content" id="custom-tabs-four-tabContent">
                                            <div class="tab-pane fade show active" id="sproject" role="tabpanel" aria-labelledby="sproject-tab">
                                                @foreach($prjk as $prj)
                                                <div class="form-group">
                                                    <label for="inputName">Nama Proyek</label>
                                                    <input type="text" name="nama" class="form-control" value="{{$prj->nama}}" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputDescription">Deskripsi</label>
                                                    <textarea class="form-control" rows="4" disabled>{{$prj->deskripsi}}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputName">Tanggal Mulai</label>
                                                    <input type="date" class="form-control " value="{{$prj->mulai}}" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputName">Tanggal Selesai</label>
                                                    <input type="date" class="form-control" value="{{$prj->jatuh_tempo}}" disabled>
                                                </div>
                                                @endforeach
                                            </div>
                                            <div class="tab-pane fade" id="omilestone" role="tabpanel" aria-labelledby="omilestone-tab">
                                                @foreach($omiles as $miles)
                                                <ul class="todo-list" data-widget="todo-list">
                                                    <li>
                                                        <!-- drag handle -->
                                                        <span class="handle">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </span>
                                                        <?php if ($miles->jatuh_tempo < date('Y-m-d')) { ?>
                                                            <div class="icheck-primary d-inline ">
                                                                <input type="checkbox" value="" name="todo1" id="todoCheck1" checked disabled>
                                                                <label for="todoCheck1"></label>
                                                            </div>
                                                        <?php } else { ?>
                                                            <div class="icheck-primary d-inline ">
                                                                <input type="checkbox" value="" name="todo1" id="todoCheck1" disabled>
                                                                <label for="todoCheck1"></label>
                                                            </div>
                                                        <?php } ?>

                                                        <!-- todo text -->
                                                        <span class="text">{{$miles->nama}}</span>
                                                        <!-- Emphasis label -->
                                                        <small class="badge badge-danger"><i class="far fa-clock"></i> {{$miles->jatuh_tempo}}</small>
                                                        <!-- General tools such as edit or delete-->
                                                        <div class="tools">
                                                            <a href="#editmilestone{{$miles->id}}" data-toggle="modal"> <i class="fas fa-edit"></i></a> |
                                                            <a href="{{url('/dosen/deletemilestone',$miles->id)}}" onclick="return confirm('Apakah Anda yakin data akan dihapus ?')" role="button"><i class="fas fa-trash" style="color : red"></i></a>


                                                        </div>
                                                        <div class="modal fade" id="editmilestone{{$miles->id}}">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Edit Milestone</h4>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form action="{{url('/dosen/updatemilestone',$miles->id)}}" method="post">
                                                                            {{ csrf_field() }}
                                                                            @foreach($prjk as $prj)
                                                                            <div class="form-group" hidden>
                                                                                <label for="inputName">Project id</label>
                                                                                <input type="text" name="project_id" class="form-control" value="{{$prj->id}}" readonly>
                                                                            </div>
                                                                            @endforeach
                                                                            <div class="form-group">
                                                                                <label>Nama Milestone</label>
                                                                                <input type="text" value="{{$miles->nama}}" name="nama" class="form-control">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>Deskripsi</label>
                                                                                <textarea name="deskripsi" class="form-control" rows="4">{{$miles->deskripsi}}</textarea>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>Tanggal Mulai</label>
                                                                                <input type="date" value="{{$miles->mulai}}" name="mulaie" class="form-control @error('mulaie') is-invalid @enderror">
                                                                                @error('mulaie')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>Tanggal Selesai</label>
                                                                                <input type="date" value="{{$miles->jatuh_tempo}}" name="jatuh_tempoe" class="form-control @error('jatuh_tempoe') is-invalid @enderror">
                                                                                @error('jatuh_tempoe')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                            <div class="modal-footer justify-content-between">
                                                                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                                                                    <i class="fa fa-times"> </i> Tutup
                                                                                </button>

                                                                                <button type="submit" class="btn btn-primary">
                                                                                    <i class="fa fa-save"></i> Simpan
                                                                                </button>
                                                                            </div>
                                                                        </form>
                                                                    </div>

                                                                </div>
                                                                <!-- /.modal-content -->
                                                            </div>
                                                            <!-- /.modal-dialog -->
                                                        </div>
                                                        <!-- /.modal -->
                                                    </li>
                                                </ul>
                                                @endforeach

                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card -->
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="tab-pane" :class="currentTab === 'konsul' ? 'active' : ''" id="konsul" wire:ignore.self>
                    <div class="card">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card-header card-outline card-primary">
                                    Tambah Konsultasi
                                </div>
                                <div class="card-body ">

                                    <form action="{{route('simpankonsul')}}" method="post">
                                        {{ csrf_field() }}
                                        @foreach($prjk as $prj)
                                        <div class="form-group" hidden>
                                            <label for="inputName">Project id</label>
                                            <input type="text" name="project_id" class="form-control" value="{{$prj->id}}" readonly>
                                        </div>
                                        @endforeach
                                        <div class="form-group">
                                            <label for="inputName">Tanggal Konsultasi</label>
                                            <input type="date" name="tgl_konsul" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="inputName">Nama Konsultasi</label>
                                            <input type="text" name="name" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="inputDescription">Deskripsi</label>
                                            <textarea name="deskripsi" class="form-control" rows="4"></textarea>
                                        </div>
                                        <div class="form-group">
                                            @foreach($history as $h)

                                            <div class="form-check">
                                                @if($prjct->mahasiswa1 == $h)
                                                @php
                                                $mahasiswa = \App\Models\History::where('no_induk', $h)->first();
                                                @endphp
                                                <input class="form-check-input" type="checkbox" name="mahasiswa[]" value="{{$prjct->mahasiswa1}}">
                                                <label class="form-check-label">{{$mahasiswa->nama}}</label>
                                                @elseif($prjct->mahasiswa2 == $h)
                                                @php
                                                $mahasiswa = \App\Models\History::where('no_induk', $h)->first();
                                                @endphp
                                                <input class="form-check-input" type="checkbox" name="mahasiswa[]" value="{{$prjct->mahasiswa2}}">
                                                <label class="form-check-label">{{$mahasiswa->nama}}</label>
                                                @elseif($prjct->mahasiswa3 == $h)
                                                @php
                                                $mahasiswa = \App\Models\History::where('no_induk', $h)->first();
                                                @endphp
                                                <input class="form-check-input" type="checkbox" name="mahasiswa[]" value="{{$prjct->mahasiswa3}}">
                                                <label class="form-check-label">{{$mahasiswa->nama}}</label>

                                                @endif
                                            </div>

                                            @endforeach
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <input type="reset" value="Reset" class="btn btn-danger ">
                                                <input type="submit" value="Buat Konsultasi Baru" class="btn btn-success ">
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
                                                <a class="nav-link active" id="otask-tab" data-toggle="pill" href="#otask" role="tab" aria-controls="otask" aria-selected="true">Konsultasi Lain</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content" id="custom-tabs-four-tabContent">
                                            <div class="tab-pane fade show active" id="otask" role="tabpanel" aria-labelledby="otask-tab">
                                                <div class="card">

                                                    <table id="otherk" class="table table-bordered">
                                                        <thead>
                                                            <tr align="center">
                                                                <th style="width: 10px">No</th>
                                                                <th>Nama</th>
                                                                <th>Tanggal</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php $no=1; @endphp

                                                            @foreach($kdsn as $kkdsn)
                                                            <tr align="center">
                                                                <td scope="row"><?php echo e($no++) + (($kdsn->currentPage() - 1) * $kdsn->perPage()) ?></td>
                                                                <td>{{$kkdsn->name}}</td>
                                                                <td>{{$kkdsn->tgl_konsul}}</td>
                                                                <td>
                                                                    <a href="#editkonsul{{$kkdsn->id}}" data-toggle="modal"><i class="fas fa-edit"></i></a> |
                                                                    <a href="{{url('/dosen/deletekonsul',$kkdsn->id)}}" onclick="return confirm('Apakah Anda yakin data akan dihapus ?')" role="button"><i class="fas fa-trash" style="color : red"></i></a>
                                                                </td>
                                                            </tr>
                                                            <div class="modal fade" id="editkonsul{{$kkdsn->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLabel">Edit Konsul</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form action="{{url('/dosen/updatekonsul',$kkdsn->id)}}" method="post" enctype="multipart/form-data">
                                                                                {{ csrf_field() }}
                                                                                @foreach($prjk as $prj)
                                                                                <div class="form-group" hidden>
                                                                                    <label for="inputName">Project id</label>
                                                                                    <input type="text" name="project_id" class="form-control" value="{{$prj->id}}" readonly>
                                                                                </div>
                                                                                @endforeach
                                                                                <div class="form-group">
                                                                                    <label for="inputName">Tanggal Konsultasi</label>
                                                                                    <input type="date" value="{{$kkdsn->tgl_konsul}}" name="tgl_konsul" class="form-control">
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label>Nama Konsultasi</label>
                                                                                    <input type="text" value="{{$kkdsn->name}}" name="name" class="form-control">
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label>Deskripsi</label>
                                                                                    <textarea name="deskripsi" class="form-control" rows="4">{{$kkdsn->deskripsi}}</textarea>
                                                                                </div>
                                                                                <div class="form-group">

                                                                                    @foreach($history as $no_induk)
                                                                                    @php
                                                                                    $mhs = json_decode($kkkdsn->mahasiswa);

                                                                                    @endphp
                                                                                    <div class="form-check">
                                                                                        @if($prjct->mahasiswa1 == $no_induk)
                                                                                        @php
                                                                                        $mahasiswa = \App\Models\History::where('no_induk', $no_induk)->first();
                                                                                        @endphp
                                                                                        <input class="form-check-input" type="checkbox" name="mahasiswa[]" value="{{$prjct->mahasiswa1}}" {{ in_array($prjct->mahasiswa1, $mhs) ? 'checked' : '' }}>
                                                                                        <label class="form-check-label">{{$mahasiswa->nama}}</label>
                                                                                        @elseif($prjct->mahasiswa2 == $no_induk)
                                                                                        @php
                                                                                        $mahasiswa = \App\Models\History::where('no_induk', $no_induk)->first();
                                                                                        @endphp
                                                                                        <input class="form-check-input" type="checkbox" name="mahasiswa[]" value="{{$prjct->mahasiswa2}}" {{ in_array($prjct->mahasiswa2, $mhs) ? 'checked' : '' }}>
                                                                                        <label class="form-check-label">{{$mahasiswa->nama}}</label>
                                                                                        @elseif($prjct->mahasiswa3 == $no_induk)
                                                                                        @php
                                                                                        $mahasiswa = \App\Models\History::where('no_induk', $no_induk)->first();
                                                                                        @endphp
                                                                                        <input class="form-check-input" type="checkbox" name="mahasiswa[]" value="{{$prjct->mahasiswa3}}" {{ in_array($prjct->mahasiswa3, $mhs) ? 'checked' : '' }}>
                                                                                        <label class="form-check-label">{{$mahasiswa->nama}}</label>

                                                                                        @endif
                                                                                    </div>
                                                                                    @endforeach
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
                <div class="tab-pane" :class="currentTab === 'dashboard' ? 'active' : ''" id="dashboard" wire:ignore.self>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-6 col-6">
                                <!-- small box -->
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3>{{$cmiles}}</h3>

                                        <h4>Total Milestone</h4>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-flag"></i>
                                    </div>

                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-6 col-6">
                                <!-- small box -->
                                <div class="small-box bg-success">
                                    <div class="inner">
                                        <h3>{{$ckonsul}}</h3>

                                        <h4>Total Konsultasi</h4>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-comments"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-header border-0">
                                    </div>
                                    <div class="card-body">
                                        {!! $chart->container() !!}
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
                                        {!! $chart1->container() !!}
                                    </div>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!-- /.col-md-6 -->
                        </div>
                    </div>
                </div>
                <div class="tab-pane" :class="currentTab === 'logbook' ? 'active' : ''" id="logbook" wire:ignore.self>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">

                                        <form action="{{url('dosen/vprojectdsn',$prjct->id)}}" method="GET">
                                            {{ csrf_field() }}
                                            <div class="row ">
                                                <div class="col-md-6 mt-4">
                                                    <select name="mahasiswa" class="form-control filter-select"> 
                                                        <option selected disabled>Pilih Mahasiswa</option>
                                                        @foreach($history as $dpter)
                                                        @php
                                                        $mahasiswa = \App\Models\History::where('no_induk', $dpter)->first();
                                                        @endphp
                                                        @if(!empty($prjct->mahasiswa1 == $dpter))
                                                        <option value="{{$prjct->mahasiswa1}}" {{isset($_GET['mahasiswa']) && $_GET['mahasiswa'] == $prjct->mahasiswa1 ? 'selected' : ''}}>{{$prjct->mahasiswa1}} {{$mahasiswa->nama}}</option>
                                                        @endif
                                                        @endforeach
                                                        @foreach($history as $dpter)
                                                        @php
                                                        $mahasiswa = \App\Models\History::where('no_induk', $dpter)->first();
                                                        @endphp
                                                        @if(!empty($prjct->mahasiswa2 == $dpter))
                                                        <option value="{{$prjct->mahasiswa2}}" {{isset($_GET['mahasiswa']) && $_GET['mahasiswa'] == $prjct->mahasiswa2 ? 'selected' : ''}}>{{$prjct->mahasiswa2}} {{$mahasiswa->nama}}</option>
                                                        @endif
                                                        @endforeach
                                                        @foreach($history as $dpter)
                                                        @php
                                                        $mahasiswa = \App\Models\History::where('no_induk', $dpter)->first();
                                                        @endphp
                                                        @if(!empty($prjct->mahasiswa3 == $dpter))
                                                        <option value="{{$prjct->mahasiswa3}}" {{isset($_GET['mahasiswa']) && $_GET['mahasiswa'] == $prjct->mahasiswa3 ? 'selected' : ''}}>{{$prjct->mahasiswa3}} {{$mahasiswa->nama}}</option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                    <button type="submit" class="btn btn-primary mt-4">Search</button>
                                                </div>
                                            </div>
                                        </form>


                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <table id="example2" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Mahasiswa</th>
                                                    <th>Tanggal</th>
                                                    <th>Kegiatan</th>
                                                    <th>Deskripsi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $no=1; @endphp
                                                @foreach($logmhs as $lmhs)
                                                <tr align="center">
                                                    <td scope="row"><?php echo e($no++) + (($logmhs->currentPage() - 1) * $logmhs->perPage()) ?></td>
                                                    <td>{{$lmhs->mahasiswa}}</td>
                                                    <td>{{$lmhs->tgl_logbook}}</td>
                                                    <td>{{$lmhs->kegiatan}}</td>
                                                    <td>{{$lmhs->deskripsi}}</td>

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
                <div class="tab-pane" :class="currentTab === 'files' ? 'active' : ''" id="files" wire:ignore.self>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <nav class="navbar navbar">
                                            <a class="btn btn-secondary" role="button" data-toggle="modal" data-target="#tambahfile">Tambah File</a>
                                        </nav>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <table id="file" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama File</th>
                                                    <th>Tanggal Upload</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $no=1; @endphp
                                                @foreach($file as $dfile)
                                                <tr>
                                                    <td scope="row"><?php echo e($no++) + (($file->currentPage() - 1) * $file->perPage()) ?></td>
                                                    <td>{{$dfile->file_name}}</td>
                                                    <td>{{date('jS \of F Y h:i:s A', strtotime($dfile->updated_at))}}</td>
                                                    <td>
                                                        <a class="btn btn-primary btn-sm" href="{{ route('downloadfiledsn', ['id' => $dfile->id]) }}"><i class="fas fa-download"></i></a>
                                                        <a class="btn btn-danger btn-sm" href="{{url('/dosen/deletefile',$dfile->id)}}" onclick="return confirm('Apakah Anda yakin data akan dihapus ?')"><i class="fas fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                                <div class="modal fade" id="tambahfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Tambah File</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{route('simpanfile')}}" method="post" enctype="multipart/form-data">
                                                    {{ csrf_field() }}
                                                    <div class="form-group row">
                                                        @foreach($prjk as $prj)
                                                        <label for="inputName" class="col-sm-3 col-form-label" hidden>Project id</label>
                                                        <div class="col-sm-9" hidden>
                                                            <input type="text" name="project_id" class="form-control" value="{{$prj->id}}" readonly>
                                                        </div>
                                                        @endforeach
                                                        <label for="nama" class="col-sm-3 col-form-label">File</label>
                                                        <div class="col-sm-9">
                                                            <input type="file" name="file" id="file" class="form-control">
                                                        </div>
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
                                    Mulai Diskusi
                                </div>
                                <div class="card-body ">

                                    <form action="{{route('simpanconversdsn')}}" method="post" enctype="multipart/form-data">
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
                                                <input type="submit" value="Buat Diskusi Baru" class="btn btn-success ">
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
                                                <!-- /.direct-chat-infos -->
                                                <!-- <img class="direct-chat-img" src="dist/img/user1-128x128.jpg" alt="message user image"> -->
                                                <!-- /.direct-chat-img -->
                                                <div class="direct-chat-text">
                                                    @if($convers->file_id != null)
                                                    <h6>{{$convers->file->file_name }}</h6><span><a href="{{ route('downloadfiledsn', ['id' => $convers->file->id]) }}" role="button"><i class="fas fa-download" style="color : white"></i></a></span><br>
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
                                                <!-- /.direct-chat-infos -->

                                                <!-- /.direct-chat-img -->
                                                <div class="direct-chat-text">
                                                    @if($convers->file_id != null)
                                                    <h6>{{$convers->file->file_name }}</h6><span><a href="{{ route('downloadfiledsn', ['id' => $convers->file->id]) }}" role="button"><i class="fas fa-download"></i></a></span><br>
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
                                                    <h6>{{$item->file->file_name }}</h6><span><a href="{{ route('downloadfiledsn', ['id' => $item->file->id]) }}" role="button"><i class="fas fa-download" style="color : white"></i></a></span><br>
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
                                                <!-- <img class="direct-chat-img" src="dist/img/user3-128x128.jpg" alt="message user image"> -->
                                                <!-- /.direct-chat-img -->
                                                <div class="direct-chat-text">
                                                    @if($item->file_id != null)
                                                    <h6>{{$item->file->file_name }}</h6><span><a href="{{ route('downloadfiledsn', ['id' => $item->file->id]) }}" role="button"><i class="fas fa-download" style="color : blue"></i></a></span><br>
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
                                        <form action="{{route('simpanconverreplydsn')}}" method="post" enctype="multipart/form-data">
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
                                                    <input type="submit" value="Balas" class="btn btn-success ">
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
                            <h3 class="card-title">Detail Project</h3>
                        </div>
                        <div class="card-body">

                            @foreach($prjk as $prj)
                            <b>Project name</b> &emsp; &emsp; &emsp; &emsp; &emsp; {{$prj->nama}}</br>
                            <b>Deskripsi</b> &emsp; &emsp; &emsp; &emsp; &emsp; &emsp; &ensp;{{$prj->deskripsi}}</br>

                            @foreach($pterpan1 as $dpter)
                            @if($prj->dosen == $dpter->no_induk)
                            <b>Dosen Pembimbing</b> &emsp; &emsp; &emsp;{{$dpter->name}}</br>
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
                            <b>Start</b>&emsp; &emsp; &emsp; &emsp; &emsp; &emsp; &emsp; &ensp; &ensp; {{date('d F Y', strtotime($prj->mulai))}}</br>
                            <b>End</b>&emsp; &emsp; &emsp; &emsp; &emsp; &emsp; &emsp; &emsp; &ensp; {{date('d F Y', strtotime($prj->jatuh_tempo))}}</br>
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
@push('alpine-plugins')
<!-- Alpine Plugins -->
<script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/persist@3.x.x/dist/cdn.min.js"></script>
@endpush

<script>
    $(function() {
        $('#example2').DataTable({
            "dom": '<"top"i>rt<"bottom"p><"clear">',
            "paging ": true,
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
            "paging ": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": false,
            "autoWidth": false,
            "responsive": true,
            "pageLength": 10,
        });
        $('#otherk').DataTable({
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

<script src="{{ $chart->cdn() }}"></script>
<script src="{{ $chart1->cdn() }}"></script>
{{ $chart->script() }}
{{ $chart1->script() }}

@endsection