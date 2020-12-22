<?php

namespace Source\Controllers\Admin;

use Source\Support\Message;

/**
 * Class Backup
 * @package Source\Controllers\Admin
 */
class Backup extends Admin
{
    /**
     * @param array|null $data
     */
    public function home(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $head = $this->seo->render(
            CONF_SITE['NAME'] . " - " . CONF_SITE['TITLE'],
            CONF_SITE['DESC'],
            url('admin/about/home'),
            asset("/assets/images/logo/logo.png")
        );

        echo $this->view->render("widgets/config/home", [
            "app" => "config",
            "head" => $head,
        ]);
    }
}