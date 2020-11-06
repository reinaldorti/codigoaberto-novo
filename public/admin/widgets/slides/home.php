<?php
$v->layout("dash"); ?>
<div class="content-wrapper" style="min-height: 1200.88px;">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Slides</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= url('admin/dash'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Slides</li>
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
                                    <form action="<?= url("/admin/slides/home"); ?>" method="post">
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
                                    <span class="j_drag_active btn btn-info float-right" style="margin-left: 10px;" title="Organizar Fotos">Ordenar</span>

                                    <a title="Novo Slide" href="<?= url('admin/slides/slide'); ?>" class="btn btn-success float-right">
                                        Novo Slide
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
                            <?php if (empty($slides)): ?>
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="alert alert-info alert-dismissible text-center">
                                                <i class='icon fas fa-info'></i>Oops! Não existe posts cadastrados no momento!
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
                                    <?php foreach ($slides as $slide): ?>
                                        <tr class="j_draganddrop" id="<?= $slide->id; ?>">
                                            <td><?= str_pad($slide->id, 4, 0, STR_PAD_LEFT); ?></td>
                                            <td><?= str_limit_words($slide->title, 60); ?></td>
                                            <td><?= status($slide->status); ?></td>
                                            <td><?= date('d/m/Y', strtotime($slide->created_at)); ?></td>
                                            <td>
                                                <div class="col-12 note" id="<?= $slide->id; ?>">
                                                    <a class="btn btn-info btn-sm" title="Editar post"
                                                       href="<?= url("/admin/slides/slide/{$slide->id}"); ?>">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>

                                                    <a href="#" title="Remover post" rel="note"
                                                       class="btn btn-danger btn-sm js_delete_action"
                                                       id="<?= $slide->id; ?>" > <i class="fas fa-trash"></i>
                                                    </a>

                                                    <a href="<?= url("/admin/slides/delete/{$slide->id}"); ?>" rel="note"
                                                       class="btn btn-warning btn-sm js_delete_action_confirm"
                                                       id="<?= $slide->id; ?>" title="Remover agora?"
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

<?php $v->start("scripts"); ?>
    <script>
        //######## DRAG AND DROP
        $("html").on('click', '.j_drag_active', function () {
            $(this).toggleClass('btn-warning');

            if ($('.j_draganddrop').attr('draggable')) {
                $('.j_draganddrop').removeAttr('draggable');
                $('html').unbind("drag dragover dragleave drop");
            } else {
                $('.j_draganddrop').attr('draggable', true);

                //DRAG EVENT
                $("html").on("drag", ".j_draganddrop", function (event) {
                    event.preventDefault();
                    event.stopPropagation();
                    wcDragContent = $(this);
                    wcDragPosition = $(this).index();
                });

                //DRAG OVER EVENT
                $("html").on("dragover", ".j_draganddrop", function (event) {
                    event.preventDefault();
                    event.stopPropagation();

                    $(this).css('border', '1px dashed #ccc');
                });

                //DRAGB LEAVE EVENT
                $("html").on("dragleave", ".j_draganddrop", function (event) {
                    event.preventDefault();
                    event.stopPropagation();

                    $(this).css('border', '0');
                });

                //DROP EVENT
                $("html").on("drop", ".j_draganddrop", function (event) {
                    event.preventDefault();
                    event.stopPropagation();

                    var wcDropElement = $(this);

                    $(wcDropElement).css('border', '0');
                    if (wcDragPosition > wcDropElement.index()) {
                        wcDropElement.before(wcDragContent);
                    } else {
                        wcDropElement.after(wcDragContent);
                    }

                    Reorder = new Array();
                    $.each($(".j_draganddrop"), function (i, el) {
                        Reorder.push([el.id, i + 1]);
                    });
                    $.post('<?= url("/admin/slides/order");?>', {Data: Reorder});
                });
            }
        });
    </script>
<?php $v->end(); ?>