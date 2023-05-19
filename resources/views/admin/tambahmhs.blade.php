@extends('template.master')
<title>Daftar Mahasiswa</title>

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
          <li class="breadcrumb-item active">Daftar Mahasiswa</li>
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
            <h3>Data Mahasiswa</h3>
          </nav>
          <nav class="navbar navbar">
            <a class="btn btn-secondary" role="button" data-toggle="modal" data-target="#exampleModal">Tambah Data</a>
            <a href="javascript:void(0);" class="btn btn-success" onclick="formToggle('importFrm');"><i class="plus"></i> Import</a>
          </nav>
        </div>
        <div class="card-body">
          <div class="card-body">
            <div class="col-md-12" id="importFrm" style="display: none;">
              <form action="{{ route('mahasiswa.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" class="form-control">
                <br>
                <button class="btn btn-primary">Import User Data</button>
              </form>
            </div>
            <table class="table table-bordered table-hover" id="mahasiswa" border="1">
              <thead>
                <tr align="center">
                  <th>No</th>
                  <th>NIM</th>
                  <th>Nama</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @php $no=1; @endphp
                @foreach($mhs as $dmhs)
                <tr align="center">
                  <td scope="row"><?php echo e($no++) + (($mhs->currentPage() - 1) * $mhs->perPage()) ?></td>
                  <td>{{$dmhs->no_induk}}</td>
                  <td>{{$dmhs->name}}</td>
                  <td>
                    <div class="mahasiswa1" data-nim="{{ $dmhs->no_induk }}">
                    <a class="btn btn-primary btn-sm"  href="#editmhs{{$dmhs->id}}" data-toggle="modal" ><i class="fas fa-user-edit"></i></a>
                    <a class="btn btn-danger btn-sm" href="{{url('/admin/deletemhs',$dmhs->id)}}" onclick="return confirm('Apakah Anda yakin data akan dihapus ?')"><i class="fas fa-user-minus"></i></a>
                    <a class="btn btn-secondary btn-sm" href="#history" data-toggle="modal"><i class="fas fa-history"></i></a>
                    </div>
                    <div class="mahasiswa mt-1">
                      <span class="badge badge-primary">Pengambilan {{$dmhs->pengambilan}}</span>
                    </div>
                  </td>
                </tr>
                <div class="modal fade" id="history" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered ">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">History</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div id="projectList"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal fade" id="editmhs{{$dmhs->id}}">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mhslabel">Edit Mahasiswa</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{url('/admin/updatemhs',$dmhs->id)}}" method="post">
                                    {{ csrf_field() }}
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-3 col-form-label">Nama</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="name" value="{{$dmhs->name}}" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-3 col-form-label">NIM</label>
                                        <div class="col-sm-9">
                                            <input type="number" name="no_induk" value="{{$dmhs->no_induk}}" class="form-control" required>
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

        <div class="modal fade" id="exampleModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Mahasiswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="{{route('simpanmhs')}}" method="post">
                  {{ csrf_field() }}
                  <div class="form-group row">
                    <label for="name" class="col-sm-3 col-form-label">Nama</label>
                    <div class="col-sm-9">
                      <input type="text" name="name" class="form-control" placeholder="Nama" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="nim" class="col-sm-3 col-form-label">NIM</label>
                    <div class="col-sm-9">
                      <input type="number" name="nim" class="form-control" placeholder="NIM" required>
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
      $('#mahasiswa').DataTable({

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
  <script>
    $(document).ready(function() {
      $('.mahasiswa').each(function() {
        var nim = $(this).data('nim');

        $.ajax({
          url: '/jumlah_project/' + nim,
          type: 'GET',
          dataType: 'json',
          success: function(response) {
            $('#jumlah-project-' + nim).html('<span class="badge badge-primary"> Pengambilan : ' + response.jumlah_project);
          }
        });
      });
    });
  </script>
  <script>
    $(document).ready(function() {
      $('.mahasiswa1').click(function() {
        var nim = $(this).data('nim');

        $.ajax({
          url: '/showproject/' + nim,
          type: 'GET',
          dataType: 'json',
          success: function(response) {
            var html = '<ul>';
            $.each(response.projects, function(index, project) {
              var semester;
              if (project.tahun_ajaran.slice(-1) % 2 === 0) {
                semester = 'Genap';
              } else {
                semester = 'Gasal';
              }
              var status;
              if (response.nilai[index] >= 55) {
                status = 'Lulus';
              } else {
                status = 'Tidak Lulus';
              }
              html += '<li>' +
                '<strong>Project ' + (index + 1) + '</strong>' +
                '<ul>' +
                '<li>Judul: ' + project.nama + '</li>' +
                '<li>Dosen Pembimbing: ' + response.dosens[index] + '</li>' +
                '<li>Semester: ' + semester + '</li>' +
                '<li>Tahun Ajaran: ' + project.tahun_ajaran.substring(0, 4) + '</li>' +
                '<li>Nilai: ' + response.nilai[index] + '</li>' +
                '<li><span class="badge badge-primary"> Status : ' + status + '</li>' +
                '</ul>' +
                '</li>';
            });
            html += '</ul>';
            $('#projectList').html(html);
          }
        });
      });
    });
  </script>
  <script>
    function formToggle(ID) {
      var element = document.getElementById(ID);
      if (element.style.display === "none") {
        element.style.display = "block";
      } else {
        element.style.display = "none";
      }
    }
  </script>
  @endsection