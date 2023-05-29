<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SIPterpan Register</title>
  <link rel="icon" href="https://eclass.ukdw.ac.id/images/favicon.png" type="image/png">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('AdminLTE-3.2.0/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('AdminLTE-3.2.0/dist/css/adminlte.min.css')}}">
</head>
<body class="hold-transition register-page">
<div class="register-box">
    @if(session('fail'))
    <div class="alert alert-danger" role="alert">
        {{session('fail')}}
    </div>
    @endif
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="{{url('/')}}" class="h1"><b>SI</b> Pterpan</a> 
    </div>
    <div class="card-body">
      <p class="login-box-msg">Silakan melakukan registrasi</p>

      <form action="{{route('simpanregistrasi')}}" method="post">
      {{ csrf_field() }}
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="username" placeholder="Username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" id="no_induk" name="no_induk" placeholder="NIM/NIDN">
          <div class="input-group-append">
          <button type="button" onclick="autofill()" class="btn btn-outline-primary" >search</button>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" id="name" name="name" placeholder="Full name" readonly>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password" autocomplete="on">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3" >
          <input type="text" class="form-control" id="role" name="role" placeholder="Role" readonly>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <a href="{{url('/')}}" class="text-center">Saya sudah punya akun</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="{{asset('AdminLTE-3.2.0/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('AdminLTE-3.2.0/dist/js/adminlte.min.js')}}"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
  <script type="text/javascript">
    function autofill(){
                
      // alert($(this).val());
      var no_induk = $('#no_induk').val();
      $.ajax({
          type: "GET",
          url: "{{route('autocomplete')}}",
          data: {'no_induk':no_induk },
          dataType: 'json',
          success : function(data) {
              $('#name').val(data.name);
              $('#role').val(data.status);         
          },
          error: function(response) {
              alert(response.responseJSON.message);
          }
      });
        
};
</script> 
</body>
</html>