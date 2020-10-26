<?php
$v->layout("dash"); ?>
<div class="content-wrapper" style="min-height: 1200.88px;">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Depoimentos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= url('admin/dash'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Depoimentos</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6">
                                    <form action="<?= url("/admin/testimony/home"); ?>" method="post">
                                        <div class="input-group input-group-sm" style="width: 150px;">
                                            <input type="text" name="s" class="form-control float-right"
                                                   value="<?= $search; ?>" placeholder="Search" required>
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-default">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="col-6">
                                    <a href="<?= url('admin/testimony/testimony'); ?>" class="btn btn-success float-right">
                                        Novo Depoimento
                                    </a>
                                </div>
                            </div>
                        </div>

                        <?php
                        if (!empty($_SESSION["flash"])): ?>
                            <div class="card-header">
                                <div class="login_form_callback">
                                    <?= flash(); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="card-body table-responsive p-0">
                            <?php if (empty($testimony)): ?>
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="alert alert-info alert-dismissible text-center">
                                                <i class='icon fas fa-info'></i>  Oops! Não existe depoimentos cadastrados no momento!
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <table class="table table-head-fixed text-nowrap">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>Data</th>
                                        <th>Ações</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($testimony as $comment):
                                        ?>
                                        <tr>
                                            <td><?= str_pad($comment->id, 4, 0, STR_PAD_LEFT); ?></td>
                                            <td><?= str_chars($comment->title, 60); ?></td>
                                            <td><?= status($comment->status); ?></td>
                                            <td><?= date('d/m/Y', strtotime($comment->created_at)); ?></td>
                                            <td>
                                                <div class="col-12 note" id="<?= $comment->id; ?>">
                                                    <a class="btn btn-info btn-sm" title="Editar post"
                                                       href="<?= url("/admin/testimony/testimony/{$comment->id}"); ?>">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>

                                                    <a href="#" title="Remover post" rel="note"
                                                       class="btn btn-danger btn-sm js_delete_action"
                                                       id="<?= $comment->id; ?>" > <i class="fas fa-trash"></i>
                                                    </a>

                                                    <a href="<?= url("/admin/testimony/delete/{$comment->id}"); ?>" rel="note"
                                                       class="btn btn-warning btn-sm js_delete_action_confirm"
                                                       id="<?= $comment->id; ?>" title="Remover agora?"
                                                       style="display: none;">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <?= $paginator; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>