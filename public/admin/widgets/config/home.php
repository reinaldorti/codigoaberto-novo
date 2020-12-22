<?php $v->layout("dash"); ?>

<div class="content-wrapper" style="min-height: 1200.88px;">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Backup</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= url('admin/dash'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= url('admin/users/home'); ?>">Config</a></li>
                        <li class="breadcrumb-item active"><a href="<?= url('admin/users/user'); ?>">Backup</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card card-solid">
            <div class="card-body pb-0">
                <div class="row d-flex align-items-stretch">
                    <div class="col-12 mb-1">
                        <div class="row">
                            <div class='col-sm-12'>
                                <?php
                                $backup = filter_input(INPUT_GET, 'backup', FILTER_VALIDATE_BOOLEAN);
                                if ($backup):

                                    set_time_limit(0);

                                    $backup = new \Source\Support\BackupDatabase('./', 10);
                                    $backup->setDatabase(DATA_LAYER_CONFIG['host'], DATA_LAYER_CONFIG['dbname'], DATA_LAYER_CONFIG['username'], DATA_LAYER_CONFIG['passwd']);
                                    $backup->generate();

                                    echo"<div class='alert alert-success alert-dismissible text-center'><i class='icon fas fa-check'></i>Backup foi gerado com sucesso!</div>";
                                    header("refresh: 3; " . url("admin/config/home") . "");
                                endif;

                                $delete = filter_input(INPUT_GET, 'delete', FILTER_VALIDATE_BOOLEAN);
                                if ($delete):
                                    unlink("./" . DATA_LAYER_CONFIG['dbname'] . '.sql.gz');

                                    echo"<div class='alert alert-success alert-dismissible text-center'><i class='icon fas fa-check'></i>Backup foi deletado com sucesso!</div>";
                                    header("refresh: 3; " . url("admin/config/home") . "");
                               endif;
                                ?>

                                <?php if (!file_exists("./" . DATA_LAYER_CONFIG['dbname'] . '.sql.gz')) : ?>
                                    <?php if (!$delete): ?>
                                        <div class='alert alert-info alert-dismissible text-center'><i class='icon fas fa-info'></i>Oops! Não existe backup do banco gerado no momento!</div>
                                    <?php endif; ?>

                                    <a class='btn btn-success' href='home&backup=true' title='Gerar Backup!'>
                                        Gerar Backup!
                                    </a>
                                <?php endif; ?>

                                <?php if (file_exists("./" . DATA_LAYER_CONFIG['dbname'] . '.sql.gz')): ?>

                                    <?php if (!$backup): ?>
                                        <div class="alert alert-danger alert-dismissible text-center"><i class="icon fas fa-info"></i>IMPORTANTE: Para sua segurança delete o arquivo <b><?= DATA_LAYER_CONFIG['dbname']; ?>.sql.gz</b> assim que baixar da pasta do projeto!</div>
                                    <?php endif; ?>
                                    <a class="btn btn-primary" href="<?= url(DATA_LAYER_CONFIG['dbname'] . ".sql.gz"); ?>"
                                       title="Baixar Backup!">
                                        Baixar Backup!
                                    </a>

                                    <a class="btn btn-danger ml-2" href="home&delete=true" title='Deletar Agora!'>
                                        Deletar Agora!
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>