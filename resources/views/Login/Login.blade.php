<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/dist/css/AdminLTE.min.css">
  <!-- iCheck -->


  {{-- <link rel="stylesheet" href="/plugins/iCheck/square/blue.css"> --}}
  <link rel="icon" href="{{  asset('images/icon.png') }}">

  <style>
    .login-box-body{
    box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);

    }
    <style>
/* The container */
.container {
  display: block;
  position: relative;
  padding-left: 5px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 22px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default checkbox */
.container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

/* Create a custom checkbox */
.checkmark {
  position: absolute;
  top: 0;
  left: 15px;
  height: 20px;
  width: 20px;
  background-color: #eee;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.container input:checked ~ .checkmark {
  background-color: #2196F3;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the checkmark when checked */
.container input:checked ~ .checkmark:after {
  display: block;
}

/* Style the checkmark/indicator */
.container .checkmark:after {
  left: 9px;
  top: 5px;
  width: 5px;
  height: 10px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}
</style>

  </style>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    {{-- <a ><b>FH</b>Dev</a> --}}
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg"> <strong> <span class="fa fa-key"></span> LOGIN</strong></p>
    <img width="300" src="images/img/esurat.png" alt="E">
    <br>
    <br>
    @if(\Session::has('error')) 
    <div class="text-center" >
        <p style="color: red">{{ Session("error") }} </p>
        <br>
    </div>
    @endif
    {{-- {{ __DIR__ }} --}}

    <form action="/getLogin" id="UserLoginForm" method="post">

        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
        

      <div class="form-group has-feedback">
        <input type="text" name="username" id="username" class="form-control" placeholder="Username" autocomplete="on" >
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input name="password" type="password" value="" id="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="">
            <label class="container"> &nbsp; Simpan Password
              <input type="checkbox" id="login-check">
              <span class="checkmark"></span>
            </label>

        
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat"> <span class="fa fa-unlock">  </span>&nbsp; Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <div class="social-auth-links text-center">
      <a href="https://www.facebook.com/"  class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Follow Facebook Admin</a>
      <a href="https://accounts.google.com/"  class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
        Google+</a>
    </div>
    <!-- /.social-auth-links -->

    <a align="center">admin@simrsRsudKotaMataram</a><br>
    <a style="align-content: center; width:300px">Powered by FHDevTeam</a>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
{{-- <script src="/plugins/iCheck/icheck.min.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js" integrity="sha512-3j3VU6WC5rPQB4Ld1jnLV7Kd5xr+cq9avvhwqzbH/taCRNURoeEpoPBK9pDyeukwSxwRPJ8fDgvYXd6SkaZ2TA==" crossorigin="anonymous"></script>

<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>

<script type="text/javascript">

  $(document).ready(function() {
  
      var remember = $.cookie('remember');
      if (remember == 'true') 
      {
          var username = $.cookie('username');
          var password = $.cookie('password');
          // autofill the fields
          $('#username').val(username);
          $('#password').val(password);
          $('#login-check').attr('checked',true);//#login-check checkbox id..
      }
  
  
  $("#UserLoginForm").submit(function() {
      if ($('#login-check').is(':checked')) {

          var username = $('#username').val();
          var password = $('#password').val();
  
          // set cookies to expire in 14 days
          $.cookie('username', username,{ expires: 14141414 });
          $.cookie('password', password,{ expires: 14141414 });
          $.cookie('remember', true,{ expires: 14141414 });                
      }
      else
      {
          // reset cookies
          $.cookie('username', "");
          $.cookie('password', "");
          $.cookie('remember', "");
      }
    });
  });
  
  </script>

</body>
</html>
