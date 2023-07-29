@extends('template.master')
<title>Tambah Project</title>
@section('content')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1></h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Beranda</a></li>
        <li class="breadcrumb-item active">Tambah Proyek</li>
      </ol>
    </div>
  </div>
</div><!-- /.container-fluid -->
<div class="container-fluid">
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <form action="{{route('simpanproject')}}" method="post">
            {{ csrf_field() }}
            <div class="form-group">
              <label for="inputName">Nama Proyek</label>
              <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="inputDescription">Deskripsi Proyek</label>
              <textarea name="deskripsi" class="form-control" rows="4"></textarea required>
          </div>
          @if($periode->status == '1')
          <div class="form-group">
            <label for="inputName">Tanggal Mulai</label>
            <input type="date" name="mulai" value="{{$periode->tgl_awal}}" class="form-control" readonly>
          </div>
          <div class="form-group">
            <label for="inputName">Tanggal Selesai</label>
            <input type="date" value="{{$periode->tgl_akhir}}" name="jatuh_tempo" class="form-control" readonly>
          </div>
          @endif
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="Dosen">Dosen Pembimbing</label>
          <select id="Dosen" class="form-control custom-select" name="dosen" required>
            <option value="" selected disabled>Pilih Dosen</option>
            @foreach($dsn as $ddsn)
            <option value="{{ $ddsn->no_induk }}">{{$ddsn->name}}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label for="Mahasiswa1">Mahasiswa 1</label>
          <select id="Mahasiswa1" class="form-control custom-select" name="mahasiswa1">
            <option  value="" selected disabled>Pilih Mahasiswa</option>
            @foreach($mhs as $mhs1)
            <option value="{{ $mhs1->no_induk }}">{{ $mhs1->no_induk }} {{$mhs1->name}}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label for="Mahasiswa2">Mahasiswa 2</label>
          <select id="Mahasiswa2" class="form-control custom-select" name="mahasiswa2" >
            <option value="" selected disabled>Pilih Mahasiswa</option>
            @foreach($mhs as $mhs2)
            <option value="{{ $mhs2->no_induk }}">{{ $mhs2->no_induk }} {{$mhs2->name}}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label for="Mahasiswa3">Mahasiswa 3</label>
          <select id="Mahasiswa3" class="form-control custom-select" name="mahasiswa3" >
            <option value="" selected disabled>Pilih Mahasiswa</option>
            @foreach($mhs as $mhs3)
            <option value="{{ $mhs3->no_induk }}"> {{ $mhs3->no_induk }} {{$mhs3->name}}</option>
            @endforeach
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        
        <input type="submit" value="Buat Proyek Baru" class="btn btn-success float-right">
      </div>
    </div>
  </div>
</div>
</div>
</div>
<script>
    const mhs1 = document.getElementById('Mahasiswa1');
    const mhs2 = document.getElementById('Mahasiswa2');
    const mhs3 = document.getElementById('Mahasiswa3');
    const mhsList = document.querySelectorAll('.mhs-list');

    function disableSelectedOption(selectedValue, dropdownList) {
        dropdownList.forEach((dropdown) => {
            const options = dropdown.querySelectorAll('option');
            options.forEach((option) => {
                if (option.value === selectedValue) {
                    option.disabled = true;
                } else {
                    option.disabled = false;
                }
            });
        });
    }

    mhs1.addEventListener('change', () => {
        disableSelectedOption(mhs1.value, [mhs2, mhs3]);
    });

    mhs2.addEventListener('change', () => {
        disableSelectedOption(mhs2.value, [mhs1, mhs3]);
    });

    mhs3.addEventListener('change', () => {
        disableSelectedOption(mhs3.value, [mhs1, mhs2]);
    });
</script>
<!-- <script>
  $(document).ready(function() {
  $('.mahasiswa-dropdown').change(function() {
    var selectedValue = $(this).val();
    var selectedDropdownId = $(this).data('dropdown-id');
    $('.mahasiswa-dropdown').not(this).find('option').prop('disabled', false);
    $('.mahasiswa-dropdown').not(this).each(function() {
      var dropdownId = $(this).data('dropdown-id');
      if (dropdownId !== selectedDropdownId) {
        $(this).find('option[value="' + selectedValue + '"]').prop('disabled', true);
      }
    });
  });
});
</script> -->
@endsection