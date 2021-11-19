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
     * HOME SLIDE
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
        $slide = (new Slide())->find()->order("slide_order ASC");

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
     * MANAGER SLIDE
     * @param array|null $data
     * @throws \Exception
     */
    public function slide(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        //create
        if (!empty($data["action"]) && $data["action"] == "create") {
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

            $slide = new Slide();
            $slide->title = $data["title"];
            $slide->subtitle = $data["subtitle"];
            $slide->uri = (!empty($data["uri"]) ? str_slug($data["uri"]) : str_slug($slide->title));
            $slide->status = $data["status"];
            $slide->slide_at = (empty($data["slide_at"]) ? date("Y-m-d") : date_fmt($data["slide_at"]));
            $slide->save();

            if (!empty($_FILES["cover"])) {
                $upload = new Image("storage", "slides");
                $file = $_FILES["cover"];

                $size = 2048 * 2048 * 2;
                if ($file['size'] > $size) {
                    echo Message::ajaxResponse("message", [
                        "type" => "error",
                        "message" => "<i class='icon fas fa-ban'></i> Oops! A imagem enviada excede o limite permitido. Por favor, informe uma imagem menor!"
                    ]);
                    return;
                }

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

                $uploaded = $upload->upload($file, $slide->id . "-" . str_slug($slide->title), 730);
                $cover = substr($uploaded, strrpos($uploaded, 'storage/') + 8);
                $slide->cover = $cover;
                $slide->save();
            }


            flash("success", "<i class='icon fas fa-check'></i> Slide cadastrado com sucesso!");
            echo Message::ajaxResponse("redirect", [
                "url" => url("admin/slides/slide/{$slide->id}")
            ]);
            return;
        }

        //update
        if (!empty($data["action"]) && $data["action"] == "update") {
            $form = [$data["title"], $data["subtitle"], $data["status"]];
            if (in_array("", $form)) {
                echo Message::ajaxResponse("message", [
                    "type" => "error",
                    "message" => "<i class='icon fas fa-ban'></i> Oops! Por favor, preencha os campos com (*) para continuar!"
                ]);
                return;
            }

            $slide = (new Slide())->findById("{$data["slide_id"]}");
            $slide->title = $data["title"];
            $slide->subtitle = $data["subtitle"];
            $slide->url = (!empty($data["url"]) ? str_slug($data["url"]) : str_slug($slide->title));
            $slide->status = $data["status"];
            $slide->slide_at = date_fmt($data["slide_at"]);
            $slide->save();

            if (!empty($_FILES["cover"])) {
                $upload = new Image("storage", "slides");
                $file = $_FILES["cover"];

                $size = 2048 * 2048 * 2;
                if ($file['size'] > $size) {
                    echo Message::ajaxResponse("message", [
                        "type" => "error",
                        "message" => "<i class='icon fas fa-ban'></i> Oops! A imagem enviada excede o limite permitido. Por favor, informe uma imagem menor!"
                    ]);
                    return;
                }

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

                $uploaded = $upload->upload($file, $slide->id . "-" . str_slug($slide->title), 730);
                $cover = substr($uploaded, strrpos($uploaded, 'storage/') + 8);
                $slide->cover = $cover;
                $slide->save();
            }

            flash("success", "<i class='icon fas fa-check'></i> Post atualizado com sucesso!");
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
        if (!empty($data["slide_id"])) {
            $slideId = filter_var($data["slide_id"], FILTER_VALIDATE_INT);
            $slide = (new Slide())->findById("{$slideId}");
        }

        echo $this->view->render("widgets/slides/slide", [
            "app" => "slides/slide",
            "head" => $head,
            "slide" => $slide
        ]);
    }

    /**
     * ORDER SLIDE
     * @param array|null $data
     */
    public function SlideOrder(?array $data): void
    {
        if (is_array($data['Data'])) {
            foreach ($data['Data'] as $order) {
                $id = $order[0];
                $slide = (new Slide())->findById("{$id}");
                $slide->slide_order = $order[1];
                $slide->save();
            }
        }
    }

    /**
     * DELETE SLIDE
     * @param array|null $data
     */
    public function delete(?array $data): void
    {
        $data = filter_var_array($data, FILTER_VALIDATE_INT);

        $slide = (new Slide())->findById("{$data["slide_id"]}");
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