
<?php $v->layout("_theme"); ?>

<div class="bradcam_area breadcam_bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="bradcam_text text-center">
                    <h3>Contato</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="contact-section" id="contact">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="contact-title">Fale Conosco</h2>
            </div>
            <div class="col-lg-8" >
                <form class="form-contact contact_form" action="<?= $router->route("web.contact"); ?>" method="post">
                    <input type="hidden" name="action" value="contact"/>
                    <?= $csrf; ?>
                    <div class="login_form_callback">
                        <?= flash(); ?>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input class="form-control valid" name="name" type="text" placeholder="Nome" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input class="form-control valid" name="email" type="text" placeholder="E-mail" />
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <input class="form-control" name="subject" type="text" placeholder="Assunto" />
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <textarea class="form-control w-100" name="message" cols="30" rows="9" placeholder="Mensagem" ></textarea>
                            </div>
                        </div>

                        <!-- <div class="col-12">
                            <div class="form-group">
                                <div class="g-recaptcha" data-sitekey="<?//= $siteKey; ?>"></div>
                            </div>
                        </div> -->
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
                        <h3><?= CONF_MAIL['FROM_TELEPHONE']; ?></h3>
                        <p>Mon to Fri 9am to 6pm</p>
                    </div>
                </div>
                <div class="media contact-info">
                    <span class="contact-info__icon"><i class="ti-email"></i></span>
                    <div class="media-body">
                        <h3><?= CONF_MAIL['FROM_EMAIL']; ?>></h3>
                        <p>Send us your query anytime!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php $v->start("recaptcha"); ?>
    <scripts src="https://www.google.com/recaptcha/api.js" async defer></scripts>
<?php $v->end(); ?>