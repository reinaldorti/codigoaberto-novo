<?php


namespace Source\Controllers\Admin;

use Source\Support\Message;
use Source\Support\Pager;

/**
 * Class About
 * @package Source\Controllers\Admin
 */
class About extends Admin
{
    /**
     * HOME ABOUT
     * @param array|null $data
     */
    public function home(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        //search redirect
        if (!empty($data["s"])) {
            $s = str_search($data["s"]);

            echo Message::ajaxResponse("redirect", [
                "url" => url("/admin/about/home/{$s}/1")
            ]);
            return;
        }

        $search = null;
        $about = (new \Source\Models\About())->find()->order("id DESC");
        if (!empty($data["search"]) && str_search($data["search"]) != "all") {
            $search = str_search($data["search"]);
            $about = (new \Source\Models\About())->find("MATCH(title) AGAINST(:s)", "s={$search}");
            if (!$about->count()) {
                flash("info", "<i class='icon fas fa-info'></i> Oops! Sua pesquisa não retornou resultados!");
                redirect("/admin/about/home");
            }
        }

        $all = ($search ?? "all");
        $pager = new Pager(url("/admin/about/home/{$all}/"));
        $pager->pager($about->count(), 15, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE['NAME'] . " - " . CONF_SITE['TITLE'],
            CONF_SITE['DESC'],
            url('admin/about/home'),
            asset("/assets/images/logo/logo.png")
        );

        echo $this->view->render("widgets/about/home", [
            "app" => "about",
            "head" => $head,
            "search" => $search,
            "about" => $about->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render()
        ]);
    }

    /**
     * MANAGER ABOUT
     * @param array $data
     */
    public function about(?array $data): void
    {
        if (!empty($data["content"])) {
            $content = $data["content"];
        }

        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        //create
        if (!empty($data["action"]) && $data["action"] == "create") {

            if (in_array("", $data)) {
                echo Message::ajaxResponse("message", [
                    "type" => "error",
                    "message" => "<i class='icon fas fa-ban'></i> Oops! Por favor, preencha os campos com (*) para continuar!"
                ]);
                return;
            }

            $about = new \Source\Models\About();
            $about->title = $data["title"];
            $about->status = 1;
            $about->content = str_replace(["{title}"], [$about->title], $content);
            $about->save();

            flash("success", "<i class='icon fas fa-check'></i> Texto cadastrado com sucesso!");
            echo Message::ajaxResponse("redirect", [
                "url" => url("admin/about/about/{$about->id}")
            ]);
            return;
        }

        //update
        if (!empty($data["action"]) && $data["action"] == "update") {

            $form = [$data["title"], $data["status"]];
            if (in_array("", $form)) {
                echo Message::ajaxResponse("message", [
                    "type" => "error",
                    "message" => "<i class='icon fas fa-ban'></i> Oops! Por favor, preencha os campos com (*) para continuar!"
                ]);
                return;
            }

            $about = (new \Source\Models\About())->findById("{$data["about_id"]}");
            $about->title = $data["title"];
            $about->status = $data["status"];
            $about->content = $content;
            $about->save();

            echo Message::ajaxResponse("message", [
                "type" => "success",
                "message" => "<i class='icon fas fa-check'></i> Texto foi atualizado com sucesso!"
            ]);
            return;
        }

        $head = $this->seo->render(
            CONF_SITE['NAME'] . " - " . CONF_SITE['TITLE'],
            CONF_SITE['DESC'],
            url('admin/about/about'),
            asset("/assets/images/logo/logo.png")
        );

        $about = null;
        if (!empty($data["about_id"])) {
            $aboutId = filter_var($data["about_id"], FILTER_VALIDATE_INT);
            $about = (new \Source\Models\About())->findById("{$aboutId}");
        }
        
        echo $this->view->render("widgets/about/about", [
            "app" => "about/about",
            "head" => $head,
            "about" => $about
        ]);
    }

    /**
     * DELETE ABOUT
     * @param array $data
     */
    public function delete(?array $data): void
    {
        $data = filter_var_array($data, FILTER_VALIDATE_INT);

        $about = (new \Source\Models\About())->findById("{$data["about_id"]}");
        if (!$about) {
            flash("error", "<i class='icon fas fa-ban'></i> Oops! Você tentou gerenciar um sobre que não existe!");
            redirect("admin/about/home");
        }

        if (file_exists(CONF_UPLOAD["STORAGE"] . "/{$about->cover}") && !is_dir(CONF_UPLOAD["STORAGE"] . "/{$about->cover}")) {
            unlink(CONF_UPLOAD["STORAGE"] . "/{$about->cover}");
        }

        $about->destroy();

        flash("success", "<i class='icon fas fa-check'></i> Sobre foi removido com sucesso!");
        redirect("admin/about/home");
    }
}