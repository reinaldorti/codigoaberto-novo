<?php

namespace Source\Controllers\Admin;

use Source\Controllers\Controller;
use Source\Models\User;

/**
 * Class Admin
 * @package Source\Controllers\Admin
 */
class Admin extends Controller
{
    /**
     * @var \Source\Models\User|null
     */
    protected $user;

    /**
     * Admin constructor.
     */
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../../../public/" . CONF_VIEW['ADMIN'] . "/");

        if (empty($_SESSION["user"])) {
            unset($_SESSION["user"]);
            flash("error", "
                <i class='icon fas fa-ban'></i> Oops! Acesso negado! Por favor, faça o login!
            ");
            redirect("/admin");
        }

        $user = (new User())->findById("{$_SESSION["user"]}");
        if ($user->level < 6) {
            unset($_SESSION["user"]);
            flash("alert", "
                <i class='icon fas fa-ban'></i>Oops! Esse nível de acesso não tem permissão para logar!
            ");
            redirect("/admin");
        }

        if ($user->status != 1) {
            unset($_SESSION["user"]);
            flash("info", "
                <i class='icon fas fa-ban'></i>
                 Oops, {$user->first_name}!<br>
                 Você não tem permissão para acessar!<br>
                 Por favor, entre em contato pelo e-mail: " . CONF_MAIL["FROM_EMAIL"] . "!
            ");
            redirect("/admin");
        }
    }
}