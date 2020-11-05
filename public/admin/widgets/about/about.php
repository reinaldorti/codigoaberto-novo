<?php
$v->layout("dash"); ?>
<div class="content-wrapper" style="min-height: 1200.88px;">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <?php if (!$about): ?>
                    <div class="col-sm-6">
                        <h4>Novo Sobre</h4>
                    </div>
                <?php else: ?>
                    <div class="col-sm-6">
                        <h4>Editar Sobre</h4>
                    </div>
                <?php endif; ?>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= url('admin/dash'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= url('admin/about/home'); ?>">Sobre</a></li>
                        <li class="breadcrumb-item active">
                            <a href="<?= url('admin/about/about'); ?>">Novo</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="mce_upload" style="z-index: 997;">
        <div class="mce_upload_box">
            <form action="<?= url("admin/about/about"); ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="upload" value="true"/>
                <input type="hidden" name="action" value="create"/>
                <label>
                    <label class="legend">Selecione uma imagem JPG ou PNG:</label>
                    <input accept="image/*" type="file" name="image" required/>
                </label>
                <button class="btn btn-primary">Enviar Imagem</button>
            </form>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <?php if (!$about): ?>
                    <div class="col-12 card card-primary">
                        <form action="<?= url('admin/about/about'); ?>" method="post">
                            <input type="hidden" name="action" value="create"/>
                            <?= $csrf; ?>

                            <div class="card-body">
                                <div class="login_form_callback teste">
                                    <?= flash(); ?>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Título (*)</label>
                                            <input type="text" name="title" class="form-control" placeholder="Título">
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
                        <form action="<?= url("admin/about/about/{$about->id}"); ?>" method="post">
                            <input type="hidden" name="action" value="update"/>
                            <?= $csrf; ?>

                            <div class="card-body">
                                <div class="login_form_callback">
                                    <?= flash(); ?>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Título (*)</label>
                                            <input type="text" name="title" class="form-control" value="<?= $about->title; ?>" placeholder="Título">
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
                                                    if (isset($about->status) && $about->status == $id):
                                                        echo 'selected';
                                                    endif;
                                                    echo "> {$desc}</option>";
                                                endforeach;
                                                ?>
                                            </select>
                                        </div>
                                    </div>  
                                    
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Conteúdo</label>
                                            <textarea class="mce" name="content"><?= $about->content; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">Atualizar</button>
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
    </script>
<?php $v->end(); ?>