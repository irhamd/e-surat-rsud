<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>E-Surat RSUD Kota Mataram</title>
        <link rel="icon" href="{{  asset('images/icon.png') }}">
        <!-- Tell the browser to be responsive to screen width -->
        <meta
            content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"
            name="viewport">

        <!-- Bootstrap 3.3.7 -->
        @include('Main/MainCss')
        @include('Main/MainJS')


        
        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" /> --}}

    </head>


    <body class="skin-blue">

 
        <div class="wrapper">

            <header class="main-header header">
                <a href="" class="logo header">
                    <span class="logo-mini"> E-Surat</span>
                    <span class="logo-lg"> <b> <img src="images/img/esurat.png" alt="E"> </b></span>
                </a>
                <nav class="navbar navbar-static-top biru">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>

                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- Messages: style can be found in dropdown.less-->
                            <li class="dropdown messages-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-envelope-o"></i>
                                    <span class="label label-success">4</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">You have 4 messages</li>
                                    <li>
                                        <!-- inner menu: contains the actual data -->
                                        <ul class="menu">
                                            <li>
                                                <!-- start message -->
                                                <a href="#">
                                                    <div class="pull-left">
                                                        <img
                                                            src="{{asset('images/icon.png') }}" class="img-circle" alt="User">
                                                    </div>
                                                    <h4>
                                                        Support Team
                                                        <small>
                                                            <i class="fa fa-clock-o"></i>
                                                            5 mins</small>
                                                    </h4>
                                                    <p>Why not buy a new awesome theme?</p>
                                                </a>
                                            </li>
                                            <!-- end message -->
                                        </ul>
                                    </li>
                                    <li class="footer">
                                        <a href="#">See All Messages</a>
                                    </li>
                                </ul>
                            </li>
                            <!-- Notifications: style can be found in dropdown.less -->
                            <li class="dropdown notifications-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-bell-o"></i>
                                    <span class="label label-warning">10</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">You have 10 notifications</li>
                                    <li>
                                        <!-- inner menu: contains the actual data -->
                                        <ul class="menu">
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-users text-aqua"></i>
                                                    5 new members joined today
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="footer">
                                        <a href="#">View all</a>
                                    </li>
                                </ul>
                            </li>
                            <!-- Tasks: style can be found in dropdown.less -->
                            <li class="dropdown tasks-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-flag-o"></i>
                                <span class="label label-danger">{{Session('keranjang')  }} </span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">You have 9 tasks</li>
                                    <li>
                                        <!-- inner menu: contains the actual data -->
                                        <ul class="menu">
                                            <li>
                                                <!-- Task item -->
                                                <a href="#">
                                                    <h3>
                                                        Design some buttons
                                                        <small class="pull-right">20%</small>
                                                    </h3>
                                                    <div class="progress xs">
                                                        <div
                                                            class="progress-bar progress-bar-aqua"
                                                            style="width: 20%"
                                                            role="progressbar"
                                                            aria-valuenow="20"
                                                            aria-valuemin="0"
                                                            aria-valuemax="100">
                                                            <span class="sr-only">20% Complete</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                            <!-- end task item -->
                                        </ul>
                                    </li>
                                    <li class="footer">
                                        <a href="#">View all tasks</a>
                                    </li>
                                </ul>
                            </li>
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img
                                        src="{{asset('dist/img/usr.png') }}"
                                        class="user-image"
                                        alt="User Image">
                                    <span class="hidden-xs">{{ Auth::user()->namaexternal }}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img
                                            src="{{asset('dist/img/usr.png') }}"
                                            class="img-circle"
                                            alt="User Image">

                                        <p>
                                            Alexander Pierce - Web Developer
                                            <small>Member since Nov. 2012</small>
                                        </p>
                                    </li>
                                    <!-- Menu Body -->
                                    <li class="user-body">
                                        <div class="row">
                                            <div class="col-xs-4 text-center">
                                                <a href="#">Followers</a>
                                            </div>
                                            <div class="col-xs-4 text-center">
                                                <a href="#">Sales</a>
                                            </div>
                                            <div class="col-xs-4 text-center">
                                                <a href="#">Friends</a>
                                            </div>
                                        </div>
                                        <!-- /.row -->
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="#" class="btn btn-default btn-flat">Profile</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="#" class="btn btn-default btn-flat">Sign out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <!-- Control Sidebar Toggle Button -->
                            <li>
                                <a href="#" data-toggle="control-sidebar">
                                    <i class="fa fa-gears"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img
                                src="{{asset('images/icon1.png') }}"
                                class="img-circle"
                                alt="User Image">
                        </div>
                        <div class="pull-left info">
                            <p>LOGIN SIMRS</p>
                            <a href="#">
                                <i class="fa fa-circle text-success"></i>
                                Online</a>
                        </div>
                    </div>
                    @include('Main/Menu')
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
               

                <!-- Main content -->
                <section class="content">
                    <div class="row">

                        @yield('content')
                    </div>
                    <!-- /.row -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>FHDev</b>
                    team
                </div>
                @if(\Session::has('error1'))
                <p> ERRORRR </p>
                @endif
                <strong>Copyright &copy; 2020 <i> v.1.5 </i>
                    <a href="">simrs@rsudkotamataram</a>.</strong>
                All rights reserved.
            </footer>

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">                 
                <div class="tab-content" style="margin: 10px">

                    <div class="alert alert-info">
                       <span class="fa fa-gear"></span>  Ganti Password
                    </div>

                    @if (Session::has('berhasil'))
                        <p> {{Session::get("berhasil") }}</p>
                    @endif
                    @if (Session::has('gagal'))
                        <p> {{Session::get("gagal") }}</p>
                    @endif

                    <form action="/gantipassword" method="post">
                        @csrf
                        <div class="form-group">
                            <label>Password Lama</label>
                                <input name="passwordlama"  type="password"  class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Password Baru</label>
                                <input name="passwordbaru"  type="password"  class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Password Baru Lagi</label>
                                <input name="passwordbarulagi"  type="password"  class="form-control" required>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-success"> OK </button>
                            <button class="btn btn-danger"> Batal </button>
                            
                        </div>


                    </form>
                    
                    
                    <!-- Home tab content -->
                    
                    <!-- /.tab-pane -->
                    <!-- Stats tab content -->
                    <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
                    <!-- /.tab-pane -->
                    <!-- Settings tab content -->
                  
                    <!-- /.tab-pane -->
                </div>
            </aside>
            <!-- /.control-sidebar -->
            <!-- Add the sidebar's background. This div must be placed immediately after the
            control sidebar -->
            <div class="control-sidebar-bg"></div>
        </div>
        <!-- ./wrapper -->

        <!-- Page Script -->
        
    </body>
</html>
@include('Helper/SessionNotification')