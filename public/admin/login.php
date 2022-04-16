<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?= asset('assets/bootstrap/dist/img/AdminLTELogo.png', CONF_VIEW['ADMIN']); ?>"/>

    <?= $head; ?>

    <link rel="stylesheet" href="<?= asset('assets/bootstrap/plugins/fontawesome-free/css/all.min.css', CONF_VIEW['ADMIN']); ?>">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="<?= asset('assets/bootstrap/plugins/icheck-bootstrap/icheck-bootstrap.min.css', CONF_VIEW['ADMIN']); ?>">
    <link rel="stylesheet" href="<?= asset('assets/bootstrap/dist/css/adminlte.min.css', CONF_VIEW['ADMIN']); ?>">

    <link rel="stylesheet" href="<?= url('shared/css/boot.css'); ?>">
    <link rel="stylesheet" href="<?= url('shared/css/load.css'); ?>">
    <link rel="stylesheet" href="<?= url('shared/css/message.css'); ?>">

    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">

<div class="ajax_load">
    <div class="ajax_load_box">
        <div class="ajax_load_box_circle"></div>
        <div class="ajax_load_box_title">Aguarde, carrengando...</div>
    </div>
</div>

<?= $this->section("content"); ?>

<script src="<?= url('/shared/js/jquery.min.js'); ?>"></script>

<script src="<?= url('/shared/js/jquery-ui.js'); ?>"></script>
<script src="<?= url('/shared/js/jquery.form.js'); ?>"></script>
<script src="<?= url('/shared/js/login.js'); ?>"></script>

<!--script src="<?//= asset('assets/scripts.min.js', CONF_VIEW['ADMIN']); ?>"></script-->
</body>
</html>
