
<?php $v->layout("_theme"); ?>

<div class="slider_area">
    <?php if (empty($slides)): ?>
        <div class="single_slider d-flex align-items-center justify-content-center overlay">
            <div class="alert alert-info text-center">
                <i class='fa fa-warning'></i>Oops! Ainda não existe slide cadastrados no momento!
            </div>
        </div>
    <?php else: ?>
        <div class="slider_active owl-carousel">
            <?php foreach ($slides as $slide): ?>
                <div class="single_slider  d-flex align-items-center overlay" style="background-image:url(<?= image($slide->cover); ?>)">
                    <div class="container">
                        <div class="row align-items-center justify-content-center">
                            <div class="col-xl-9 col-md-9 col-md-12">
                                <div class="slider_text text-center">
                                    <div class="deal_text">
                                        <span><?= $slide->title; ?></span>
                                    </div>
                                    <h3><?= $slide->subtitle; ?></h3>
                                    <!--<h4>Maxican</h4>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<div class="best_burgers_area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section_title text-center mb-80">
                    <span>Burger Menu</span>
                    <h3>Best Ever Burgers</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6 col-md-6 col-lg-6">
                <div class="single_delicious d-flex align-items-center">
                    <div class="thumb">
                        <img src="<?= asset("assets/img/burger/1.png"); ?>" alt="">
                    </div>
                    <div class="info">
                        <h3>Beefy Burgers</h3>
                        <p>Great way to make your business appear trust and relevant.</p>
                        <span>$5</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6">
                <div class="single_delicious d-flex align-items-center">
                    <div class="thumb">
                        <img src="<?= asset("assets/img/burger/2.png"); ?>" alt="">
                    </div>
                    <div class="info">
                        <h3>Burger Boys</h3>
                        <p>Great way to make your business appear trust and relevant.</p>
                        <span>$5</span>
                    </div>
                </div>

            </div>
            <div class="col-lg-6 col-md-6">
                <div class="single_delicious d-flex align-items-center">
                    <div class="thumb">
                        <img src="<?= asset("assets/img/burger/3.png"); ?>" alt="">
                    </div>
                    <div class="info">
                        <h3>Burger Bizz</h3>
                        <p>Great way to make your business appear trust and relevant.</p>
                        <span>$5</span>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-6 col-lg-6">
                <div class="single_delicious d-flex align-items-center">
                    <div class="thumb">
                        <img src="<?= asset("assets/img/burger/4.png"); ?>" alt="">
                    </div>
                    <div class="info">
                        <h3>Crackles Burger</h3>
                        <p>Great way to make your business appear trust and relevant.</p>
                        <span>$5</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="single_delicious d-flex align-items-center">
                    <div class="thumb">
                        <img src="<?= asset("assets/img/burger/5.png"); ?>" alt="">
                    </div>
                    <div class="info">
                        <h3>Bull Burgers</h3>
                        <p>Great way to make your business appear trust and relevant.</p>
                        <span>$5</span>
                    </div>
                </div>

            </div>
            <div class="col-lg-6 col-md-6">
                <div class="single_delicious d-flex align-items-center">
                    <div class="thumb">
                        <img src="<?= asset("assets/img/burger/6.png"); ?>" alt="">
                    </div>
                    <div class="info">
                        <h3>Rocket Burgers</h3>
                        <p>Great way to make your business appear trust and relevant.</p>
                        <span>$5</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="single_delicious d-flex align-items-center">
                    <div class="thumb">
                        <img src="<?= asset("assets/img/burger/7.png"); ?>" alt="">
                    </div>
                    <div class="info">
                        <h3>Smokin Burger</h3>
                        <p>Great way to make your business appear trust and relevant.</p>
                        <span>$5</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="single_delicious d-flex align-items-center">
                    <div class="thumb">
                        <img src="<?= asset("assets/img/burger/8.png"); ?>" alt="">
                    </div>
                    <div class="info">
                        <h3>Delish Burger</h3>
                        <p>Great way to make your business appear trust and relevant.</p>
                        <span>$5</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="iteam_links">
                    <a class="boxed-btn5" href="Menu.html">More Items</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="Burger_President_area">
    <div class="Burger_President_here">
        <div class="single_Burger_President">
            <div class="room_thumb">
                <img src="<?= asset("assets/img/burgers/1.png"); ?>" alt="">
                <div class="room_heading d-flex justify-content-between align-items-center">
                    <div class="room_heading_inner">
                        <span>$20</span>
                        <h3>The Burger President</h3>
                        <p>Great way to make your business appear trust <br> and relevant.</p>
                        <a href="#" class="boxed-btn3">Order Now</a>
                    </div>

                </div>
            </div>
        </div>
        <div class="single_Burger_President">
            <div class="room_thumb">
                <img src="<?= asset("assets/img/burgers/2.png"); ?>" alt="">
                <div class="room_heading d-flex justify-content-between align-items-center">
                    <div class="room_heading_inner">
                        <span>$20</span>
                        <h3>The Burger President</h3>
                        <p>Great way to make your business appear trust <br> and relevant.</p>
                        <a href="#" class="boxed-btn3">Order Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($about)): ?>
    <div class="about_area">
        <div class="container">
            <div class="row align-items-center">
                <?php foreach ($about as $row): ?>
                <div class="col-xl-6 col-lg-6 col-md-6">
                    <div class="about_thumb2">
                        <div class="img_1">
                            <img src="<?= asset("assets/img/about/1.png"); ?>" alt="">
                        </div>
                        <div class="img_2">
                            <img src="<?= asset("assets/img/about/2.png"); ?>" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-5 offset-lg-1 col-md-6">
                    <div class="about_info">
                        <div class="section_title mb-20px">
                            <span>Sobre</span>
                            <h3><?= str_limit_chars($row->title, 50); ?></h3>
                        </div>
                        <p><?= str_limit_chars($row->content, 500); ?></p>
                        <div class="img_thumb">
                            <img src="<?= asset("assets/img/jessica-signature.png"); ?>" alt="">
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="video_area video_bg overlay">
    <div class="video_area_inner text-center">
        <h3>Burger <br>
            Bachelor</h3>
        <span>How we make delicious Burger</span>
        <div class="video_payer">
            <a href="https://www.youtube.com/watch?v=vLnPwxZdW4Y" class="video_btn popup-video">
                <i class="fa fa-play"></i>
            </a>
        </div>
    </div>
</div>

<?php $v->insert("testimonial"); ?>

<?php $v->insert("instagram"); ?>



