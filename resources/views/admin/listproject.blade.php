@extends('template.master')
<title>Daftar Project</title>

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Daftar Project</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="card">
    <div class="card-header">
        <form action="{{url('admin/listproject')}}" method="GET">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-6 mt-4">
                    <select name="tahun_ajaran" class="form-control custom-select">
                        <option selected value="">Pilih Tahun Ajaran</option>
                        @foreach($tahunajaran as $tahun)
                        <option value="{{ $tahun }}" {{isset($_GET['tahun_ajaran']) && $_GET['tahun_ajaran'] == $tahun  ? 'selected' : ''}}>{{substr($tahun,0,4)}} {{substr($tahun,4) == '1' ? 'Ganjil' : 'Genap'}}</option>
                        @endforeach

                    </select>
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary mt-4">Filter</button>

                </div>
            </div>
        </form>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr align="center">
                    <th>No</th>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Semester</th>
                    <th>Tahun Ajaran</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $no=1; @endphp
                @foreach($listproject as $data)
                <tr align="center">
                    <td scope="row"><?php echo e($no++) + (($listproject->currentPage() - 1) * $listproject->perPage()) ?></td>
                    <td>{{$data->nama}}</td>
                    <td>{{$data->deskripsi}}</td>
                    @if(substr($data->tahun_ajaran,4) == '2')
                    <td>Genap</td>
                    @elseif(substr($data->tahun_ajaran,4) == '1')
                    <td>Ganjil</td>
                    @endif
                    <td>{{substr($data->tahun_ajaran,0,4)}}</td>
                    @if($data->status == '1')
                    <td><span class="badge badge-success">Selesai</span></td>
                    @elseif($data->status == '0')
                    <td><span class="badge badge-warning">Dalam Progress</span></td>
                    @elseif($data->status == '2')
                    <td><span class="badge badge-warning">Gagal</span></td>
                    @endif
                    <td>
                        <a class="btn btn-primary btn-sm" href="#editproject{{$data->id}}" data-toggle="modal"><i class="fas fa-file-edit"></i></a>
                    </td>
                </tr>
                <div class="modal fade" id="editproject{{$data->id}}">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="projectlabel">Edit Project</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{url('/admin/updateproject',$data->id)}}" method="post">
                                    {{ csrf_field() }}
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-3 col-form-label">Nama</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="nama" value="{{$data->nama}}" class="form-control" maxlength="5" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="deskripsi" class="col-sm-3 col-form-label">Deskripsi</label>
                                        <div class="col-sm-9">
                                            <textarea name="deskripsi" class="form-control" rows="3">{{$data->deskripsi}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="Dosen" class="col-sm-3 col-form-label">Dosen Pembimbing</label>
                                        <div class="col-sm-9">
                                            <select id="Dosen" class="form-control custom-select" name="dosen">
                                                <option value="" selected disabled>Pilih Dosen</option>
                                                @foreach($dsn as $ddsn)
                                                <option value="{{ $ddsn->no_induk }}" {{$data->dosen == "$ddsn->no_induk" ? 'selected' : ""}}> {{ $ddsn->no_induk }} {{$ddsn->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="Mahasiswa1" class="col-sm-3 col-form-label">Mahasiswa 1</label>
                                        <div class="col-sm-9">
                                            <select id="Mahasiswa1" class="form-control custom-select  mahasiswa-dropdown" name="mahasiswa1" data-dropdown-id="1">
                                                <option value="" selected disabled>Pilih Mahasiswa</option>
                                                @foreach($mhs as $mhs1)
                                                <option value="{{ $mhs1->no_induk }}" {{$data->mahasiswa1 == "$mhs1->no_induk" ? 'selected' : ""}}> {{ $mhs1->no_induk }} {{$mhs1->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="Mahasiswa2" class="col-sm-3 col-form-label">Mahasiswa 2</label>
                                        <div class="col-sm-9">
                                            <select id="Mahasiswa2" class="form-control custom-select  mahasiswa-dropdown" name="mahasiswa2" data-dropdown-id="2">
                                                <option value="" selected disabled>Pilih Mahasiswa</option>
                                                @foreach($mhs as $mhs2)
                                                <option value="{{ $mhs2->no_induk }}" {{$data->mahasiswa2 == "$mhs2->no_induk" ? 'selected' : ""}}>{{ $mhs2->no_induk }} {{$mhs2->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="Mahasiswa3" class="col-sm-3 col-form-label">Mahasiswa 3</label>
                                        <div class="col-sm-9">
                                            <select id="Mahasiswa3" class="form-control custom-select  mahasiswa-dropdown" name="mahasiswa3" data-dropdown-id="3">
                                                <option value="" selected disabled>Pilih Mahasiswa</option>
                                                @foreach($mhs as $mhs3)
                                                <option value="{{ $mhs3->no_induk }}" {{$data->mahasiswa3 == "$mhs3->no_induk" ? 'selected' : ""}}>{{ $mhs3->no_induk }} {{$mhs3->name}}</option>
                                                @endforeach
                                            </select>
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
    <!-- /.card-body -->
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
<!-- <script>
    function fetch(tahun_ajaran, semester) {
        $.ajax({
            url: 'lisprojectjson',
            type: "GET",
            data: {
                tahun_ajaran: tahun_ajaran,
                semester: semester
            },
            dataType: "json",
            success: function(data) {
                // Datatables
                var i = 1;
                $('#example1').DataTable({
                    "dom": '<"top"i>rt<"bottom"p><"clear">',
                    "paging": true,
                    "lengthChange": false,
                    "searching": false,
                    "ordering": true,
                    "info": false,
                    "autoWidth": false,
                    "responsive": true,
                    "pageLength": 10,
                    "data": data.project,
                    // responsive
                    "columns": [{
                            "data": "id",
                            "render": function(data, type, row, meta) {
                                return i++;
                            }
                        },
                        {
                            "data": "nama"
                        },
                        {
                            "data": "deskripsi",
                            "render": function(data, type, row, meta) {
                                return `${row.deskripsi}th Standard`;
                            }
                        },
                        {
                            "data": "mulai",
                            "render": function(data, type, row, meta) {
                                return moment(row.mulai).format('D MMMM Y');
                            }
                        },
                        {
                            "data": "jatuh_tempo",
                            "render": function(data, type, row, meta) {
                                return moment(row.jatuh_tempo).format('D MMMM Y');
                            }
                        }
                    ]
                });
            }
        });
    }
    fetch();
    // $(".custom-select").on('change',function(){
    //     var tahun_ajaran = $("#tahunajaran-filter").val()
    //     var semester = $("#semester-filter").val()
    //     if (tahun_ajaran == "" ) {
    //             // alert("required");
    //             // console.log([semester]);
    //         } else {
    //             $('#example1').DataTable().destroy();
    //             fetch(tahun_ajaran);
    //         }
    //         if (semester == "" ) {
    //             // alert("required");
    //             // console.log([semester]);
    //         } else {
    //             $('#example1').DataTable().destroy();
    //             fetch(semester);
    //         }

    // })
    // $(document).on("click", "#filter", function(e) {
    //     e.preventDefault();
    //     var tahun_ajaran = $("#tahunajaran-filter").val()
    //     var semester = $("#semester-filter").val()
    //     if (tahun_ajaran == "" || semester == "") {
    //         alert("Both date required");
    //     } else {
    //         $('#example1').DataTable().destroy();
    //         fetch(tahun_ajaran, semester);
    //     }
    // });
    // // Reset
    // $(document).on("click", "#reset", function(e) {
    //     e.preventDefault();
    //     $("#tahunajaran-filter").val(''); // empty value
    //     $("#semester-filter").val('');
    //     $('#example1').DataTable().destroy();
    //     fetch();
    // });
</script> -->
@endsection