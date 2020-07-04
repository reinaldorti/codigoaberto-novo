<?php


namespace Source\Controllers\Admin;
use Source\Models\Post;
use Source\Models\User;

class Dash extends Admin
{

    /**
     * Dash constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

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
                "posts" => (new Post())->find("id > 1")->count(),
            ],
        ]);
    }

    /**
     * LOGOUT
     */
    public function logoff(): void
    {
        $user = (new User())->findById("{$_SESSION["user"]}");
        $user->user_login = null;
        $user->save();

        unset($_SESSION["user"]);

        flash("success", "
            <i class='icon fas fa-check'></i>
            Você saiu com sucesso, volte logo {$user->first_name}!
        ");
        redirect('admin');
    }
}