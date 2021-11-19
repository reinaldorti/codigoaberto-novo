<?php

namespace Source\Controllers\Admin;

use CoffeeCode\Router\Router;
use Source\Controllers\Controller;
use Source\Models\User;
use Source\Support\Message;

/**
 * Class Admin
 * @package Source\Controllers\Admin
 */
class Admin extends Controller
{
    /*** @var User */
    protected $user;

    /*** @var Router */
    protected $router;

    /**
     * Admin constructor.
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        parent::__construct(__DIR__ . "/../../../public/" . CONF_VIEW["ADMIN"] . "/");

        $this->router = $router;

        $this->view->data([
            "router" => $this->router,
            "csrf" => csrf_input()
        ]);

        if (empty($_SESSION["user"])) {
            unset(
                $_SESSION["user"],
                $_SESSION["start_login"],
                $_SESSION["logout_time"]
            );

            flash("error", "<i class='icon fas fa-ban'></i> Oops! Acesso negado! Por favor, faça o login!");
            redirect("/admin");
        }

        //GERA O TEMPO PARA NAO DESLOGAR O USUARIO
        $_SESSION["start_login"] = time();
        $_SESSION["logout_time"] = $_SESSION["start_login"] + 30 * 60;

        $user = (new User())->find("id=:id", "id={$_SESSION["user"]}")->fetch();
        if ($user->level < 6) {
            unset($_SESSION["user"]);
            flash("error", "<i class='icon fas fa-ban'></i>Oops! Esse nível de acesso não tem permissão para logar!");
            redirect("/admin");
        }

        if ($user->status != 1) {
            unset($_SESSION["user"]);
            flash("info", "<i class='icon fas fa-ban'></i> Oops, {$user->first_name}! Você não tem permissão para acessar! Por favor, entre em contato pelo e-mail: " . CONF_MAIL["FROM_EMAIL"] . "!");
            redirect("/admin");
        }

        $user->user_login = time();
        $user->lastaccess = date("Y-m-d H:i:s");
        $user->save();
    }


    /**
     * Redireciona o usuario depois de ficar 30 sem mexer no admin
     */
    public function dashboard(): void
    {
        $user = (new User())->find("id=:id", "id={$_SESSION["user"]}")->fetch();

        if (time() >= $_SESSION["logout_time"]) {
            unset(
                $_SESSION["user"],
                $_SESSION["start_login"],
                $_SESSION["logout_time"]
            );

            flash("success", "<i class='fa fa-info-circle'></i> Oops, {$user->first_name}! Sua sessão expirou!");

            echo Message::ajaxResponse("redirect", [
                "url" => url("/admin")
            ]);
            return;
        }

        echo Message::ajaxResponse("message", [
            "type" => "info",
            "message" => "Que a força esteja com você {$user->first_name}!"
        ]);
        return;
    }
}