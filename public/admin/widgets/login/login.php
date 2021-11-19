<?php $v->layout("login"); ?>

<div class="login-box">
    <div class="login-logo">
        <a href="<?= url('admin'); ?>"><b>Admin</b>LTE</a>
    </div>

    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Informe seu e-mail e senha para logar.</p>

            <form action="<?= url("/admin/login"); ?>" method="post">
                <input type="hidden" name="action" value="login"/>

                <div class="login_form_callback">
                    <?= flash(); ?>
                </div>

                <div class="input-group mb-3">
                    <input type="text" name="email" class="form-control" placeholder="E-mail" value="<?= $email ? $email : 'reinaldorti@gmail.com'; ?>">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" value="12345678">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" name="remember" id="remember" value="1" <?= $email ? 'checked' : '' ?>>
                            <label for="remember">
                                Lembrar dados?
                            </label>
                        </div>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block" title="Entrar">Entrar</button>
                    </div>
                </div>
            </form>
            <p class="mt-3">
                <a href="<?= url('admin/recuperar'); ?>">Recuperar Senha?</a><br>
            </p>
            <p class="mt-3">
                <a href="<?= url(); ?>">Voltar ao site!</a>
            </p>
        </div>
    </div>
</div>

