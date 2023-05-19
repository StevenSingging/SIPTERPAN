@extends('template.master')
<title>My Task List</title>
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0"></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">My Task List</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
@foreach($tasklist as $tasks)
<ul class="todo-list" data-widget="todo-list">
  <li>
    <!-- drag handle -->
    <span class="handle">
      <i class="fas fa-ellipsis-v"></i>
      <i class="fas fa-ellipsis-v"></i>
    </span>
    <?php if ($tasks->file_id==null) { ?>
      <div class="icheck-primary d-inline ml-2">
        <input type="checkbox" value="" name="todo1" id="todoCheck1" disabled>
        <label for="todoCheck1"></label>
      </div>
    <?php } else { ?>
      <div class="icheck-primary d-inline ml-2">
        <input type="checkbox" value="" name="todo1" id="todoCheck1" checked disabled>
        <label for="todoCheck1"></label>
      </div>
    <?php } ?>
    <!-- todo text -->
    <span class="text">{{$tasks->nama}}</span>
    <!-- Emphasis label -->
    <small class="badge badge-danger"><i class="far fa-clock"></i> {{$tasks->jatuh_tempo}}</small>
    <!-- General tools such as edit or delete-->
    <div class="tools">
      <a href="#edittask{{$tasks->id}}" data-toggle="modal"> <i class="fas fa-edit"></i></a>
      <i class="fas fa-trash-o"></i>
    </div>
    <div class="modal fade" id="edittask{{$tasks->id}}">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Task</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="{{url('/mahasiswa/updatetask',$tasks->id)}}" method="post" enctype="multipart/form-data">
              {{ csrf_field() }}
              <div class="form-group">
                <label>Task Name</label>
                <input type="text" value="{{$tasks->nama}}" name="nama" class="form-control" readonly>
              </div>
              <div class="form-group">
                <label>Start</label>
                <input type="date" value="{{$tasks->mulai}}" name="nama" class="form-control" readonly>
              </div>
              <div class="form-group">
                <label>End Date</label>
                <input type="date" value="{{$tasks->jatuh_tempo}}" name="nama" class="form-control" readonly>
              </div>
              @if($tasks->file_id == null)
              <div class="form-group">
                <label>Input File</label>
                <input type="file" name="filec" class="form-control">
              </div>
              @else
              <div class="form-group">
                <label>Input File</label>
                <input type="file" name="filec" value="{{$tasks->filet->file_name}}" class="form-control">
              </div>
              @endif
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
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
  </li>
  @endforeach
  @endsection
</ul>