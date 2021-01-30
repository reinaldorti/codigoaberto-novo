<?php

namespace Source\Controllers\Admin;

/**
 * Class Database
 * @package Source\Controllers\Admin
 */
class Database extends Admin
{


    /**
     * VIEW HOME DATABASE
     */
    public function home(): void
    {
        $head = $this->seo->render(
            CONF_SITE['NAME'] . " - " . CONF_SITE['TITLE'],
            CONF_SITE['DESC'],
            url('admin/database/home'),
            asset("/assets/images/logo/logo.png")
        );

        echo $this->view->render("widgets/database/home", [
            "app" => "database",
            "head" => $head,
        ]);
    }
}