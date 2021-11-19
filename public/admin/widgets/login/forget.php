<?php $v->layout("login"); ?>

<div class="login-box">
    <div class="login-logo">
        <a href="<?= url('admin'); ?>"><b>Admin</b>LTE</a>
    </div>

    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Informe seu e-mail e senha para logar.</p>

            <form action="<?= url("/admin/forget"); ?>" method="post">
                <input type="hidden" name="action" value="forget"/>

                <div class="login_form_callback">
                    <?= flash(); ?>
                </div>

                <div class="input-group mb-3">
                    <input type="text" name="email" class="form-control clear_value" placeholder="E-mail">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block" title="Recuperar">Recuperar</button>
                    </div>
                </div>
            </form>
            <p class="mt-3">
                <a href="<?= url('admin'); ?>" title="Recuperar Senha?">Lembrei quero logar?</a>
            </p>
        </div>
    </div>
</div>
