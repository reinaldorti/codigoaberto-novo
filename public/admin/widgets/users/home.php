<?php
$this->layout("dash"); ?>
<div class="content-wrapper" style="min-height: 1200.88px;">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Usuários</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= url('admin/dash'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Usuários</li>
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
                            <div class="col-6">
                                <form action="<?= url("/admin/users/home"); ?>" method="post">
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <input type="text" name="s" class="form-control float-right" value="<?= $search; ?>" placeholder="Search" required>
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="col-6">
                                <a href="<?= url('admin/users/user'); ?>" class="btn btn-success float-right">Novo Usuário</a>
                            </div>

                            <div class="col-12 mt-1">
                                <div class="login_form_callback">
                                    <?= flash(); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if (empty($users)): ?>
                        <div class="col-12 mb-1">
                            <div class="row">
                                <div class="col-12 mt-1">
                                    <div class="alert alert-info alert-dismissible text-center">
                                        <i class='icon fas fa-info'></i>  Oops! Não existe usuários cadastrados no nomento!
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>

                        <?php foreach ($users as $user): ?>
                            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                                <div class="card bg-light">
                                    <div class="card-header text-muted border-bottom-0">
                                        <h2 class="lead">
                                            <b><?= $user->first_name; ?> <?= $user->last_name; ?></b>
                                        </h2>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-7">
                                                <h6><?= $user->email; ?></h6>
                                                <p class="text-muted text-sm">Desde: <?= date("d/m/Y", strtotime($user->created_at)); ?></p>
                                                <ul class="ml-4 mb-0 fa-ul text-muted">
                                                    <li class="small">
                                                        <span class="fa-li">
                                                            <i class="fas fa-lg fa-building"></i>
                                                        </span>
                                                        <?php if (empty($user->addr()->id)): ?>
                                                            <span>Endereço não cadastrado</span>
                                                        <?php else: ?>
                                                            <span><?= $user->addr()->street; ?>, <?= $user->addr()->number; ?></span><br>
                                                            <span>Bairro: <?= $user->addr()->district; ?></span><br>
                                                            <span>Cidade: <?= $user->addr()->city; ?></span>
                                                        <?php endif; ?>
                                                    </li>
                                                    <li class="small mt-2">
                                                        <span class="fa-li">
                                                            <i class="fas fa-lg fa-phone"></i>
                                                        </span>

                                                        <p class="formPhone"><?= $user->telephone; ?></p>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-5 text-center">
                                                <?php
                                                $photo = (!empty($user->photo) ? image($user->photo) : asset("assets/images/no_avatar.jpg", CONF_VIEW['ADMIN']));
                                                echo"<img src='{$photo}' class='img-circle img-fluid' title='" . $user->first_name . "'>";
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="col-12 note" id="<?= $user->id; ?>">
                                            <a class="btn btn-info btn-sm" href="<?= url("/admin/users/user/{$user->id}"); ?>">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>

                                            <a href="#" rel="note" class="btn btn-danger btn-sm js_delete_action" id="<?= $user->id; ?>" title="Remover">
                                                <i class="fas fa-trash"></i>
                                            </a>

                                            <a href="<?= url("/admin/users/delete/{$user->id}"); ?>" rel="note" class="btn btn-warning btn-sm js_delete_action_confirm" id="<?= $user->id; ?>" title="Remover agora?" style="display: none;">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <?= $paginator; ?>
        </div>
    </section>
</div>