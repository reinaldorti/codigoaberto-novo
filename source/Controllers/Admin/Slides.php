<?php

namespace Source\Controllers\Admin;

use CoffeeCode\Uploader\Image;
use Source\Models\Slide;
use Source\Models\User;
use Source\Support\Message;
use Source\Support\Pager;

/**
 * Class Slides
 * @package Source\Controllers\Admin
 */
class Slides extends Admin
{

    /**
     * Dash constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * ADMIN SLIDE HOME
     * @param array|null $data
     */
    public function home(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        //search redirect
        if (!empty($data["s"])) {
            $s = str_search($data["s"]);

            echo Message::ajaxResponse("redirect", [
                "url" => url("/admin/slides/home/{$s}/1")
            ]);
            return;
        }

        $search = null;
        $slide = (new Slide())->find()->order("id DESC");

        if (!empty($data["search"]) && str_search($data["search"]) != "all") {
            $search = str_search($data["search"]);
            $slide = (new Slide())->find("MATCH(title) AGAINST(:s)", "s={$search}");
            if (!$slide->count()) {
                flash("info", "<i class='icon fas fa-info'></i> Oops! Sua pesquisa não retornou resultados!");
                redirect("/admin/slides/home");
            }
        }

        $all = ($search ?? "all");
        $pager = new Pager(url("/admin/slides/home/{$all}/"));
        $pager->pager($slide->count(), 15, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE['NAME'] . " - " . CONF_SITE['TITLE'],
            CONF_SITE['DESC'],
            url('admin/slides/home'),
            asset("/assets/images/logo/logo.png")
        );

        echo $this->view->render("widgets/slides/home", [
            "app" => "slides",
            "head" => $head,
            "search" => $search,
            "slides" => $slide->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render()
        ]);
    }

    /**
     * ADMIN SLIDE
     * @param array $data
     */
    public function slide(?array $data): void
    {
        //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $cover = (!empty($_FILES["cover"]) ? $_FILES["cover"] : null);

            $form = [$data["title"], $data["subtitle"], $data["status"]];
            if (in_array("", $form)) {
                echo Message::ajaxResponse("message", [
                    "type" => "error",
                    "message" => "<i class='icon fas fa-ban'></i> Oops! Por favor, preencha os campos com (*) para continuar!"
                ]);
                return;
            }

            if ($cover == null) {
                echo Message::ajaxResponse("message", [
                    "type" => "error",
                    "message" => "<i class='icon fas fa-ban'></i> Oops! Por favor, informe de destaque!"
                ]);
                return;
            }

            if (!csrf_verify($data['csrf_token'])) {
                echo Message::ajaxResponse("message", [
                    "type" => "alert",
                    "message" => "  
                    <i class='icon fas fa-exclamation-triangle'></i>                
                    Oops! Erro ao enviar o formulário!<br>
                    Por favor, atualize a página e tente novamente!
                "
                ]);
                return;
            }

            $slide = new Slide();
            $slide->title = $data["title"];
            $slide->subtitle = $data["subtitle"];
            $slide->url = (!empty($data["url"]) ? slug($data["url"]) : slug($slide->title));
            $slide->status = $data["status"];
            $slide->slide_at = (empty($data["slide_at"]) ? date("Y-m-d") : date_fmt($data["slide_at"]));
            $slide->created_at = date("Y-m-d H:i:s");
            $slide->save();

            if (!empty($_FILES["cover"])) {
                $upload = new Image("storage", "slides");
                $file = $_FILES["cover"];

                if (empty($file["type"]) || !in_array($file["type"], $upload::isAllowed())) {
                    echo Message::ajaxResponse("message", [
                        "type" => "error",
                        "message" => "<i class='icon fas fa-ban'></i> Oops! Selecione uma imagem válida!"
                    ]);
                    return;
                }

                if (file_exists(CONF_UPLOAD["STORAGE"] . "/{$slide->cover}") && !is_dir(CONF_UPLOAD["STORAGE"] . "/{$slide->cover}")) {
                    unlink(CONF_UPLOAD["STORAGE"] . "/{$slide->cover}");
                }

                $uploaded = $upload->upload($file, $slide->id . "-" . slug($slide->title), 730);
                $cover = substr($uploaded, strrpos($uploaded, 'storage/') + 8);
                $slide->cover = $cover;
                $slide->save();
            }


            flash("success", "
                <i class='icon fas fa-check'></i> Slide cadastrado com sucesso!
            ");
            echo Message::ajaxResponse("redirect", [
                "url" => url("admin/slides/slide/{$slide->id}")
            ]);
            return;
        }

        //update
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $form = [$data["title"], $data["subtitle"], $data["status"]];
            if (in_array("", $form)) {
                echo Message::ajaxResponse("message", [
                    "type" => "error",
                    "message" => "<i class='icon fas fa-ban'></i> Oops! Por favor, preencha os campos com (*) para continuar!"
                ]);
                return;
            }

            if (!csrf_verify($data['csrf_token'])) {
                echo Message::ajaxResponse("message", [
                    "type" => "alert",
                    "message" => "  
                    <i class='icon fas fa-exclamation-triangle'></i>                
                    Oops! Erro ao enviar o formulário!<br>
                    Por favor, atualize a página e tente novamente!
                "
                ]);
                return;
            }

            $slide = (new Slide())->findById("{$data["id"]}");
            $slide->title = $data["title"];
            $slide->subtitle = $data["subtitle"];
            $slide->url = (!empty($data["url"]) ? slug($data["url"]) : slug($slide->title));
            $slide->status = $data["status"];
            $slide->slide_at = date_fmt($data["slide_at"]);
            $slide->updated_at = date("Y-m-d H:i:s");
            $slide->save();

            if (!empty($_FILES["cover"])) {
                $upload = new \CoffeeCode\Uploader\Image("storage", "slides");
                $file = $_FILES["cover"];

                if (empty($file["type"]) || !in_array($file["type"], $upload::isAllowed())) {
                    echo Message::ajaxResponse("message", [
                        "type" => "error",
                        "message" => "<i class='icon fas fa-ban'></i> Oops! Selecione uma imagem válida!"
                    ]);
                    return;
                }

                if (file_exists(CONF_UPLOAD["STORAGE"] . "/{$slide->cover}") && !is_dir(CONF_UPLOAD["STORAGE"] . "/{$slide->cover}")) {
                    unlink(CONF_UPLOAD["STORAGE"] . "/{$slide->cover}");
                }

                $uploaded = $upload->upload($file, $slide->id . "-" . slug($slide->title), 730);
                $cover = substr($uploaded, strrpos($uploaded, 'storage/') + 8);
                $slide->cover = $cover;
                $slide->save();
            }

            flash("success", "
                <i class='icon fas fa-check'></i> Post atualizado com sucesso!
            ");
            echo Message::ajaxResponse("redirect", [
                "url" => url("admin/slides/slide/{$slide->id}")
            ]);
            return;
        }

        $head = $this->seo->render(
            CONF_SITE['NAME'] . " - " . CONF_SITE['TITLE'],
            CONF_SITE['DESC'],
            url('admin/slides/slide'),
            asset("/assets/images/logo/logo.png")
        );

        $slide = null;
        if (!empty($data["id"])) {
            $slideId = filter_var($data["id"], FILTER_VALIDATE_INT);
            $slide = (new Slide())->findById("{$slideId}");
        }

        echo $this->view->render("widgets/slides/slide", [
            "app" => "slides/slide",
            "head" => $head,
            "csrf" => csrf_input(),
            "slide" => $slide
        ]);
    }

    /**
     * ADMIN SLIDE DELETE
     * @param int $data
     */
    public function delete($data): void
    {
        $data = filter_var_array($data, FILTER_VALIDATE_INT);
        $slide = (new Slide())->findById("{$data["id"]}");

        if (!$slide) {
            flash("error", "<i class='icon fas fa-ban'></i> Oops! Você tentou gerenciar um slide que não existe!");
            redirect("admin/slides/home");
        }

        if (file_exists(CONF_UPLOAD["STORAGE"] . "/{$slide->cover}") && !is_dir(CONF_UPLOAD["STORAGE"] . "/{$slide->cover}")) {
            unlink(CONF_UPLOAD["STORAGE"] . "/{$slide->cover}");
        }

        $slide->destroy();

        flash("success", "<i class='icon fas fa-check'></i> Slide foi removido com sucesso!");
        redirect("admin/slides/home");
    }
}