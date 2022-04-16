<?php

namespace Source\Controllers\Admin;
use Source\Models\Blog;
use Source\Models\Slide;
use Source\Models\User;
use Source\Support\Message;
use Source\Models\Testimony;

/**
 * Class Dash
 * @package Source\Controllers\Admin
 */
class Dash extends Admin
{
    /**
     * ADMIN TELA HOME
     */
    public function home(): void
    {
        $head = $this->seo->render(
            CONF_SITE['NAME'] . " - " . CONF_SITE['TITLE'],
            CONF_SITE['DESC'],
            url('admin/dash'),
            asset("/assets/images/logo/logo.png")
        );

        echo $this->view->render("widgets/dash/home", [
            "app" => "dash",
            "head" => $head,
            "users" => (object)[
                "users" => (new User())->find()->count(),
            ],
            "blog" => (object)[
                "posts" => (new Blog())->find()->count(),
            ],
            "slides" => (object)[
                "slides" => (new Slide())->find()->count(),
            ],
            "testimony" => (object)[
                "testimony" => (new Testimony())->find()->count(),
            ]
        ]);
    }

    /**
     * LOGOUT
     */
    public function logoff(): void
    {
        $user = (new User())->find("id=:id", "id={$_SESSION["user"]}")->fetch();
        $user->user_login = null;
        $user->save();

        flash("success", "<i class='icon fas fa-check'></i> Você saiu com sucesso, volte logo {$user->first_name}!");

        unset($_SESSION["user"], $_SESSION['start_login'], $_SESSION['logout_time']);
        redirect('admin');
    }
}