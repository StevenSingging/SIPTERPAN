<!DOCTYPE html>
<html lang="en">
<style>
    .page-break {
        page-break-after: always;
    }
</style>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Rekap Project</title>
</head>

<body>
    <div style="display: flex; align-items: center; margin-bottom: 20px;">
    <img src="https://wp-data-ukdw.s3.ap-southeast-1.amazonaws.com/wp-content/uploads/2017/10/10124041/cropped-icon-ukdw-top.png" alt="" height="100px" style="float: left; margin-right: 10px;">
        <div >
            <h6>Universitas Kristen Duta Wacana</h6>
            <h5>Program Studi Sarjana Sistem Informasi</h5>
            <h5>Fakultas Teknologi Informasi</h5>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr style="background-color: darkgrey;">
                <th colspan="8" style="text-align: center;">Rekap project</th>
            </tr>
            <tr style="background-color: darkgrey;">
                <th>Nama Project</th>
                <th>Deskripsi</th>
                <th>Mulai</th>
                <th>Deadline</th>
                <th>Tahun Ajaran</th>
                <th>Mahasiswa</th>
                <th>Dosen Pembimbing</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>

            @foreach($project as $prj)
            <tr>
                <td>{{$prj->nama}}</td>
                <td>{{$prj->deskripsi}}</td>
                <td>{{date('d F Y', strtotime($prj->mulai))}}</td>
                <td>{{date('d F Y', strtotime($prj->jatuh_tempo))}}</td>
                <td>{{ substr($prj->tahun_ajaran,4) == '1' ? 'Ganjil' : 'Genap' }} {{ substr($prj->tahun_ajaran,0,4) }}</td>
                @foreach($pterpan as $dpter)
                @if(!empty($prj->mahasiswa1 == $dpter->no_induk))
                <td>{{$prj->mahasiswa1}}<br> {{$dpter->name}}<br>
                    @endif
                    @endforeach

                    @foreach($pterpan as $dpter)
                    @if(!empty($prj->mahasiswa2 == $dpter->no_induk))
                    <br>{{$prj->mahasiswa1}}<br> {{$dpter->name}}</br>
                    @endif
                    @endforeach

                    @foreach($pterpan as $dpter)
                    @if(!empty($prj->mahasiswa3 == $dpter->no_induk))
                    <br>{{$prj->mahasiswa1}}<br> {{$dpter->name}}
                </td>
                @endif
                @endforeach
                @foreach($pterpan as $dpter)
                @if($prj-> dosen == $dpter->no_induk)
                <td>{{$dpter->name}}</td>
                @endif
                @endforeach
                @if($prj->status == '0')
                <td>Dalam Progress</td>
                @elseif($prj->status == '1')
                <td>Selesai</td>
                @elseif($prj->status == '2')
                <td>Gagal</td>
                @endif
            </tr>
            @endforeach
        </tbody>

    </table>
    <div class="page-break"></div>
    <table class="table table-bordered ">
        <thead>
            <tr style="background-color: darkgrey;">
                <th colspan="6" style="text-align: center;">Milestone</th>
            </tr>
            <tr style="background-color: darkgrey;">
                <th>No</th>
                <th>Nama Milestone</th>
                <th>Deskripsi</th>
                <th style="width: 15%">Mulai</th>
                <th>Deadline</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php $no=1; @endphp
            @foreach($milestone as $mls)
            <tr>
                <td>{{$no++}}</td>
                <td>{{$mls->nama}}</td>
                <td>{{$mls->deskripsi}}</td>
                <td>{{date('d F Y', strtotime($mls->mulai))}}</td>
                <td>{{date('d F Y', strtotime($mls->jatuh_tempo))}}</td>
                @if($mls->status == '0')
                <td>Dalam Progress</td>
                @elseif($mls->status == '1')
                <td>Selesai</td>
                @elseif($mls->status == '2')
                <td>Gagal</td>
                @endif
            </tr>

            @endforeach
        </tbody>
    </table>
    <div class="page-break"></div>
    <table class="table table-bordered ">
        <thead>
            <tr style="background-color: darkgrey;">
                <th colspan="5" style="text-align: center;">Konsultasi</th>
            </tr>
            <tr style="background-color: darkgrey;">
                <th>No</th>
                <th>tgl_konsul</th>
                <th>Nama</th>
                <th>Deskripsi</th>
                <th>Mahasiswa</th>
            </tr>
        </thead>
        <tbody>

            @php $no=1; @endphp
            @foreach($konsul as $kls)
            <tr>
                <td>{{$no++}}</td>
                <td>{{date('d F Y', strtotime($kls->tgl_konsul))}}</td>
                <td>{{$kls->name}}</td>
                <td>{{$kls->deskripsi}}</td>
                <td>
                    <ul>
                        @foreach (json_decode($kls->mahasiswa) as $data_item)
                        <li>{{ $data_item }}</li>
                        @endforeach
                    </ul>
                </td>
            </tr>

            @endforeach
        </tbody>
    </table>
    <div class="page-break"></div>
    <table class="table table-bordered ">
        <thead>
            <tr style="background-color: darkgrey;">
                <th colspan="5" style="text-align: center;">Logbook</th>
            </tr>
            <tr style="background-color: darkgrey;">
                <th>No</th>
                <th>Mahasiswa</th>
                <th>Tanggal</th>
                <th>Kegiatan</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>

            @php $no=1; @endphp
            @foreach($logbook as $log)
            <tr>
                <td>{{$no++}}</td>
                <td>{{$log->mahasiswa}}</td>
                <td>{{date('d F Y', strtotime($log->tgl_logbook))}}</td>
                <td>{{$log->kegiatan}}</td>
                <td>{{$log->deskripsi}}</td>
            </tr>

            @endforeach
        </tbody>
    </table>
    <div class="page-break"></div>
    <table class="table table-bordered ">
        <thead>
            <tr style="background-color: darkgrey;">
                <th colspan="2" style="text-align: center;">Nilai</th>
            </tr>
            <tr style="background-color: darkgrey;">
                <th style="width: 50%">Mahasiswa</th>
                <th>Nilai</th>
            </tr>
        </thead>
        <tbody>

            @php $no=1; @endphp
            @foreach($project as $prj)
            @php
            $decoded_data = json_decode($prj->nilai,true);
            @endphp
            <tr>
                @foreach($pterpan as $dpter)
                @if(!empty($prj->mahasiswa1 == $dpter->no_induk))
                <td>{{$prj->mahasiswa1}} {{$dpter->name}}<br>
                    @endif
                    @endforeach

                    @foreach($pterpan as $dpter)
                    @if(!empty($prj->mahasiswa2 == $dpter->no_induk))
                    <br>{{$prj->mahasiswa1}} {{$dpter->name}}</br>
                    @endif
                    @endforeach

                    @foreach($pterpan as $dpter)
                    @if(!empty($prj->mahasiswa3 == $dpter->no_induk))
                    <br>{{$prj->mahasiswa1}} {{$dpter->name}}
                </td>
                @endif
                @endforeach
                @if($decoded_data == null)
                @else
                <td>{{ $decoded_data['0'] }} <br>
                    <br>{{ $decoded_data['1'] }} </br>
                    <br>{{ $decoded_data['2'] }}
                </td>
               @endif
            </tr>

            @endforeach
        </tbody>
    </table>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>