<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?= $head; ?>

    <link rel="shortcut icon" href="<?= asset('assets/bootstrap/dist/img/AdminLTELogo.png', CONF_VIEW['ADMIN']); ?>"/>
    <link rel="stylesheet" href="<?= asset("assets/bootstrap/plugins/fontawesome-free/css/all.min.css", CONF_VIEW['ADMIN']); ?>">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="<?= asset("assets/bootstrap/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css", CONF_VIEW['ADMIN']); ?>">
    <link rel="stylesheet" href="<?= asset("assets/bootstrap/plugins/icheck-bootstrap/icheck-bootstrap.min.css", CONF_VIEW['ADMIN']); ?>">
    <link rel="stylesheet" href="<?= asset("assets/bootstrap/plugins/jqvmap/jqvmap.min.css", CONF_VIEW['ADMIN']); ?>">

    <link rel="stylesheet" href="<?= asset("assets/bootstrap/plugins/select2/css/select2.min.css", CONF_VIEW['ADMIN']); ?>">
    <link rel="stylesheet" href="<?= asset("assets/bootstrap/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css", CONF_VIEW['ADMIN']); ?>">

    <link rel="stylesheet" href="<?= asset("assets/bootstrap/dist/css/adminlte.min.css", CONF_VIEW['ADMIN']); ?>">
    <link rel="stylesheet" href="<?= asset("assets/bootstrap/plugins/overlayScrollbars/css/OverlayScrollbars.min.css", CONF_VIEW['ADMIN']); ?>">
    <link rel="stylesheet" href="<?= asset("assets/bootstrap/plugins/daterangepicker/daterangepicker.css", CONF_VIEW['ADMIN']); ?>">
    <link rel="stylesheet" href="<?= asset("assets/bootstrap/plugins/summernote/summernote-bs4.css", CONF_VIEW['ADMIN']); ?>">
    <link rel="stylesheet" href="<?= asset("assets/datepicker/datepicker.min.css", CONF_VIEW['ADMIN']); ?>">

    <link rel="stylesheet" href="<?= url('shared/css/boot.css'); ?>">
    <link rel="stylesheet" href="<?= url('shared/css/load.css'); ?>">
    <link rel="stylesheet" href="<?= url('shared/css/message.css'); ?>">

    <!--link rel="stylesheet" href="<?//= asset('assets/style.min.css', CONF_VIEW['ADMIN']); ?>"-->

    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed">

<div class="ajax_load">
    <div class="ajax_load_box">
        <div class="ajax_load_box_circle"></div>
        <p class="ajax_load_box_title">Aguarde, carregando...</p>
    </div>
</div>

<div class="wrapper">
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <div class="print" style="padding: 10px;">
            <a title="Sair!" href="<?= url('admin/dash/sair'); ?>" class="icon-exit icon-notext btn btn-danger">
                SAIR!
            </a>
        </div>
    </ul>
  </nav>

  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="<?= url('admin/dash'); ?>" class="brand-link">
      <img src="<?= asset('assets/bootstrap/dist/img/AdminLTELogo.png', CONF_VIEW['ADMIN']); ?>" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <div class="sidebar">
        <?php $v->insert("menu"); ?>
    </div>
  </aside>

  <?= $v->section("content"); ?>

  <footer class="main-footer">
    <strong>
        Copyright &copy; 2014-2020 <a href="mailto:<?= CONF_MAIL['FROM_EMAIL']; ?>?subject=Código Aberto">Reinaldo Dorti</a>.
    </strong>
    Todos os direitos reservados.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.0.2
    </div>
  </footer>
</div>

<!-- jQuery -->
<script src="<?= asset('assets/bootstrap/plugins/jquery/jquery.min.js', CONF_VIEW['ADMIN']); ?>"></script>
<script src="<?= asset('assets/bootstrap/plugins/jquery-ui/jquery-ui.min.js', CONF_VIEW['ADMIN']); ?>"></script>
<script src="<?= asset('assets/bootstrap/plugins/bootstrap/js/bootstrap.bundle.min.js', CONF_VIEW['ADMIN']); ?>"></script>
<script src="<?= asset('assets/bootstrap/dist/js/adminlte.js', CONF_VIEW['ADMIN']); ?>"></script>
<script src="<?= asset('assets/bootstrap/dist/js/demo.js', CONF_VIEW['ADMIN']); ?>"></script>

<script src="<?= url("/shared/js/jquery.min.js"); ?>"></script>
<script src="<?= url("/shared/js/jquery.form.js"); ?>"></script>
<script src="<?= url("/shared/js/jquery-ui.js"); ?>"></script>
<script src="<?= url("/shared/js/jquery.mask.js"); ?>"></script>
<script src="<?= url("/shared/shadowbox/shadowbox.js"); ?>"></script>
<script src="<?= url("/shared/tinymce/tinymce.min.js"); ?>"></script>
<script src="<?= url('/shared/js/scripts.js'); ?>"></script>

<!--<script src="><?//= asset('assets/scripts.min.js', CONF_VIEW['ADMIN']); ?>"></script>-->

<script src="<?= asset('assets/datepicker/datepicker.min.js', CONF_VIEW['ADMIN']); ?>"></script>
<script src="<?= asset('assets/datepicker/datepicker.pt-BR.js', CONF_VIEW['ADMIN']); ?>"></script>
<script src="<?= asset('assets/bootstrap/plugins/select2/js/select2.full.min.js', CONF_VIEW['ADMIN']); ?>"></script>

<?= $v->section("scripts"); ?>

</body>
</html>
