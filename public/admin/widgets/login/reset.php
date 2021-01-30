<?php $v->layout("login"); ?>

<div class="login-box">
    <div class="login-logo">
        <a href="<?= url('admin'); ?>"><b>Admin</b>LTE</a>
    </div>

    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Informe seu e-mail e senha para logar.</p>

            <form action="<?= url("/admin/reset"); ?>" method="post">
                <input type="hidden" name="action" value="reset"/>
                <?= $csrf; ?>
                <div class="login_form_callback">
                    <?= flash(); ?>
                </div>

                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control clear_value" placeholder="Nova senha">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password_re" class="form-control clear_value" placeholder="Confirmar nova senha">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block" title="Atualizar">Atualizar</button>
                    </div>
                </div>
            </form>
            <p class="mt-3">
                <a href="<?= url('admin'); ?>" title="Recuperar Senha?">Lembrei quero logar?</a>
            </p>
        </div>
    </div>
</div>