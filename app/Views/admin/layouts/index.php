<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ruang Inovator | WarungKu</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('adminlte/plugins/fontawesome-free/css/all.min.css') ?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?php echo base_url('adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') ?>">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('adminlte/dist/css/adminlte.min.css') ?>">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo base_url('adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') ?>">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url('adminlte/plugins/daterangepicker/daterangepicker.css') ?>">
  <!-- summernote -->
  <link rel="stylesheet" href="<?php echo base_url('adminlte/plugins/summernote/summernote-bs4.min.css') ?>">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') ?>">

  	<!-- jQuery -->
  <script src="<?php echo base_url('adminlte/plugins/jquery/jquery.min.js') ?>"></script>

	<!-- jQuery UI 1.11.4 -->
	<script src="<?php echo base_url('adminlte/plugins/jquery-ui/jquery-ui.min.js') ?>"></script>
	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <!-- DataTables  & Plugins -->
  <script src="<?php echo base_url('adminlte/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
  <script src="<?php echo base_url('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
  <script src="<?php echo base_url('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') ?>"></script>
  <script src="<?php echo base_url('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') ?>"></script>
  <script src="<?php echo base_url('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') ?>"></script>
  <script src="<?php echo base_url('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') ?>"></script>
  <script src="<?php echo base_url('adminlte/plugins/jszip/jszip.min.js') ?>"></script>
  <script src="<?php echo base_url('adminlte/plugins/pdfmake/pdfmake.min.js') ?>"></script>
  <script src="<?php echo base_url('adminlte/plugins/pdfmake/vfs_fonts.js') ?>"></script>
  <script src="<?php echo base_url('adminlte/plugins/datatables-buttons/js/buttons.html5.min.js') ?>"></script>
  <script src="<?php echo base_url('adminlte/plugins/datatables-buttons/js/buttons.print.min.js') ?>"></script>
  <script src="<?php echo base_url('adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js') ?>"></script>

  <!-- Toastr -->
  <link rel="stylesheet" href="<?php echo base_url('adminlte/plugins/toastr/toastr.min.css') ?>">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?php echo base_url('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') ?>">

  <!-- ChartJS -->
  <script src="<?php echo base_url('adminlte/plugins/chart.js/Chart.min.js') ?>"></script>
  <!-- Sparkline -->
  <script src="<?php echo base_url('adminlte/plugins/sparklines/sparkline.js') ?>"></script>
  <!-- jQuery Knob Chart -->
</head>
<body class="hold-transition sidebar-mini layout-fixed">

<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="<?php echo base_url('adminlte/dist/img/AdminLTELogo.png') ?>" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <?= $this->include('admin/layouts/head') ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
      <img src="<?php echo base_url('adminlte/dist/img/AdminLTELogo.png') ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">WarungKu</span>
    </a>

    <!-- Sidebar -->
  	<?= $this->include('admin/layouts/sidebar') ?>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
  	<?= $this->include('admin/layouts/breadcrumb') ?>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <?= $this->renderSection('content') ?>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?= $this->include('admin/layouts/footer') ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>


<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?php echo base_url('adminlte/plugins/jquery-knob/jquery.knob.min.js') ?>"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url('adminlte/plugins/moment/moment.min.js') ?>"></script>
<script src="<?php echo base_url('adminlte/plugins/daterangepicker/daterangepicker.js') ?>"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo base_url('adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') ?>"></script>
<!-- Summernote -->
<script src="<?php echo base_url('adminlte/plugins/summernote/summernote-bs4.min.js') ?>"></script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url('adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') ?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('adminlte/dist/js/adminlte.js') ?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url('adminlte/dist/js/demo.js') ?>"></script>
<!-- Toastr -->
<script src="<?php echo base_url('adminlte/plugins/toastr/toastr.min.js') ?>"></script>
<!-- SweetAlert2 -->
<script src="<?php echo base_url('adminlte/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
</body>
</html>
