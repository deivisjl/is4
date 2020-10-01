<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Control | IGPA</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="hold-transition layout-top-nav text-sm layout-navbar-fixed">
<div id="app">
  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand-md navbar-dark navbar-blue">
      <div class="container-fluid">
        <a href="/" class="navbar-brand">
          <img src="{{ asset('img/logo.png') }}" alt="AdminLTE Logo" class="brand-image">
        </a>
  
        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
  
        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
          <!-- Left navbar links -->
          <ul class="navbar-nav">
            @if(Auth::user()->esDigitador() || Auth::user()->esAdministrador())
              <li class="nav-item dropdown active">
                <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Administrar</a>
                <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                  <li><a href="{{ route('roles.index') }}" class="dropdown-item">Roles</a></li>
                  <li><a href="{{ route('planes.index') }}" class="dropdown-item">Plan</a></li>
                  <li><a href="{{ route('carreras.index') }}" class="dropdown-item">Carreras </a></li>
                  <li><a href="{{ route('grados.index') }}" class="dropdown-item">Grados </a></li>
                  <li><a href="{{ route('secciones.index') }}" class="dropdown-item">Secciones </a></li>
                  <li><a href="{{ route('cursos.index') }}" class="dropdown-item">Cursos</a></li>
                  <li><a href="{{ route('horarios.index') }}" class="dropdown-item">Horarios</a></li>
                  <div class="dropdown-divider"></div>
                  <li><a href="{{ route('ciclo-escolar.index') }}" class="dropdown-item">Ciclo escolar</a></li>
                  <li><a href="{{ route('planes-horarios.index') }}" class="dropdown-item">Habilitar horarios</a></li>
                  <li><a href="{{ route('carrera-grado.index') }}" class="dropdown-item">Habilitar carreras</a></li>
                </ul>
              </li>
              <li class="nav-item active">
                <a href="{{ route('usuarios.index') }}" class="nav-link">Usuarios</a>
              </li>
              <li class="nav-item active">
                <a href="{{ route('pensum.index') }}" class="nav-link">Pensum</a>
              </li>
              <li class="nav-item active">
                <a href="{{ route('aulas.index') }}" class="nav-link">Aulas</a>
              </li>
              <li class="nav-item dropdown active">
                <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Docentes</a>
                <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                  <li><a href="{{ route('docente.index') }}" class="dropdown-item">Listado de docentes</a></li>
                  <li><a href="{{ route('curso.docente') }}" class="dropdown-item">Asignar docentes</a></li>
                </ul>
              </li>
              <li class="nav-item dropdown active">
                <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Alumnos</a>
                <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                  <li><a href="{{ route('alumnos.index') }}" class="dropdown-item">Listado de alumnos</a></li>
                  <li><a href="{{ route('inscripciones.index') }}" class="dropdown-item">Inscripciones</a></li>
                </ul>
              </li>
              <li class="nav-item active">
                <a href="#" class="nav-link">Pagos</a>
              </li>
              <li class="nav-item dropdown active">
                <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Reportes</a>
                <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                  <li><a href="{{ route('notas.index') }}" class="dropdown-item">Impresión de notas</a></li>
                </ul>
              </li>
            @endif 
            @if(Auth::user()->esAdministrador())
            
            @endif
            @if(Auth::user()->esProfesor())
              <li class="nav-item active">
                <a href="{{ route('profesores.index') }}" class="nav-link">Aulas</a>
              </li>
              {{-- <li class="nav-item active">
                <a href="#" class="nav-link">Reporte de notas</a>
              </li> --}}
            @endif  
            
            {{-- <li class="nav-item active">
              <a href="{{ route('alumnos.index') }}" class="nav-link">Pagos</a>
            </li>
            <li class="nav-item active">
              <a href="{{ route('alumnos.index') }}" class="nav-link">Reportes</a>
            </li> --}}
          </ul>
        </div>
  
        <!-- Right navbar links -->
        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
          <!-- Notifications Dropdown Menu -->
          <li class="nav-item dropdown active">
            <a class="nav-link" data-toggle="dropdown" href="#">
              <i class="fas fa-user-circle" style="font-size: 1.5rem"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
              <span class="dropdown-header">{{ Auth::user()->persona->primer_nombre}} {{ Auth::user()->persona->primer_apellido}}</span>
              <div class="dropdown-divider"></div>
              {{-- <div class="dropdown-divider"></div> --}}
              <a href="/logout" class="dropdown-item">
                <i class="fas fa-sign-out-alt mr-2"></i> Cerrar sesión
              </a>
            </div>
          </li>
        </ul>
      </div>
    </nav>
    <!-- /.navbar -->
  
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="margin-bottom: 65px">
        <div class="row">
            <div class="col-md-12">
                <div class="content-header"></div>
                @if(session()->has('mensaje'))
                    <div class="container-fluid">
                        <div class="alert alert-success">
                          <button class="close" type="button" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <span><i class="icon fas fa-check"></i> {{ session()->get('mensaje') }}</span>
                      </div>
                    </div>
                @endif
                @yield('content')
            </div>
        </div>
    </div>
    <!-- /.content-wrapper -->
  
    <!-- Main Footer -->
    <footer class="main-footer">
      <!-- To the right -->
      <div class="float-right d-none d-sm-inline">
        
      </div>
      <!-- Default to the left -->
      <strong>Copyright &copy; 2020 <a href="#">IGPA</a></strong>
    </footer>
  </div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/application.js') }}"></script>
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
@yield('js')
<!-- Page specific script -->
</body>
</html>
