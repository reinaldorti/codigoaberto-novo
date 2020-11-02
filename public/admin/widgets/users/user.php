<?php
$v->layout("dash"); ?>
<div class="content-wrapper" style="min-height: 1416.81px;">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <?php if (!$user): ?>
                    <div class="col-sm-6">
                        <h4>Novo Usuários</h4>
                    </div>
                <?php else: ?>
                    <div class="col-sm-6">
                        <h4>Perfil: <?= $user->fullName(); ?></h4>
                    </div>
                <?php endif; ?>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= url('admin/dash'); ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= url('admin/users/home'); ?>">Usuários</a></li>
                        <li class="breadcrumb-item active"><a href="<?= url('admin/users/user'); ?>">Perfil</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <?php if (!$user): ?>
                    <div class="col-md-12">
                <?php else: ?>
                    <div class="col-md-9">
                <?php endif; ?>
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#activity" data-toggle="tab">Perfil</a>
                                </li>
                                <?php if ($user): ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#password" data-toggle="tab">Senha</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" href="#timeline" data-toggle="tab">Endereço</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="activity">
                                    <div class="post">
                                        <?php if (!$user): ?>
                                            <form action="<?= url('admin/users/user'); ?>" method="post">
                                                <input type="hidden" name="action" value="create"/>
                                                <?= $csrf; ?>

                                                <div class="card-body">
                                                    <div class="login_form_callback">
                                                        <?= flash(); ?>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Foto (Opcional)</label>
                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                                <input type="file" name="photo" class="custom-file-input" accept="image/png, image/jpeg">
                                                                <label class="custom-file-label">Foto</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Nome (*)</label>
                                                                <input type="text" name="first_name" class="form-control" placeholder="Nome">
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Sobrenome (*)</label>
                                                                <input type="text" name="last_name" class="form-control" placeholder="Sobrenome">
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Documento (*)</label>
                                                                <input type="text" name="document" class="form-control formCpf" placeholder="CPF">
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>E-mail (*)</label>
                                                                <input type="text" name="email" class="form-control" placeholder="E-mail">
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Telefone (*)</label>
                                                                <input type="text" name="telephone" class="form-control formPhone" placeholder="Telefone">
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Genero (*)</label>
                                                                <select class="form-control js-example-basic-single" name="genre">
                                                                    <option value="" selected="selected" disabled>Selecione...</option>
                                                                    <?php
                                                                    $genre = genre();
                                                                    foreach ($genre as $id => $desc):
                                                                        echo "<option value='{$id}'>{$desc}</option>";
                                                                    endforeach;
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Level (*)</label>
                                                                <select class="form-control js-example-basic-single" name="level">
                                                                    <option value="" selected="selected" disabled>Selecione...</option>
                                                                    <?php
                                                                    $level = level();
                                                                    foreach ($level as $id => $desc):
                                                                        echo "<option value='{$id}'>{$desc}</option>";
                                                                    endforeach;
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Status (*)</label>
                                                                <select class="form-control js-example-basic-single" name="status">
                                                                    <option value="" selected="selected" disabled>Selecione...</option>
                                                                    <?php
                                                                    $status = status();
                                                                    foreach ($status as $id => $desc):
                                                                        echo "<option value='{$id}'>{$desc}</option>";
                                                                    endforeach;
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Notificar usuário</label>
                                                                <select class="form-control js-example-basic-single" name="send_email">
                                                                    <option value="1">Sim</option>
                                                                    <option value="2" selected="selected">Não</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Senha (*)</label>
                                                                <input type="password" name="password" class="form-control" placeholder="Senha">
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12">
                                                            <button type="submit" class="btn btn-primary">Criar Usuário</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        <?php else: ?>
                                            <form action="<?= url("admin/users/user/{$user->id}"); ?>" method="post">
                                                <input type="hidden" name="action" value="update"/>
                                                <?= $csrf; ?>

                                                <div class="login_form_callback">
                                                    <?= flash(); ?>
                                                </div>

                                                <div class="form-group">
                                                    <label>Foto (Opcional)</label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" name="photo" class="custom-file-input" accept="image/png, image/jpeg">
                                                            <label class="custom-file-label">Foto</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>Nome (*)</label>
                                                            <input type="text" name="first_name" class="form-control" placeholder="Nome" value="<?= $user->first_name; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>Sobrenome (*)</label>
                                                            <input type="text" name="last_name" class="form-control" placeholder="Sobrenome" value="<?= $user->last_name; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>E-mail (*)</label>
                                                            <input type="text" name="email" class="form-control" placeholder="E-mail" value="<?= $user->email; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>Documento (*)</label>
                                                            <input type="text" name="document" class="form-control formCpf" placeholder="CPF" value="<?= $user->document; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>Telefone (*)</label>
                                                            <input type="text" name="telephone" class="form-control formPhone" placeholder="Telefone" value="<?= $user->telephone; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>Genero (*)</label>
                                                            <select class="form-control js-example-basic-single" name="genre">
                                                                <option value="" selected="selected" disabled>Selecione...</option>
                                                                <?php
                                                                $genre = genre();
                                                                foreach ($genre as $id => $desc):
                                                                    echo "<option value='{$id}'";
                                                                    if (isset($user->genre) && $user->genre == $id):
                                                                        echo 'selected';
                                                                    endif;
                                                                    echo "> {$desc}</option>";
                                                                endforeach;
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>Level (*)</label>
                                                            <select class="form-control js-example-basic-single" name="level">
                                                                <option value="" selected="selected" disabled>Selecione...</option>
                                                                <?php
                                                                $level = level();
                                                                foreach ($level as $id => $desc):
                                                                    echo "<option value='{$id}'";
                                                                    if (isset($user->level) && $user->level == $id):
                                                                        echo 'selected';
                                                                    endif;
                                                                    echo "> {$desc}</option>";
                                                                endforeach;
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>Status (*)</label>
                                                            <select class="form-control js-example-basic-single" name="status">
                                                                <option value="" selected="selected" disabled>Selecione...</option>
                                                                <?php
                                                                $status = status();
                                                                foreach ($status as $id => $desc):
                                                                   echo "<option value='{$id}'";
                                                                        if (isset($user->status) && $user->status == $id):
                                                                            echo 'selected';
                                                                        endif;
                                                                    echo "> {$desc}</option>";
                                                                endforeach;
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-12">
                                                        <button type="submit" class="btn btn-primary">
                                                            Atualizar
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <?php if ($user): ?>
                                    <div class="tab-pane" id="password">
                                        <div class=" timeline-inverse">
                                            <form action="<?= url('admin/users/user'); ?>" method="post">
                                                <input type="hidden" name="action" value="password"/>
                                                <input type="hidden" name="user_id" value="<?= $user->id; ?>"/>
                                                <?= $csrf; ?>

                                                <div class="login_form_callback">
                                                    <?= flash(); ?>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>Senha atual</label>
                                                            <input type="password" name="password_at" class="form-control" placeholder="Senha">
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>Nova senha</label>
                                                            <input type="password" name="password" class="form-control" placeholder="Senha">
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>Confirmar senha</label>
                                                            <input type="password" name="password_re" class="form-control" placeholder="Senha">
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-12">
                                                        <button type="submit" class="btn btn-primary">Atualizar</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="timeline">
                                        <div class=" timeline-inverse">
                                            <form action="<?= url("admin/users/address/{$user->id}"); ?>" method="post">
                                                <input type="hidden" name="id" value="<?php if (isset($user->addr()->id)) echo $user->addr()->id; ?>"/>
                                                <input type="hidden" name="user_id" value="<?= $user->id; ?>"/>
                                                <?= $csrf; ?>

                                                <div class="login_form_callback">
                                                    <?= flash(); ?>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>Cep (*)</label>
                                                            <input type="text" class="form-control formCep js_getCep" name="zipcode" placeholder="Cep" value="<?php if (isset($user->addr()->zipcode)) echo $user->addr()->zipcode; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>Rua (*)</label>
                                                            <input type="text" class="form-control js_logradouro" name="street" placeholder="Rua" value="<?php if (isset($user->addr()->street)) echo $user->addr()->street; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>Número (*)</label>
                                                            <input type="text" class="form-control" name="number" placeholder="Número" value="<?php if (isset($user->addr()->number)) echo $user->addr()->number; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>Complemento</label>
                                                            <input type="text" class="form-control js_complemento" name="complement" placeholder="Ex: Casa, Apto, Etc:" value="<?php if (isset($user->addr()->complement)) echo $user->addr()->complement; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>Bairro (*)</label>
                                                            <input type="text" class="form-control js_bairro" name="district" placeholder="Bairro:" value="<?php if (isset($user->addr()->district)) echo $user->addr()->district; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>Cidade (*)</label>
                                                            <input type="text" class="form-control js_localidade" name="city" placeholder="Cidade" value="<?php if (isset($user->addr()->city)) echo $user->addr()->city; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>Estado (*)</label>
                                                            <input type="text" class="form-control js_uf" maxlength="2" name="state" placeholder="Estado" value="<?php if (isset($user->addr()->state)) echo $user->addr()->state; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>Pais</label>
                                                            <input type="text" class="form-control" name="country" placeholder="Pais" value="<?php if (isset($user->addr()->country)) echo $user->addr()->country; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-12">
                                                        <button type="submit" class="btn btn-primary">Atualizar</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if ($user): ?>
                    <div class="col-md-3">
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <?php
                                    $photo = (!empty($user->photo) ? image($user->photo) : asset("assets/images/no_avatar.jpg", CONF_VIEW['ADMIN']));
                                    ?>
                                    <img class="profile-user-img img-fluid img-circle" accept="image/jpeg, image/jpg, image/png" src="<?= $photo; ?>" style="width: 100px; height: 100px;">
                                </div>

                                <h3 class="profile-username text-center"><?= $user->first_name; ?></h3>

                                <p class="text-muted text-center"><?= $user->last_name; ?></p>

                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b>Cadastro</b> <a class="float-right"><?= date("d/m/Y", strtotime($user->created_at)); ?></a>
                                    </li>

                                    <li class="list-group-item">
                                        <b>Posts</b> <a class="float-right"><?= $blog->posts; ?></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>

<?php $v->start("scripts"); ?>
    <script>
        $(function () {
            //SELECT 2
            $('.js-example-basic-single').select2();
        });
    </script>
<?php $v->end(); ?>