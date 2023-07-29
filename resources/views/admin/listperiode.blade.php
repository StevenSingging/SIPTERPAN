@extends('template.master')
<title>Daftar Periode</title>

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Beranda</a></li>
                    <li class="breadcrumb-item active">Daftar Periode</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="card">
    <div class="card-header">
        <nav class="navbar navbar">
            <a class="btn btn-primary" role="button" data-toggle="modal" data-target="#periode">Tambah Data</a>
        </nav>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr align="center">
                    <th>No</th>
                    <th>Tahun Ajaran</th>
                    <th>Semester</th>
                    <th>Tanggal Awal</th>
                    <th>Tanggal Akhir</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $no=1; @endphp
                @foreach($periode as $data)
                <tr align="center">
                    <td scope="row"><?php echo e($no++) + (($periode->currentPage() - 1) * $periode->perPage()) ?></td>
                    <td>{{substr($data->tahun_ajaran,0,4)}}</td>
                    @if(substr($data->tahun_ajaran,4) == '2')
                    <td>Genap</td>
                    @elseif(substr($data->tahun_ajaran,4) == '1')
                    <td>Ganjil</td>
                    @endif
                    <td>{{date('d F Y', strtotime($data->tgl_awal))}}</td>
                    <td>{{date('d F Y', strtotime($data->tgl_akhir))}}</td>
                    @if($data->status == '1')
                    <td><span class="badge badge-success">Aktif</span></td>
                    @elseif($data->status == '0')
                    <td><span class="badge badge-danger">Tidak Aktif</span></td>
                    @else
                    <td></td>
                    @endif
                    <td>
                        <form action="{{url('admin/updateperiode',$data->id)}}" method="post">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-success btn-sm" name="status" value="1">
                                <i class="fa-solid fa-check"></i>
                            </button>
                            <button type="submit" class="btn btn-danger btn-sm" name="status" value="0">
                                <i class="fa-solid fa-x"></i>
                            </button>
                            <a class="btn btn-primary btn-sm" href="#editperiode{{$data->id}}" data-toggle="modal"><i class="fa-solid fa-pen-to-square"></i></a>
                        </form>
                    </td>
                </tr>
                <div class="modal fade" id="editperiode{{$data->id}}">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="periodelabel">Update Periode</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{url('/admin/updatedataperiode',$data->id)}}" method="post">
                                    {{ csrf_field() }}
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-3 col-form-label">Tahun Ajaran</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="tahun_ajaran" value="{{$data->tahun_ajaran}}" class="form-control" maxlength="5" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="nim" class="col-sm-3 col-form-label">Tanggal Awal</label>
                                        <div class="col-sm-9">
                                            <input type="date" name="tgl_awal" value="{{$data->tgl_awal}}" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="nim" class="col-sm-3 col-form-label">Tanggal Akhir</label>
                                        <div class="col-sm-9">
                                            <input type="date" name="tgl_akhir" value="{{$data->tgl_akhir}}" class="form-control" required>
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
    @endforeach
    </tbody>
    </table>
</div>
<!-- /.card-body -->
<div class="modal fade" id="periode" role="dialog" aria-labelledby="periodelabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="periodelabel">Tambah Periode</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('tambahperiode')}}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Tahun Ajaran</label>
                        <div class="col-sm-9">
                            <input type="text" name="tahun_ajaran" class="form-control" maxlength="5" value="{{ $tahunAjaranDefault }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nim" class="col-sm-3 col-form-label">Tanggal Awal</label>
                        <div class="col-sm-9">
                            <input type="date" name="tgl_awal" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nim" class="col-sm-3 col-form-label">Tanggal Akhir</label>
                        <div class="col-sm-9">
                            <input type="date" name="tgl_akhir" class="form-control" required>
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

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script>
    $(function() {
        $('#example1').DataTable({

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

    });
</script>

@endsection