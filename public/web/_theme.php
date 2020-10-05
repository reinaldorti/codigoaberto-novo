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

    <?= $v->section("recaptcha"); ?>
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
Please <a href="https://browsehappy.com/"> upgrade your browser</a> to improve your experience and security.
</p>
<![endif]-->

<header>
    <div class="header-area ">
        <div class="header-top_area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-8">
                        <div class="short_contact_list">
                            <ul>
                                <li><a href="#"><?= CONF_MAIL['FROM_TELEPHONE']; ?></a></li>
                                <li><a href="#">Mon - Sat 10:00 - 7:00</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-4 ">
                        <div class="social_media_links">
                            <a rel="nofollow" target="_blank" href="<?= CONF_SOCIAL['FACEBOOK_AUTHOR']; ?>">
                                <i class="fa fa-facebook"></i>
                            </a>
                            <a rel="nofollow" target="_blank" href="<?= CONF_SOCIAL['INSTAGRAM_PAGE']; ?>">
                                <i class="fa fa-instagram"></i>
                            </a>
                            <a rel="nofollow" target="_blank" href="<?= CONF_SOCIAL['YOUTUBE_PAGE']; ?>">
                                <i class="fa fa-youtube"></i>
                            </a>
                            <a rel="nofollow" target="_blank" href="<?= CONF_SOCIAL['FACEBOOK_AUTHOR']; ?>">
                                <i class="fa fa-linkedin"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="sticky-header" class="main-header-area">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-3 col-lg-3">
                        <div class="logo">
                            <a href="<?= url(); ?>">
                                <img src="<?= asset('assets/img/logo.png'); ?>" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-9 col-lg-9">
                        <div class="main-menu  d-none d-lg-block">
                            <nav>
                                <ul id="navigation">
                                    <li><a  href="<?= url(); ?>">home</a></li>
                                    <li><a href="<?= $router->route("web.about"); ?>">Sobre</a></li>
                                    <li><a href="<?= $router->route("web.blog"); ?>">Blog</a></li>
                                    <li><a href="<?= $router->route("web.contact"); ?>#contact">Contato</a></li>
                                    <li><a href="<?= url('admin'); ?>">Login</a></li>
                                </ul>
                            </nav>
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

<?= $v->section("content"); ?>

<!-- footer_start  -->
<footer class="footer">
    <div class="footer_top">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-md-6 col-lg-3">
                    <div class="footer_widget">
                        <h3 class="footer_title">
                            Contact Us
                        </h3>
                        <ul class="address_line">
                            <li><?= CONF_MAIL['FROM_TELEPHONE']; ?></li>
                            <li><a href="#">Demomail@gmail.Com</a></li>
                            <li>700, Green Lane, New York, USA</li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3  col-md-6 col-lg-3">
                    <div class="footer_widget">
                        <h3 class="footer_title">
                            Our Servces
                        </h3>
                        <ul class="links">
                            <li><a  href="<?= url(); ?>">home</a></li>
                            <li><a href="<?= $router->route("web.about"); ?>">Sobre</a></li>
                            <li><a href="<?= $router->route("web.blog"); ?>">Blog</a></li>
                            <li><a href="<?= $router->route("web.contact"); ?>">Contato</a></li>
                            <li><a href="<?= url('admin'); ?>">Login</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3  col-md-6 col-lg-3">
                    <div class="footer_widget">
                        <h3 class="footer_title">
                            Quick Link
                        </h3>
                        <ul class="links">
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Terms of Service</a></li>
                            <li><a href="#">Login info</a></li>
                            <li><a href="#">Knowledge Base</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 col-lg-3 ">
                    <div class="footer_widget">
                        <div class="footer_logo">
                            <a href="#">
                                <img src="<?= asset('assets/img/logo.png'); ?>" alt="">
                            </a>
                        </div>
                        <p class="address_text">239 E 5th St, New York
                            NY 10003, USA
                        </p>
                        <div class="socail_links">
                            <ul>
                                <li>
                                    <a rel="nofollow" target="_blank" href="<?= CONF_SOCIAL['FACEBOOK_PAGE']; ?>">
                                        <i class="fa fa-facebook"></i>
                                    </a>
                                </li>
                                <li>
                                    <a rel="nofollow" target="_blank" href="<?= CONF_SOCIAL['INSTAGRAM_PAGE']; ?>">
                                        <i class="fa fa-instagram"></i>
                                    </a>
                                </li>
                                <li>
                                    <a rel="nofollow" target="_blank" href="<?= CONF_SOCIAL['YOUTUBE_PAGE']; ?>">
                                        <i class="fa fa-youtube"></i>
                                    </a>
                                </li>
                                <li>
                                    <a rel="nofollow" target="_blank" href="<?= CONF_SOCIAL['LINKDIN_PAGE']; ?>">
                                        <i class="fa fa-linkedin"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copy-right_text">
        <div class="container">
            <div class="bordered_1px"></div>
            <div class="row">
                <div class="col-xl-12">
                    <p class="copy_right text-center">
                    <p>
                        Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved |
                        This template is made with <i class="ti-heart" aria-hidden="true"></i>
                        by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                    </p>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- footer_end  -->

<?php if (!COOKIEPOLICY): ?>
    <!--GDPR-->
    <div id="cookiePolicy" class="al-center">
        <div class="container">
            <p>Este website utiliza cookies próprios e de terceiros a fim de personalizar o conteúdo, melhorar a experiência do usuário, fornecer funções de mídias sociais e analisar o tráfego. Para continuar navegando você deve concordar com nossa <a href="<?= url("/politica-de-privacidade"); ?>">Política de Privacidade</a>.</p>
            <a data-route="<?= $router->route("web.cookie.policy"); ?>" data-cookie="agree" href="#" class="btn btn_blue">
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

</html>