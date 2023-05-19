@extends('template.master')
<title>Project</title>

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="">Beranda</a></li>
                    <li class="breadcrumb-item active">Proyek</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Default box -->
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Projects</h3>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped projects">
                <thead>
                    <tr>
                        <th>
                            No
                        </th>
                        <th>
                            Project Name
                        </th>
                        <th style="width: 20%">
                            Team Members
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
                                Created {{date('d F Y', strtotime($dprjct->created_at))}}
                            </small>
                        </td>
                        @foreach($pterpan as $dpter)
                        @if(!empty($dprjct->mahasiswa1 == $dpter->no_induk))
                        <td>{{$dpter->name}}<br>
                            @endif
                            @endforeach

                            @foreach($pterpan as $dpter)
                            @if(!empty($dprjct->mahasiswa2 == $dpter->no_induk))
                            <br>{{$dpter->name}}</br>
                            @endif
                            @endforeach

                            @foreach($pterpan as $dpter)
                            @if(!empty($dprjct->mahasiswa3 == $dpter->no_induk))
                            <br>{{$dpter->name}}
                        </td>
                        @endif
                        @endforeach

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
                            <a class="btn btn-primary btn-sm" href="{{url('dosen/vprojectdsn',$dprjct->id)}}">
                                <i class="fas fa-folder">
                                </i>
                                
                            </a>
                            <a class="btn btn-primary btn-sm" href="{{url('dosen/downloadrekap',$dprjct->id)}}">
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
@endsection