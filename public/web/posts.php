
<?php $v->layout("_theme"); ?>

<div class="bradcam_area breadcam_bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="bradcam_text text-center">
                    <h3>Blog</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="blog_area section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mb-5 mb-lg-0">
                <div class="blog_left_sidebar">

                    <?php if (!empty($_SESSION["flash"])): ?>
                        <div class="login_form_callback">
                            <?= flash(); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (empty($posts)): ?>
                        <div class="login_form_callback"><div class="message info">
                                <i class="fa fa-info"></i>
                                Oops! Não existe artigos cadastrados no momento!
                            </div>
                        </div>
                    <?php else:
                        foreach ($posts as $post):
                            $cover = (!empty($post->cover) ? image($post->cover) : asset("assets/img/no_image.jpg", CONF_VIEW['THEME']));
                            ?>
                            <article class="blog_item">
                                <div class="blog_item_img">
                                    <a href="<?= url("/blog/{$post->uri}"); ?>">
                                        <img class="card-img rounded-0" src="<?= $cover; ?>" alt="">
                                    </a>
                                </div>

                                <div class="m-2"> <!--blog_details">-->
                                    <a class="d-inline-block" href="<?= url("/blog/{$post->uri}"); ?>">
                                        <h2> <?= $post->title; ?></h2>
                                    </a>
                                    <p><?= $post->subtitle; ?></p>
                                    <ul class="blog-info-link">
                                        <li><a href="#"><i class="fa fa-user"></i> <?= "{$post->author()->first_name} {$post->author()->last_name}"; ?></a></li>
                                        <li><a href="#"><i class="fa fa-calendar"></i> <?= date("d/m/Y", strtotime($post->created_at)); ?></a></li>
                                    </ul>
                                </div>
                            </article>
                        <?php
                        endforeach;
                    endif;

                    $paginator;
                    ?>
                </div>
            </div>
            <?php $v->insert("blog-sidebar"); ?>
        </div>
    </div>
</section>