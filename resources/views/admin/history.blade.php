@extends('template.master')
<title>Riwayat</title>

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
                    <li class="breadcrumb-item active">Riwayat</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="card">
    <div class="card-header">
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr align="center">
                    <th>No</th>
                    <th>Tahun Ajaran</th>
                    <th>Semester</th>
                    <th>Jumlah Perserta</th>
                </tr>
            </thead>
            <tbody>
                @php $no=1; @endphp
                @foreach($history as $h)
                <tr align="center">
                    <td scope="row"><?php echo e($no++) + (($history->currentPage() - 1) * $history->perPage()) ?></td>
                    <td>{{substr($h->tahun_ajaran,0,4)}}</td>
                    @if(substr($h->tahun_ajaran,4) == '2')
                    <td>Genap</td>
                    @elseif(substr($h->tahun_ajaran,4) == '1')
                    <td>Ganjil</td>
                    @endif
                    <td>{{ $h->jumlah_mahasiswa }}</td>
                </tr>
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

@endsection