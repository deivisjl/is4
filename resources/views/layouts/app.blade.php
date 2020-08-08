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
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('dist/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dist/css/styles.css') }}">
  <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }}">
  <style>.dataTables_filter{float: right;} #example1_paginate{float: right;} .pull-right {} .text-sm .content-header {
    padding: 3px .1rem;}</style>
</head>
<body class="hold-transition layout-top-nav text-sm">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-dark navbar-blue">
    <div class="container-fluid">
      <a href="#" class="navbar-brand">
        <span class="brand-text font-weight-bold">IGPA</span>
      </a>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <!-- <li class="nav-item active">
            <a href="#" class="nav-link">Carreras</a>
          </li>
          <li class="nav-item active">
            <a href="#" class="nav-link">Aulas</a>
          </li> -->
          <li class="nav-item dropdown active">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Administrar</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="{{ route('roles.index') }}" class="dropdown-item">Roles</a></li>
              <li><a href="#" class="dropdown-item">Carreras </a></li>
              <li><a href="#" class="dropdown-item">Cursos</a></li>
            </ul>
          </li>
          <li class="nav-item active">
            <a href="{{ route('usuarios.index') }}" class="nav-link">Usuarios</a>
          </li>
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
            <span class="dropdown-header">Administrador</span>
            <div class="dropdown-divider"></div>
            <div class="dropdown-divider"></div>
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
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ asset('dist/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('dist/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('dist/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dist/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('dist/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('dist//datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>

<script src="{{ asset('js/application.js') }}"></script>
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
@yield('js')
<!-- Page specific script -->
</body>
</html>
