
<?php $v->layout("_theme"); ?>

<div class="slider_area">
    <div class="single_slider slider_bg_1 d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-6">
                    <div class="slider_text">
                        <h3>We Care <br> <span>Your Pets</span></h3>
                        <p>LEVAR CONFORTO E QUALIDADE DE VIDA <br> AO SEU ANIMALZINHO DE ESTIMAÇÃO.</p>
                        <a href="<?= $router->route("web.contact"); ?>#contact" class="boxed-btn4">Contato</a>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div class="dog_thumb d-none d-lg-block">
            <img src="<?= asset('assets/img/banner/dog.png'); ?>" alt="">
        </div>
    </div>
</div>

<div class="service_area">
    <div class="container">
        <div class="row justify-content-center ">
            <div class="col-lg-7 col-md-10">
                <div class="section_title text-center mb-95">
                    <h3>Services for every dog</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna.</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6">
                <div class="single_service">
                    <div class="service_thumb service_icon_bg_1 d-flex align-items-center justify-content-center">
                        <div class="service_icon">
                            <img src="<?= asset('assets/img/service/service_icon_1.png'); ?>" alt="">
                        </div>
                    </div>
                    <div class="service_content text-center">
                        <h3>Pet Boarding</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="single_service active">
                    <div class="service_thumb service_icon_bg_1 d-flex align-items-center justify-content-center">
                        <div class="service_icon">
                            <img src="<?= asset('assets/img/service/service_icon_2.png'); ?>" alt="">
                        </div>
                    </div>
                    <div class="service_content text-center">
                        <h3>Healthy Meals</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="single_service">
                    <div class="service_thumb service_icon_bg_1 d-flex align-items-center justify-content-center">
                        <div class="service_icon">
                            <img src="<?= asset('assets/img/service/service_icon_3.png'); ?>" alt="">
                        </div>
                    </div>
                    <div class="service_content text-center">
                        <h3>Pet Spa</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($about)): ?>
    <div class="pet_care_area">
        <div class="container">
            <div class="row align-items-center">
                <?php foreach ($about as $row): ?>
                    <div class="col-lg-5 col-md-6">
                        <div class="pet_thumb">
                            <img src="<?= asset('assets/img/about/pet_care.png'); ?>" alt="">
                        </div>
                    </div>
                    <div class="col-lg-6 offset-lg-1 col-md-6">
                        <div class="pet_info">
                            <div class="section_title">
                                <h3><span><?= str_chars($row->title, 50); ?></span> <br>
                                    As you care</h3>
                                <p><?= str_chars($row->content, 500); ?>
                                </p>
                                <a href="<?= $router->route("web.about"); ?>" class="boxed-btn3">About Us</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="adapt_area">
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-lg-5">
                <div class="adapt_help">
                    <div class="section_title">
                        <h3><span>We need your</span>
                            help Adopt Us</h3>
                        <p>Lorem ipsum dolor sit , consectetur adipiscing elit, sed do iusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices.</p>
                        <a href="<?= $router->route("web.contact"); ?>#contact" class="boxed-btn3">Contact Us</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="adapt_about">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-md-6">
                            <div class="single_adapt text-center">
                                <img src="<?= asset('assets/img/adapt_icon/1.png'); ?>" alt="">
                                <div class="adapt_content">
                                    <h3 class="counter">452</h3>
                                    <p>Pets Available</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="single_adapt text-center">
                                <img src="<?= asset('assets/img/adapt_icon/3.png'); ?>" alt="">
                                <div class="adapt_content">
                                    <h3><span class="counter">52</span>+</h3>
                                    <p>Pets Available</p>
                                </div>
                            </div>
                            <div class="single_adapt text-center">
                                <img src="<?= asset('assets/img/adapt_icon/2.png'); ?>" alt="">
                                <div class="adapt_content">
                                    <h3><span class="counter">52</span>+</h3>
                                    <p>Pets Available</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($testimony)): ?>
    <div class="testmonial_area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="textmonial_active owl-carousel">
                        <?php
                        foreach ($testimony as $comment):
                            $cover = (!empty($comment->cover) ? image($comment->cover) : asset("assets/img/no_image.jpg", CONF_VIEW['THEME']));
                            ?>
                            <div class="testmonial_wrap">
                                <div class="single_testmonial d-flex align-items-center">
                                    <div class="test_thumb">
                                        <img src="<?= $cover; ?>" width="130" height="148" title="<?= $comment->title; ?>" alt="<?= $comment->title; ?>">
                                    </div>
                                    <div class="test_content">
                                        <h4><?= $comment->title; ?></h4>
                                        <p><?= $comment->content; ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="team_area">
    <div class="container">
        <div class="row justify-content-center ">
            <div class="col-lg-6 col-md-10">
                <div class="section_title text-center mb-95">
                    <h3>Our Team</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna.</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6">
                <div class="single_team">
                    <div class="thumb">
                        <img src="<?= asset('assets/img/team/1.png'); ?>" alt="">
                    </div>
                    <div class="member_name text-center">
                        <div class="mamber_inner">
                            <h4>Rala Emaia</h4>
                            <p>Senior Director</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="single_team">
                    <div class="thumb">
                        <img src="<?= asset('assets/img/team/2.png'); ?>" alt="">
                    </div>
                    <div class="member_name text-center">
                        <div class="mamber_inner">
                            <h4>jhon Smith</h4>
                            <p>Senior Director</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="single_team">
                    <div class="thumb">
                        <img src="<?= asset('assets/img/team/3.png'); ?>" alt="">
                    </div>
                    <div class="member_name text-center">
                        <div class="mamber_inner">
                            <h4>Rala Emaia</h4>
                            <p>Senior Director</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="contact_anipat anipat_bg_1">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="contact_text text-center">
                    <div class="section_title text-center">
                        <h3>Why go with Anipat?</h3>
                        <p>LEVAR CONFORTO E QUALIDADE DE VIDA AO SEU ANIMALZINHO DE ESTIMAÇÃO.</p>
                    </div>
                    <div class="contact_btn d-flex align-items-center justify-content-center">
                        <a href="<?= $router->route("web.contact"); ?>#contact" class="boxed-btn4">FALE CO A GENTE</a>
                        <p>Or  <a href="#"> +880 4664 216</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

