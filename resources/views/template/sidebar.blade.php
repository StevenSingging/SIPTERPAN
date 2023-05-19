<li class="nav-header">MAIN NAVIGATION</li>
@if(auth()->user()->role == "Mahasiswa")
<li class="nav-item">
  <a href="{{route('mahasiswa')}}" class="nav-link {{ (request()->segment(2) == 'dashboard') ? 'active' : '' }}">
    <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                  
                </p>
              </a>
            </li>
            <li class=" nav-item">
      <a href="{{route('calendarmhs')}}" class="nav-link {{ (request()->segment(2) == 'calendar') ? 'active' : '' }}">
        <i class="nav-icon far fa-calendar-alt"></i>
        <p>
          Kalender

        </p>
      </a>
</li>
<!-- <li class="nav-item">
  <a href="{{route('projectmhs')}}" class="nav-link {{ (request()->segment(2) == 'project') ? 'active' : '' }}">
    <i class="nav-icon far fa-file-alt"></i>
    <p>
      Daftar Proyek

    </p>
  </a>
</li> -->
<li class="nav-header">PROYEK</li>
@foreach ($leftmenu as $item => $value)
@foreach($value as $item1 => $value1)
@if($value1->mahasiswa1 == auth()->user()->no_induk || $value1->mahasiswa2 == auth()->user()->no_induk || $value1->mahasiswa3 == auth()->user()->no_induk)
<li class="nav-item">
  <a href="{{url('mahasiswa/vproject',$value1->id)}}" class="nav-link {{ (request()->segment(2) == 'vproject' && request()->segment(3) == $value1->id ) ? 'active' : '' }}">
    <i class="nav-icon fas fa-project-diagram"></i>
                <p>
                {{$value1->nama}}
                  
                </p>
              </a>
            </li>
  @endif
  @endforeach
  @endforeach
  @endif
@if(auth()->user()->role == "Dosen") 
<li class="nav-item">
      <a href="{{route('dosen')}}" class="nav-link {{ (request()->segment(2) == 'dashboard') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
          Dashboard

        </p>
      </a>
</li>
<li class=" nav-item">
  <a href="{{route('calendardsn')}}" class="nav-link {{ (request()->segment(2) == 'calendar') ? 'active' : '' }}">
    <i class="nav-icon far fa-calendar-alt"></i>
    <p>
      Kalender

    </p>
  </a>
</li>
<li class=" nav-item">
  <a href="{{route('nilai')}}" class="nav-link {{ (request()->segment(2) == 'nilai') ? 'active' : '' }}">
    <i class="nav-icon fas fa-file-excel"></i>
    <p>
      Nilai

    </p>
  </a>
</li>
<!-- <li class="nav-item">
  <a href="{{route('projectdsn')}}" class="nav-link {{ (request()->segment(2) == 'project') ? 'active' : '' }}">
    <i class="nav-icon far fa-file-alt"></i>
    <p>
      Proyek

    </p>
  </a>
</li> -->
<li class="nav-header">PROYEK</li>
@foreach ($leftmenu as $item => $value)
@foreach($value as $item1 => $value1)
@if($value1->dosen == auth()->user()->no_induk)
<li class="nav-item">
  <a href="{{url('dosen/vprojectdsn',$value1->id)}}" class="nav-link {{ (request()->segment(2) == 'vprojectdsn' && request()->segment(3) == $value1->id ) ? 'active' : '' }}">
    <i class="nav-icon fas fa-project-diagram"></i>
    <p>
      {{$value1->nama}}

    </p>
  </a>
</li>
@endif
@endforeach
@endforeach
@endif

@if(auth()->user()->role == "Admin") 
<li class="nav-item ">
  <a href="{{route('admin')}}" class="nav-link {{ (request()->segment(2) == 'dashboard') ? 'active' : '' }}">
    <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                
              </p>
            </a>
          </li>
          <li class=" nav-item">
      <a href="{{route('calendar')}}" class="nav-link {{ (request()->segment(2) == 'calendar') ? 'active' : '' }}">
        <i class="nav-icon far fa-calendar-alt"></i>
        <p>
          Kalender

        </p>
      </a>
</li>
<li class="nav-item">
  <a href="{{route('mhs')}}" class="nav-link {{ (request()->segment(2) == 'mahasiswa') ? 'active' : '' }}">
    <i class="nav-icon fas fa-user-graduate"></i>
    <p>
      Daftar Mahasiswa

    </p>
  </a>
</li>
<li class="nav-item">
  <a href="{{route('dsn')}}" class="nav-link {{ (request()->segment(2) == 'dosen') ? 'active' : '' }} ">
    <i class="nav-icon fas fa-user-tie"></i>
    <p>
      Daftar Dosen

    </p>
  </a>
</li>
<li class="nav-item">
  <a href="{{route('tmbhprjk')}}" class="nav-link {{ (request()->segment(2) == 'tambahproject') ? 'active' : '' }}">
    <i class="nav-icon fa-solid fa-file-circle-plus"></i>
    <p>
      Tambah Proyek

    </p>
  </a>
</li>
<li class="nav-item">
  <a href="{{route('listp')}}" class="nav-link {{ (request()->segment(2) == 'listproject') ? 'active' : '' }}">
    <i class="nav-icon fas fa-list"></i>
    <p>
      Daftar Proyek

    </p>
  </a>
</li>
<li class="nav-item">
  <a href="{{route('listperiode')}}" class="nav-link {{ (request()->segment(2) == 'listperiode') ? 'active' : '' }}">
    <i class="nav-icon fas fa-list"></i>
    <p>
      Daftar Periode

    </p>
  </a>
</li>
<li class="nav-item">
  <a href="{{route('history')}}" class="nav-link {{ (request()->segment(2) == 'history') ? 'active' : '' }}">
  <i class="nav-icon fa-solid fa-clock-rotate-left"></i>
    <p>
      Riwayat

    </p>
  </a>
</li>
<!-- <li class="nav-header">PROYEK</li>
@foreach ($leftmenu as $item => $value)
@foreach($value as $item1 => $value1)
<li class="nav-item">
  <a href="{{url('admin/vprojectadm',$value1->id)}}" class="nav-link {{ (request()->segment(2) == 'vprojectadm' && request()->segment(3) == $value1->id ) ? 'active' : '' }}">
    <i class="nav-icon fas fa-tachometer-alt"></i>
    <p>
      {{$value1->nama}}

    </p>
  </a>
</li>
@endforeach
@endforeach -->
@endif