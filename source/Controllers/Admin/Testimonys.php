<?php

namespace Source\Controllers\Admin;

use CoffeeCode\Uploader\Image;
use Source\Models\Testimony;
use Source\Models\User;
use Source\Support\Message;
use Source\Support\Pager;

/**
 * Class Testimony
 * @package Source\Controllers\Admin
 */
class Testimonys extends Admin
{
    /**
     * TESTIMONY HOME
     * @param array|null $data
     */
    public function home(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        //search redirect
        if (!empty($data["s"])) {
            $s = str_search($data["s"]);

            echo Message::ajaxResponse("redirect", [
                "url" => url("/admin/testimony/home/{$s}/1")
            ]);
            return;
        }

        $search = null;
        $testimony = (new Testimony())->find()->order("testimony_order ASC");

        if (!empty($data["search"]) && str_search($data["search"]) != "all") {
            $search = str_search($data["search"]);
            $testimony = (new Testimony())->find("MATCH(title) AGAINST(:s)", "s={$search}");
            if (!$testimony->count()) {
                flash("info", "Oops! Sua pesquisa não retornou resultados!");
                redirect("/admin/testimony/home");
            }
        }

        $all = ($search ?? "all");
        $pager = new Pager(url("/admin/testimony/home/{$all}/"));
        $pager->pager($testimony->count(), 15, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE['NAME'] . " - " . CONF_SITE['TITLE'],
            CONF_SITE['DESC'],
            url('admin/testimony/home'),
            asset("/assets/images/logo/logo.png")
        );

        echo $this->view->render("widgets/testimony/home", [
            "app" => "testimony",
            "head" => $head,
            "search" => $search,
            "testimony" => $testimony->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render()
        ]);
    }

    /**
     * MANAGER TESTMANYS
     * @param array|null $data
     * @throws \Exception
     */
    public function testimony(?array $data): void
    {
        //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $content = $data["content"];
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $form = [$data["name"], $data["status"], $data["author"]];
            if (in_array("", $form)) {
                echo Message::ajaxResponse("message", [
                    "type" => "error",
                    "message" => "Oops! Por favor, preencha os campos com (*) para continuar!"
                ]);
                return;
            }

            if (!csrf_verify($data['csrf_token'])) {
                echo Message::ajaxResponse("message", [
                    "type" => "alert",
                    "message" => "Oops! Erro ao enviar o formulário! Por favor, atualize a página e tente novamente!"
                ]);
                return;
            }

            $testimony = new Testimony();
            $testimony->name = $data["name"];
            $testimony->status = $data["status"];
            $testimony->author = $data["author"];
            $testimony->content = str_replace(["{name}"], [$testimony->name], $content);
            $testimony->created_at = date("Y-m-d H:i:s");
            $testimony->save();

            if (!empty($_FILES["cover"])) {
                $upload = new Image("storage", "testimony");
                $file = $_FILES["cover"];

                $size = 1024 * 1024 * 2; // 2mb
                if ($file['size'] > $size) {
                    echo Message::ajaxResponse("message", [
                        "type" => "error",
                        "message" => "<i class='icon fas fa-ban'></i> Oops! A imagem enviada excede o limite de 2MB permitido. Por favor, informe uma imagem menor!"
                    ]);
                    return;
                }

                if (empty($file["type"]) || !in_array($file["type"], $upload::isAllowed())) {
                    echo Message::ajaxResponse("message", [
                        "type" => "error",
                        "message" => "Oops! Selecione uma imagem válida!"
                    ]);
                    return;
                }

                if (file_exists(CONF_UPLOAD["STORAGE"] . "/{$testimony->cover}") && !is_dir(CONF_UPLOAD["STORAGE"] . "/{$testimony->cover}")) {
                    unlink(CONF_UPLOAD["STORAGE"] . "/{$testimony->cover}");
                }

                $uploaded = $upload->upload($file, $testimony->id . "-" . slug($testimony->name), 730);
                $cover = substr($uploaded, strrpos($uploaded, 'storage/') + 8);
                $testimony->cover = $cover;
                $testimony->save();
            }

            flash("success", "<i class='icon fas fa-check'></i> Depoimento cadastrado com sucesso!");
            echo Message::ajaxResponse("redirect", [
                "url" => url("admin/testimony/testimony/{$testimony->id}")
            ]);
            return;
        }

        //update
        if (!empty($data["action"]) && $data["action"] == "update") {
            $content = $data["content"];
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $form = [$data["name"], $data["status"], $data["author"]];
            if (in_array("", $form)) {
                echo Message::ajaxResponse("message", [
                    "type" => "error",
                    "message" => "Oops! Por favor, preencha os campos com (*) para continuar!"
                ]);
                return;
            }

            if (!csrf_verify($data['csrf_token'])) {
                echo Message::ajaxResponse("message", [
                    "type" => "alert",
                    "message" => "Oops! Erro ao enviar o formulário! Por favor, atualize a página e tente novamente!"
                ]);
                return;
            }

            $testimony = (new Testimony())->findById("{$data["testimony_id"]}");
            $testimony->name = $data["name"];
            $testimony->status = $data["status"];
            $testimony->author = $data["author"];
            $testimony->content = str_replace(["{name}"], [$testimony->name], $content);
            $testimony->updated_at = date("Y-m-d H:i:s");
            $testimony->save();

            if (!empty($_FILES["cover"])) {
                $upload = new Image("storage", "testimony");
                $file = $_FILES["cover"];

                $size = 1024 * 1024 * 2; // 2mb
                if ($file['size'] > $size) {
                    echo Message::ajaxResponse("message", [
                        "type" => "error",
                        "message" => "<i class='icon fas fa-ban'></i> Oops! A imagem enviada excede o limite de 2MB permitido. Por favor, informe uma imagem menor!"
                    ]);
                    return;
                }

                if (empty($file["type"]) || !in_array($file["type"], $upload::isAllowed())) {
                    echo Message::ajaxResponse("message", [
                        "type" => "error",
                        "message" => "Oops! Selecione uma imagem válida!"
                    ]);
                    return;
                }

                if (file_exists(CONF_UPLOAD["STORAGE"] . "/{$testimony->cover}") && !is_dir(CONF_UPLOAD["STORAGE"] . "/{$testimony->cover}")) {
                    unlink(CONF_UPLOAD["STORAGE"] . "/{$testimony->cover}");
                }

                $uploaded = $upload->upload($file, $testimony->id . "-" . slug($testimony->name), 730);
                $cover = substr($uploaded, strrpos($uploaded, 'storage/') + 8);
                $testimony->cover = $cover;
                $testimony->save();
            }

            flash("success", "<i class='icon fas fa-check'></i> Post atualizado com sucesso!");
            echo Message::ajaxResponse("redirect", [
                "url" => url("admin/testimony/testimony/{$testimony->id}")
            ]);
            return;
        }

        $head = $this->seo->render(
            CONF_SITE['NAME'] . " - " . CONF_SITE['TITLE'],
            CONF_SITE['DESC'],
            url('admin/users/create'),
            asset("/assets/images/logo/logo.png")
        );

        $testimony = null;
        if (!empty($data["testimony_id"])) {
            $postId = filter_var($data["testimony_id"], FILTER_VALIDATE_INT);
            $testimony = (new Testimony())->findById("{$postId}");
        }

        echo $this->view->render("widgets/testimony/testimony", [
            "app" => "testimony/testimony",
            "head" => $head,
            "csrf" => csrf_input(),
            "testimony" => $testimony,
            "authors" => (new User())->find("level >= :level", "level=6")->fetch(true)
        ]);
    }

    /**
     * ORDER TESTIMYS
     * @param array|null $data
     */
    public function TestimonyOrder(?array $data): void
    {
        if (is_array($data['Data'])) {
            foreach ($data['Data'] as $order) {
                $id = $order[0];
                $testimony = (new Testimony())->findById("{$id}");
                $testimony->testimony_order = $order[1];
                $testimony->save();
            }
        }
    }

    /**
     * DELETE COMMENTS
     * @param int $data
     */
    public function delete($data): void
    {
        $data = filter_var_array($data, FILTER_VALIDATE_INT);
        $testimony = (new Testimony())->findById("{$data["testimony_id"]}");

        if (!$testimony) {
            flash("error", "Oops! Você tentou gerenciar um depoimento que não existe!");
            redirect("admin/testimony/home");
        }

        if (file_exists(CONF_UPLOAD["STORAGE"] . "/{$testimony->cover}") && !is_dir(CONF_UPLOAD["STORAGE"] . "/{$testimony->cover}")) {
            unlink(CONF_UPLOAD["STORAGE"] . "/{$testimony->cover}");
        }

        $testimony->destroy();

        flash("success", "<i class='icon fas fa-check'></i> Depoimento foi removido com sucesso!");
        redirect("admin/testimony/home");
    }
}
