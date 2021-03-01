<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="{{asset("shortcut-image.png")}}"/>
  <title>PK NTP | Đăng nhập</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>Đổi mật khẩu</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">

      @if(\Illuminate\Support\Facades\Session::has('changepassword-success'))
            <div class="alert alert-success">
                {{ \Illuminate\Support\Facades\Session::get('changepassword-success') }}.
                Quay lại <a href="">Trang chủ</a>
            </div>
        @endif

      <form action="{{route('user.changepassword',$user->id)}}" method="post">
        @csrf
        <div class="form-group">
            Hello: {{$user->full_name}}  <br>
            <span class="text-danger">Thay đổi mật khẩu</span>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="oldpassword" placeholder="Mật khẩu cũ">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        @if(\Illuminate\Support\Facades\Session::has('changepassword-error'))
            <div style="color: red">
                {{ \Illuminate\Support\Facades\Session::get('changepassword-error') }}
            </div>
      @endif
        @error('oldpassword')
                <div style="color: red">*{{ $message }}</div>
        @enderror
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="newpassword" placeholder="Mật khẩu mới">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        @error('newpassword')
                <div style="color: red">*{{ $message }}</div>
        @enderror
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="verifyPassword" placeholder="Nhập lại mật khẩu mới">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>

        </div>
        @error('verifyPassword')
                <div style="color: red">*{{ $message }}</div>
        @enderror
        <div class="row">
          <div class="col">
            <button type="submit" class="btn btn-primary btn-block">Đổi mật khẩu</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>

</body>
</html>
