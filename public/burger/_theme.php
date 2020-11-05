<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="<?= asset('assets/img/favicon.png'); ?>">

    <?= $head; ?>

    <!-- CSS here -->
    <link rel="stylesheet" href="<?= asset('assets/style.min.css'); ?>">
</head>

<body>

<div class="ajax_load">
    <div class="ajax_load_box">
        <div class="ajax_load_box_circle"></div>
        <div class="ajax_load_box_title">Aguarde, carrengando...</div>
    </div>
</div>

<!--[if lte IE 9]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser.
        Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.
    </p>
<![endif]-->

<header>
    <div class="header-area ">
        <div id="sticky-header" class="main-header-area">
            <div class="container-fluid p-0">
                <div class="row align-items-center no-gutters">
                    <div class="col-xl-5 col-lg-5">
                        <div class="main-menu  d-none d-lg-block">
                            <nav>
                                <ul id="navigation">
                                    <li><a class="active" href="<?= url(); ?>">home</a></li>
                                    <li><a href="<?= url("sobre"); ?>">Sobre</a></li>
                                    <li><a href="<?= url("blog"); ?>">Blog</a></li>
                                    <li><a href="<?= url("contato"); ?>">Contato</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2">
                        <div class="logo-img">
                            <a href="<?= url(); ?>">
                                <img src="<?= asset("assets/img/logo.png"); ?>" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-5 d-none d-lg-block">
                        <div class="book_room">
                            <div class="socail_links">
                                <ul>
                                    <li>
                                        <a target="_blank" href="<?= CONF_SOCIAL["INSTAGRAM_PAGE"]; ?>" title="Instagram">
                                            <i class="fa fa-instagram"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a target="_blank" href="<?= CONF_SOCIAL["TWITTER_PAGE"]; ?>" title="Twitter">
                                            <i class="fa fa-twitter"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a target="_blank" href="<?= CONF_SOCIAL["FACEBOOK_PAGE"]; ?>" title="Facebook">
                                            <i class="fa fa-facebook"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a target="_blank" href="<?= CONF_SOCIAL["YOUTUBE_PAGE"]; ?>" title="Youtube">
                                            <i class="fa fa-youtube"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="book_btn d-none d-xl-block">
                                <a class="#" href="#"><?= CONF_SITE["ADDR_TELEPHONE"]; ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mobile_menu d-block d-lg-none"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

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
<!--                                    <h4>Maxican</h4>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?= $v->section("content"); ?>

<footer class="footer">
    <div class="footer_top">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-md-6 col-lg-4">
                    <div class="footer_widget text-center ">
                        <h3 class="footer_title pos_margin">
                            New York
                        </h3>
                        <p>5th flora, 700/D kings road, <br>
                            green lane New York-1782 <br>
                            <a href="#">info@burger.com</a></p>
                        <a class="number" href="#">+10 378 483 6782</a>

                    </div>
                </div>
                <div class="col-xl-4 col-md-6 col-lg-4">
                    <div class="footer_widget text-center ">
                        <h3 class="footer_title pos_margin">
                            California
                        </h3>
                        <p>5th flora, 700/D kings road, <br>
                            green lane New York-1782 <br>
                            <a href="#">info@burger.com</a></p>
                        <a class="number" href="#">+10 378 483 6782</a>

                    </div>
                </div>
                <div class="col-xl-4 col-md-12 col-lg-4">
                    <div class="footer_widget">
                        <h3 class="footer_title">
                            Stay Connected
                        </h3>
                        <form action="#" class="newsletter_form">
                            <input type="text" placeholder="Enter your mail">
                            <button type="submit">Sign Up</button>
                        </form>
                        <p class="newsletter_text">Stay connect with us to get exclusive offer!</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-4">
                    <div class="socail_links text-center">
                        <ul>
                            <li>
                                <a target="_blank" href="<?= CONF_SOCIAL["INSTAGRAM_PAGE"]; ?>" title="Instagram">
                                    <i class="fa fa-instagram"></i>
                                </a>
                            </li>
                            <li>
                                <a target="_blank" href="<?= CONF_SOCIAL["TWITTER_PAGE"]; ?>" title="Twitter">
                                    <i class="fa fa-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a target="_blank" href="<?= CONF_SOCIAL["FACEBOOK_PAGE"]; ?>" title="Facebook">
                                    <i class="fa fa-facebook"></i>
                                </a>
                            </li>
                            <li>
                                <a target="_blank" href="<?= CONF_SOCIAL["YOUTUBE_PAGE"]; ?>" title="Youtube">
                                    <i class="fa fa-youtube"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copy-right_text">
        <div class="container">
            <div class="footer_border"></div>
            <div class="row">
                <div class="col-xl-12">
                    <p class="copy_right text-center">
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>

<?php if (!COOKIEPOLICY): ?>
    <!--GDPR-->
    <div id="cookiePolicy" class="al-center">
        <div class="container">
            <p>Este website utiliza cookies próprios e de terceiros a fim de personalizar o conteúdo, melhorar a experiência do usuário, fornecer funções de mídias sociais e analisar o tráfego. Para continuar navegando você deve concordar com nossa <a href="<?= url("/politica-de-privacidade"); ?>">Política de Privacidade</a>.</p>
            <a data-route="<?= $router->route("web.cookie.policy"); ?>" data-cookie="agree" href="#" class="btn btn-primary">
                Sim, eu aceito.
            </a>
        </div>
    </div>
    <!--/GDPR-->
<?php endif; ?>

<!-- JS here -->
<script src="<?= asset('assets/scripts.min.js'); ?>"></script>
<?= $v->section("scripts"); ?>

</body>