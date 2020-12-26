
<?php $v->layout("_theme"); ?>

<div class="bradcam_area breadcam_bg_2">
    <h3>Fale conosco</h3>
</div>

<section class="contact-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="contact-title">Para entrar em contato preencha o formulario abaixo</h2>
            </div>
            <div class="col-lg-8">
                <form class="form-contact form" action="<?= $router->route("web.contact"); ?>" method="post">
                    <input type="hidden" name="action" value="contact"/>
                    <?= $csrf; ?>

                    <div class="login_form_callback">
                        <?= flash(); ?>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input class="form-control" name="name" type="text" placeholder="Nome">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <input class="form-control" name="email" type="email" placeholder="E-mail">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <input class="form-control" name="subject" type="text" placeholder="assunto">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <textarea class="form-control w-100" name="message" cols="30" rows="9" placeholder="Mensagem"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <button type="submit" class="button button-contactForm boxed-btn">Enviar</button>
                    </div>
                </form>
            </div>

            <div class="col-lg-3 offset-lg-1">
                <div class="media contact-info">
                    <span class="contact-info__icon"><i class="ti-home"></i></span>
                    <div class="media-body">
                        <h3>Buttonwood, California.</h3>
                        <p>Rosemead, CA 91770</p>
                    </div>
                </div>
                <div class="media contact-info">
                    <span class="contact-info__icon"><i class="ti-tablet"></i></span>
                    <div class="media-body">
                        <h3>+1 253 565 2365</h3>
                        <p>Mon to Fri 9am to 6pm</p>
                    </div>
                </div>
                <div class="media contact-info">
                    <span class="contact-info__icon"><i class="ti-email"></i></span>
                    <div class="media-body">
                        <h3>support@colorlib.com</h3>
                        <p>Send us your query anytime!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ================ contact section end ================= -->



