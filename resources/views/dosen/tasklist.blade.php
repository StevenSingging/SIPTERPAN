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
@foreach($tasklist as $tasklst)
<ul class="todo-list" data-widget="todo-list">
  <li>
    <!-- drag handle -->
    <span class="handle">
      <i class="fas fa-ellipsis-v"></i>
      <i class="fas fa-ellipsis-v"></i>
    </span>
    <!-- checkbox -->
    <div class="icheck-primary d-inline ml-2" >
      <input type="checkbox" value="" name="todo1" id="todoCheck1" disabled>
      <label for="todoCheck1"></label>
    </div>
    <!-- todo text -->
    <span class="text">{{$tasklst->nama}}</span>
    <!-- Emphasis label -->
    <small class="badge badge-danger"><i class="far fa-clock"></i> {{$tasklst->jatuh_tempo}}</small>
    <!-- General tools such as edit or delete-->
    <div class="tools">
      <i class="fas fa-edit"></i>
      <i class="fas fa-trash-o"></i>
    </div>
  </li>

</ul>
@endforeach
@endsection