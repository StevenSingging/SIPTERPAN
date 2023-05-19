@extends('template.master')
<title>Daftar Proyek</title>

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
                    <li class="breadcrumb-item active">Daftar Project</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Default box -->
<div class="container-fluid">
    <div class="card">
        <div class="card-body p-0">
            <table id="project" class="table table-bordered table-hover">
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
                            <br>{{$mahasiswa->nama}}</br>
                            @endif

                            @if(!empty($dprjct->mahasiswa3 == $no_induk))
                            @php
                            $mahasiswa = \App\Models\History::where('no_induk', $no_induk)->first();
                            @endphp
                            <br>{{$mahasiswa->nama}}
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
                        <td class="project-actions text-right">
                            <a class="btn btn-primary btn-sm" href="{{url('mahasiswa/vproject',$dprjct->id)}}">
                                <i class="fas fa-folder">
                                </i>
                                View
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