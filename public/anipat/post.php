
<?php $v->layout("_theme"); ?>

<div class="bradcam_area breadcam_bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="bradcam_text text-center">
                    <h3><?= $post->title; ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="blog_area single-post-area section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 posts-list">
                <div class="single-post">
                    <?php if ($post->video): ?>
                        <div class="embed-container">
                            <iframe id="mediaview" width="740" height="460" src="https://www.youtube.com/embed/<?= $post->video; ?>?rel=0&amp;showinfo=0&autoplay=0&origin=<?= CONF_VIEW['THEME']; ?>" frameborder="0" allowfullscreen></iframe>
                        </div>
                    <?php else: ?>
                        <div class="feature-img">
                            <img class="img-fluid" src="<?= (!empty($post->cover) ? image($post->cover, 730) : asset("assets/img/no_image.jpg", CONF_VIEW['THEME'])); ?>" alt="">
                        </div>
                    <?php endif; ?>

                    <div class="blog_details">
                        <h2><?= $post->subtitle; ?></h2>
                        <ul class="blog-info-link mt-3 mb-4">
                            <li>
                                <a>
                                    <i class="fa fa-user"></i>
                                    <?= "{$post->author()->first_name} {$post->author()->last_name}"; ?>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-calendar"></i>
                                    <?= date("d/m/Y", strtotime($post->post_at)); ?>
                                </a>
                            </li>
                        </ul>
                        <p class="excert">
                            <?= $post->content; ?>
                        </p>
                    </div>
                </div>
                <div class="navigation-top">
                    <div class="d-sm-flex justify-content-between text-center">
                        <ul class="social-icons">
                            <li><a href="#"><i class="fa fa-facebook-f"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                            <li><a href="#"><i class="fa fa-behance"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php $v->insert("posts-sidebar"); ?>
        </div>
    </div>
</section>

