

<?php if (APP_COOKIE && !COOKIE_CONSENT): ?>
    <div class="cookie_modal">
        <div class="cookie_modal_content">
            <p>Utilizamos cookies essenciais e tecnologias semelhantes de acordo com a nossa
                <a href="<?= $router->route("web.privacy.policy"); ?>" title="Política de Privacidade" style="color: #000; text-decoration: none;">
                    <b>Política de Privacidade</b>
                </a>
                e, ao continuar navegando, você concorda com estas condições.
            </p>
            <a class="btn btn-primary text-white icon-thumbs-up icon icon-check" data-action="<?= $router->route("web.cookie.consent"); ?>" data-cookie="accept">Fechar</a>
        </div>
    </div>

    <link rel="stylesheet" href="<?= url("/shared/views/widgets/lgpd/lgpd.css"); ?>"/>
    <script src="<?= url("/shared/views/widgets/lgpd/lgpd.js"); ?>"></script>
<?php endif; ?>

