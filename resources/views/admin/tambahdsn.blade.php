@extends('template.master')
<title>Daftar Dosen</title>

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
          <li class="breadcrumb-item active">Daftar Dosen</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <nav class="navbar navbar-light bg-light">
            <h3>Data Dosen</h3>
          </nav>
          <nav class="navbar navbar">
            <a class="btn btn-secondary" role="button" data-toggle="modal" data-target="#exampleModal">Tambah Data</a>
          </nav>
        </div>
        <div class="card-body">

          <table class="table table-bordered table-hover" id="dosen" width="100%" border="1">
            <thead>
              <tr align="center">
                <th>No</th>
                <th>NIDN</th>
                <th>Nama</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @php $no=1; @endphp
              @foreach($dsn as $ddsn)
              <tr align="center">
                <th scope="row"><?php echo e($no++) + (($dsn->currentPage() - 1) * $dsn->perPage()) ?></th>
                <td>{{$ddsn->no_induk}}</td>
                <td>{{$ddsn->name}}</td>
                <td>
                    <a class="btn btn-primary btn-sm" href="#editdsn{{$ddsn->id}}" data-toggle="modal"><i class="fas fa-user-edit"></i></a>
                    <a class="btn btn-danger btn-sm" href="{{url('/admin/deletedsn',$ddsn->id)}}" onclick="return confirm('Apakah Anda yakin data akan dihapus ?')"><i class="fas fa-user-minus"></i></a>
                </td>
              </tr>
              <div class="modal fade" id="editdsn{{$ddsn->id}}">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="dsnlabel">Edit Dosen</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{url('/admin/updatedsn',$ddsn->id)}}" method="post">
                                    {{ csrf_field() }}
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-3 col-form-label">Nama</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="name" value="{{$ddsn->name}}" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-3 col-form-label">NIDN</label>
                                        <div class="col-sm-9">
                                            <input type="number" name="no_induk" value="{{$ddsn->no_induk}}" class="form-control" required>
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
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Tambah Dosen</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="{{route('simpandsn')}}" method="post">
                {{ csrf_field() }}
                <div class="form-group row">
                  <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                  <div class="col-sm-9">
                    <input type="text" name="name" class="form-control" placeholder="Nama" required>
                  </div>
                </div>


                <div class="form-group row">
                  <label for="nidn" class="col-sm-3 col-form-label">NIDN</label>
                  <div class="col-sm-9">
                    <input type="text" name="nidn" class="form-control" placeholder="NIDN" required>
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
    
  </div>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script>
  $(function() {
    $('#dosen').DataTable({
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