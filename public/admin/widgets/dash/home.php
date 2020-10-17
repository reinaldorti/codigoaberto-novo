<?php $v->layout("dash"); ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= url('admin/dash'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Home</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= $users->users; ?></h3>
                            <p>Usuários</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="<?= url('admin/users/home'); ?>" class="small-box-footer">Ver usuários
                            <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= $blog->posts; ?></h3>
                            <p>Posts</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="<?= url('admin/posts/home'); ?>" class="small-box-footer">
                            Ver posts <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= $slides->slides; ?></h3>
                            <p>Destaques</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-images"></i>
                        </div>
                        <a href="<?= url('admin/slides/home'); ?>" class="small-box-footer">More info
                            <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>65</h3>
                            <p>Unique Visitors</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
    </section>
</div>

<?php $v->start("scripts"); ?>
<script>
    setInterval(function () {
        $.post('<?= url('admin/dash'); ?>', function (data) {
            if (data.redirect) {
                window.location.href = data.redirect.url;
            }
        }, 'json');
    }, 3000);
    // }, 5 * 60 * 1000);
</script>
<?php $v->end(); ?>