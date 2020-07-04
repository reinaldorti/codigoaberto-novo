<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?= asset('assets/dist/img/AdminLTELogo.png', CONF_VIEW['ADMIN']); ?>"/>

    <?= $head; ?>

    <link rel="stylesheet" href="<?= asset('assets/plugins/fontawesome-free/css/all.min.css', CONF_VIEW['ADMIN']); ?>">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="<?= asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css', CONF_VIEW['ADMIN']); ?>">
    <link rel="stylesheet" href="<?= asset('assets/dist/css/adminlte.min.css', CONF_VIEW['ADMIN']); ?>">
    <link rel="stylesheet" href="<?= asset('assets/style.min.css', CONF_VIEW['ADMIN']); ?>">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">

<div class="ajax_load">
    <div class="ajax_load_box">
        <div class="ajax_load_box_circle"></div>
        <div class="ajax_load_box_title">Aguarde, carrengando...</div>
    </div>
</div>

<?= $v->section("content"); ?>

<script src="<?= asset('assets/scripts.min.js', CONF_VIEW['ADMIN']); ?>"></script>
</body>
</html>
