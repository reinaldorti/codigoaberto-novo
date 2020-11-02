<?php
$v->layout("dash"); ?>
<div class="content-wrapper" style="min-height: 1200.88px;">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <?php if (!$testimony): ?>
                    <div class="col-sm-6">
                        <h4>Novo Depoimento</h4>
                    </div>
                <?php else: ?>
                    <div class="col-sm-6">
                        <h4>Editar Depoimento</h4>
                    </div>
                <?php endif; ?>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= url('admin/dash'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= url('admin/testimony/home'); ?>">Depoimentos</a></li>
                        <li class="breadcrumb-item active"><a href="<?= url('admin/testimony/testimony'); ?>">Depoimento</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <?php if (!$testimony): ?>
                    <div class="col-12 card card-primary">
                        <form action="<?= url('admin/testimony/testimony'); ?>" method="post">
                            <input type="hidden" name="action" value="create"/>
                            <?= $csrf; ?>

                            <div class="card-body">
                                <div class="login_form_callback">
                                    <?= flash(); ?>
                                </div>

                                <div class="form-group">
                                    <label>Foto (Opcional)</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="cover" class="custom-file-input" accept="image/png, image/jpeg">
                                            <label class="custom-file-label">Imagem</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Nome (*)</label>
                                            <input type="text" name="name" class="form-control" placeholder="Nome">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Status (*)</label>
                                            <select class="form-control js-example-basic-single" name="status">
                                                <option value="" selected="selected" disabled>Selecione...</option>
                                                <?php
                                                $status = status();
                                                foreach ($status as $id => $desc):
                                                    echo "<option value='{$id}'>{$desc}</option>";
                                                endforeach;
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Author (*)</label>
                                            <select class="js-example-basic-single form-control" name="author">
                                                <option value="" selected="selected" disabled>Selecione...</option>
                                                <?php foreach ($authors as $author): ?>
                                                    <option value="<?= $author->id; ?>">
                                                        <?= $author->fullName(); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Conteúdo</label>
                                            <textarea class="mce" name="content"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                <?php else: ?>
                    <div class="col-12 card card-primary">
                        <form action="<?= url("admin/testimony/testimony/{$testimony->id}"); ?>" method="post">
                            <input type="hidden" name="action" value="update"/>
                            <?= $csrf; ?>

                            <div class="card-body">
                                <div class="login_form_callback">
                                    <?= flash(); ?>
                                </div>

                                <div class="form-group">
                                    <label>Imagem (Opcional)</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="cover" class="custom-file-input" accept="image/png, image/jpeg">
                                            <label class="custom-file-label">Imagem</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Título (*)</label>
                                            <input type="text" name="name" class="form-control" value="<?= $testimony->name; ?>" placeholder="Título">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Status (*)</label>
                                            <select class="form-control js-example-basic-single" name="status">
                                                <option value="" selected="selected" disabled>Selecione...</option>
                                                <?php
                                                $status = status();
                                                foreach ($status as $id => $desc):
                                                    echo "<option value='{$id}'";
                                                    if (isset($testimony->status) && $testimony->status == $id):
                                                        echo 'selected';
                                                    endif;
                                                    echo "> {$desc}</option>";
                                                endforeach;
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Author (*)</label>
                                            <select class="js-example-basic-single form-control" name="author" required>
                                                <?php foreach ($authors as $author):
                                                    $authorId = $testimony->author;
                                                    $select = function ($value) use ($authorId) {
                                                        return ($authorId == $value ? "selected" : "");
                                                    };
                                                    ?>
                                                    <option <?= $select($author->id); ?>
                                                            value="<?= $author->id; ?>"><?= $author->fullName(); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Conteúdo</label>
                                            <textarea class="mce" name="content"><?= $testimony->content; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">Atualizar Post</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>

<?php $v->start("scripts"); ?>
    <script>
        //SELECT 2
        $(document).ready(function () {
            $('.js-example-basic-single').select2();
        });

        //AIR DATEPICKER
        $('.js_datepicker').datepicker({
            language: 'pt-BR',
            autoClose: true
        });
    </script>
<?php $v->end(); ?>