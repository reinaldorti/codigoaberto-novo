<?php

namespace Source\Controllers\Admin;

use Source\Support\Message;

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

    public function delete(): void
    {
        unlink(__DIR__ . "/../../../" . DATA_LAYER_CONFIG['dbname'] . ".sql.gz");

        flash("success", "Backup <b>" . DATA_LAYER_CONFIG['dbname'] . ".sql.gz</b> foi deletado com sucesso da raiz do projeto");
        redirect("admin/database/home");

    }

    public function backup(): void
    {
        set_time_limit(0);

        $backup = new \Source\Support\BackupDatabase('./', 10);
        $backup->setDatabase(DATA_LAYER_CONFIG['host'], DATA_LAYER_CONFIG['dbname'], DATA_LAYER_CONFIG['username'], DATA_LAYER_CONFIG['passwd']);
        $backup->generate();

        flash("success", "Backup <b>" . DATA_LAYER_CONFIG['dbname'] . ".sql.gz</b> gerado com sucesso");
        redirect("admin/database/home");

    }
}