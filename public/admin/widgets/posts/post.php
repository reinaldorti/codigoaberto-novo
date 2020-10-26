<?php
$v->layout("dash"); ?>
<div class="content-wrapper" style="min-height: 1200.88px;">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <?php if (!$post): ?>
                    <div class="col-sm-6">
                        <h4>Novo Post</h4>
                    </div>
                <?php else: ?>
                    <div class="col-sm-6">
                        <h4>Editar Post</h4>
                    </div>
                <?php endif; ?>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= url('admin/dash'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= url('admin/posts/home'); ?>">Blog</a></li>
                        <li class="breadcrumb-item active">Novo</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="mce_upload" style="z-index: 997;">
        <div class="mce_upload_box">
            <form action="<?= url("admin/posts/post"); ?>" method="post" enctype="multipart/form-data">
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
                <?php if (!$post): ?>
                    <div class="col-12 card card-primary">
                        <form action="<?= url('admin/posts/post'); ?>" method="post">
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
                                            <label>Título (*)</label>
                                            <input type="text" name="title" class="form-control" placeholder="Título">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Subtítulo (*)</label>
                                            <input type="text" name="subtitle" class="form-control" placeholder="Subtítulo">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Tag (*)</label>
                                            <input type="text" name="tag" class="form-control" placeholder="Tag">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Vídeo</label>
                                            <input type="text" name="video" class="form-control"
                                                   placeholder="Nome">
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

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Data de publicação</label>
                                            <input type="text" name="post_at" class="js_datepicker form-control"
                                                   autocomplete="off"
                                                   placeholder="Data de publicação">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Link alternativo</label>
                                            <input type="text" name="uri" class="form-control"
                                                   placeholder="Link alternativo">
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Conteúdo</label>
                                            <textarea class="mce" name="content"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">Criar Post</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                <?php else: ?>
                    <div class="col-12 card card-primary">
                        <form action="<?= url("admin/posts/post/{$post->id}"); ?>" method="post">
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
                                            <input type="text" name="title" class="form-control" value="<?= $post->title; ?>" placeholder="Título">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Subtítulo (*)</label>
                                            <input type="text" name="subtitle" class="form-control" value="<?= $post->subtitle; ?>" placeholder="Subtítulo">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Tag (*)</label>
                                            <input type="text" name="tag" class="form-control" value="<?= $post->tag; ?>" placeholder="Tag">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Vídeo</label>
                                            <input type="text" name="video" class="form-control" value="<?= $post->video; ?>" placeholder="Nome">
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
                                                    if (isset($post->status) && $post->status == $id):
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
                                                    $authorId = $post->author;
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

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Data de publicação</label>
                                            <input type="text" name="post_at" class="js_datepicker form-control"
                                                   autocomplete="off"
                                                   value="<?= date("d/m/Y", strtotime($post->post_at)); ?>"
                                                   placeholder="Data de publicação"
                                            >
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Link alternativo</label>
                                            <input type="text" name="uri" class="form-control"
                                                   value="<?= $post->uri; ?>" placeholder="Link alternativo">
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Conteúdo</label>
                                            <textarea class="mce" name="content"><?= $post->content; ?></textarea>
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