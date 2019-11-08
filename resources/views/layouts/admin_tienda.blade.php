<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>NÓMINAS - Tigo </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-select.min.css')}}">


    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('css/font-awesome.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('css/_all-skins.min.css')}}">
    <link rel="apple-touch-icon" href="{{asset('img/apple-touch-icon.png')}}">
    <link rel="shortcut icon" href="{{asset('img/payroll.png')}}" >


</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header" >

        <!-- Logo -->
        <a href="#" class="logo" style="background-color: #3d9970">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>PN</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>NÓMINA Tienda</b></span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation" style="background-color: #3d9970" >
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Navegación</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Messages: style can be found in dropdown.less-->
                    <li class="dropdown">

                        <ul class="dropdown-menu" role="menu">
                            <!--<li>

                                    </li>-->
                        </ul>
                    </li>
                @if(Auth::check ())
                    <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <button class="btn-success"><small class="">Online </small></button>

                            </a>

                            <ul class="dropdown-menu">
                                <!-- User image -->


                                <li class="user-header">

                                    <p class="text-bold text-uppercase">
                                        <span class="hidden-xs">{{Auth::user()->name}}</span>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer" style="background-color: #d7ebf6">

                                    <div class="pull-right">
                                        <a class="btn btn-info" href="#">Mi cuenta</a>

                                        <a class="btn btn-danger " href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                            Cerrar Sesion
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>

                                    </div>
                                </li>
                                @endif
                            </ul>
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

            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="header"></li>

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-cogs" aria-hidden="true"></i>
                        <span>Administración</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="#"><i class="fa fa-book"></i> Roles</a></li>
                        <li><a href="#"><i class="fa fa-book"></i> Users</a></li>
                        <li><a href="#"><i class="fa fa-book"></i> Consideraciones</a></li>
                    </ul>
                </li>

                @if(auth()->user()->hasRoles(['tigo_people', 'tigo_people_admin']))
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-check-square" aria-hidden="true"></i>
                            <span>Aprobaciones Dir</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{url('aprobacion_nomina_directa')}}/{{\Carbon\Carbon::now()->format ('Ym')}}"><i class="fa fa-user-plus"></i> Aprobar Nuevos Ingresos Dir</a></li>
                            <li><a href="{{url('aprobacion_consideraciones_directa')}}/{{\Carbon\Carbon::now()->format ('Ym')}}"><i class="fa fa-check-square"></i> Aprobar consideraciones Dir</a></li>
                            <li><a href="{{url('representantes_directa/aprobacion_estructura')}}/{{\Carbon\Carbon::now()->format ('Ym')}}"><i class="fa fa-check-square"></i>Cambios Estructura Dir</a></li>
                            <li><a href="{{url('aprobar_inactivaciones')}}"><i class="fa fa-check-square"></i>Inactivaciones Directa</a></li>

                        </ul>
                    </li>
                @endif

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-users"></i>
                        <span>Representantes</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{url('representantes_directa')}}"><i class="fa fa-users"></i>Representantes Directa</a></li>
                        <li><a href="#"><i class="fa fa-users"></i>Representantes Tienda</a></li>
                        <li><a href="#"><i class="fa fa-users"></i>Representantes Indirecta</a></li>

                    </ul>
                </li>

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-list"></i> <span>Nóminas</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{url('nomina_directa')}}"><i class="fa fa-list-ol"></i>Nómina Directa</a></li>
                        <li><a href="#"><i class="fa fa-list-ol"></i>Nómina Tiendas</a></li>
                        <li><a href="#"><i class="fa fa-list-ol"></i>Nómina Indirecta</a></li>


                    </ul>
                </li>

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-line-chart" aria-hidden="true"></i>
                        <span>Objetivos</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="#"><i class="fa fa-calculator"></i> Objetivos Directa</a></li>
                        <li><a href="#"><i class="fa fa-calculator"></i> Objetivos Indirecta</a></li>
                        <li><a href="#"><i class="fa fa-calculator"></i> Objetivos Tiendas</a></li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-comment" aria-hidden="true"></i>
                        <span>Consideraciones</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{url('consideraciones_directa')}}"><i class="fa fa-comment"></i> Consideraciones Directa</a></li>
                        <li><a href="#"><i class="fa fa-comment"></i> Consideraciones Indirecta</a></li>
                        <li><a href="#"><i class="fa fa-comment"></i> Consideraciones Tiendas</a></li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-user-times" aria-hidden="true"></i>
                        <span>Inactivaciones</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{url('inactivaciones_directa')}}"><i class="fa fa-comment"></i> Inactivaciones Directa</a></li>
                        <li><a href="#"><i class="fa fa-comment"></i> Inactivaciones Indirecta</a></li>
                        <li><a href="#"><i class="fa fa-comment"></i> Inctivaciones Tiendas</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-book" aria-hidden="true"></i>
                        <span>Reportes</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{url('/generar')}}"><i class="fa fa-book"></i>Reportes Directa</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{url ('/manual')}}">
                        <i class="fa fa-life-ring"></i> <span>Ayuda</span>
                        <small class="label pull-right bg-red">PDF</small>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-info-circle"></i> <span>Acerca De...</span>
                        <small class="label pull-right bg-yellow">IT</small>
                    </a>
                </li>

                <br>
                <br>
                <li>
                    <img src="{{URL::asset('img/logotigo.png')}}" class="center-block">
                </li>
            </ul>



        </section>
        <!-- /.sidebar -->

    </aside>


    <!--Contenido-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">

            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title text-success">Nómina de Representantes</h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <!--Contenido-->
                                @yield('contenido')
                                <!--Fin Contenido-->
                                </div>
                            </div>

                        </div>
                    </div><!-- /.row -->
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </section>
    </div><!-- /.col -->
</div><!-- /.row -->

</section><!-- /.content -->
</div><!-- /.content-wrapper -->
<!--Fin-Contenido-->
<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version. </b><i class="btn-primary">Beta</i>
    </div>
    <strong>Developed by <a href="">BOC-BDS</a><span> <img src="" style="width: 2%"></span> </strong>All rights reserved. <strong>Copyright &copy; 2019.</strong>
</footer>


<!-- jQuery 2.1.4 -->
<script src="{{asset('js/jQuery-2.1.4.min.js')}}"></script>
<script type="text/javascript" src="{{asset('jquery.tablesorter.js')}}"></script>
<!-- Datepicker Files -->
<link rel="stylesheet" href="{{asset('datePicker/css/bootstrap-datepicker3.css')}}">
<link rel="stylesheet" href="{{asset('datePicker/css/bootstrap-standalone.css')}}">
<script type="text/javascript" src="{{asset('datePicker/js/bootstrap-datepicker.js')}}"></script>

<!-- Languaje -->
<script src="{{asset('datePicker/locales/bootstrap-datepicker.es.min.js')}}"></script>
@stack('scripts')

<!-- Bootstrap 3.3.5 -->
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/bootstrap-select.min.js')}}"></script>


<!-- AdminLTE App -->
<script src="{{asset('js/app.min.js')}}"></script>


</body>
</html>
