@extends('template.master')
<title>Nilai</title>
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
                    <li class="breadcrumb-item active">Nilai</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Default box -->
<div class="container-fluid">
    <div class="card">
        <div class="card-body p-0">
            <table id="nilai" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th style="width: 5%">
                            No
                        </th>
                        <th style="width: 20%">
                            Project Name
                        </th>
                        <th style="width: 20%">
                            Nilai <small style="color:red"> * skala nilai 0-100</small>
                        </th>

                    </tr>
                </thead>
                <tbody>
                    @php $no=1; @endphp
                    @foreach($project as $dprjct)
                    @php
                    $decoded_data = json_decode($dprjct->nilai,true);
                    @endphp
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
                        <td>
                            <form action="{{url('/dosen/updatenilai',$dprjct->id)}}" method="POST">
                                {{ csrf_field() }}
                                @foreach($pterpan as $dpter)
                                @if(!empty($dprjct->mahasiswa1 == $dpter->no_induk))
                                <label>{{$dpter->nama}}</label>
                                <div class="form-group">
                                    <input type="text" id="nilai-input-1" style="width: 50px;" name="nilai[]" value="{{ $dprjct->nilai === null ? '' : $decoded_data['0'] }}" class="form-control" maxlength="3" onkeyup="ubahNilaiHuruf('1')">
                                    <p>Nilai huruf: <span id="nilai-huruf-1"></span></p>
                                </div>
                                @endif
                                @endforeach
                                @foreach($pterpan as $dpter)
                                @if(!empty($dprjct->mahasiswa2 == $dpter->no_induk))
                                <label>{{$dpter->nama}}</label>
                                <div class="form-group">
                                    <input type="text" id="nilai-input-2" style="width: 50px;" name="nilai[]" value="{{ $dprjct->nilai === null ? '' : $decoded_data['1'] }}" class="form-control" maxlength="3" onkeyup="ubahNilaiHuruf('2')">
                                    <p>Nilai huruf: <span id="nilai-huruf-2"></span></p>
                                </div>
                                @endif
                                @endforeach
                                @foreach($pterpan as $dpter)
                                @if(!empty($dprjct->mahasiswa3 == $dpter->no_induk))
                                <label>{{$dpter->nama}}</label>
                                <div class="form-group">
                                    <input type="text" id="nilai-input-3" style="width: 50px;" name="nilai[]" value="{{ $dprjct->nilai === null ? '' : $decoded_data['2'] }}" class="form-control" maxlength="3" onkeyup="ubahNilaiHuruf('3')">
                                    <p>Nilai huruf: <span id="nilai-huruf-3"></span></p>
                                </div>
                                @endif
                                @endforeach
                                <div class="row">
                                    <div class="col-12">
                                        <input type="reset" value="Reset" class="btn btn-danger ">
                                        <input type="submit" value="Submit" class="btn btn-success ">
                                    </div>
                                </div>

                            </form>
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
        $('#nilai').DataTable({
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
<script>
    function ubahNilaiHuruf(mahasiswa) {
        // Ambil nilai input
        var nilai = document.getElementById("nilai-input-" + mahasiswa).value;

        // Ubah huruf sesuai referensi nilai
        var huruf;
        if (nilai >= 85) {
            huruf = "A";
        } else if (nilai >= 80) {
            huruf = "A-";
        } else if (nilai >= 75) {
            huruf = "B+";
        } else if (nilai >= 70) {
            huruf = "B";
        } else if (nilai >= 65) {
            huruf = "B-";
        } else if (nilai >= 60) {
            huruf = "C+";
        } else if (nilai >= 55) {
            huruf = "C";
        } else if (nilai >= 45) {
            huruf = "D";
        } else {
            huruf = "E";
        }


        // Tampilkan hasil
        document.getElementById("nilai-huruf-" + mahasiswa).innerText = huruf;
    }
</script>
@endsection