<?php

namespace Source\Controllers\Admin;

use CoffeeCode\Uploader\Image;
use Source\Models\User;
use Source\Support\Message;
use Source\Support\Pager;

/**
 * Class Testimony
 * @package Source\Controllers\Admin
 */
class Testimony extends Admin
{
    /**
     * ADMIN TESTIMONY HOME
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
        $testimony = (new \Source\Models\Testimony())->find()->order("id DESC");

        if (!empty($data["search"]) && str_search($data["search"]) != "all") {
            $search = str_search($data["search"]);
            $testimony = (new \Source\Models\Testimony())->find("MATCH(title) AGAINST(:s)", "s={$search}");
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
     * ADMIN DEPOIMENTO
     * @param array|null $data
     * @throws \Exception
     */
    public function testimony(?array $data): void
    {
        //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $content = $data["content"];
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $form = [$data["title"], $data["status"], $data["author"]];
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
                    "message" => "                 
                    Oops! Erro ao enviar o formulário!<br>
                    Por favor, atualize a página e tente novamente!
                "
                ]);
                return;
            }

            $testimony = new \Source\Models\Testimony();
            $testimony->title = $data["title"];
            $testimony->status = $data["status"];
            $testimony->author = $data["author"];
            $testimony->content = str_replace(["{title}"], [$testimony->title], $content);
            $testimony->created_at = date("Y-m-d H:i:s");
            $testimony->save();


            var_dump($testimony->save());

            if (!empty($_FILES["cover"])) {
                $upload = new Image("storage", "testimony");
                $file = $_FILES["cover"];

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

                $uploaded = $upload->upload($file, $testimony->id . "-" . slug($testimony->title), 730);
                $cover = substr($uploaded, strrpos($uploaded, 'storage/') + 8);
                $testimony->cover = $cover;
                $testimony->save();
            }

            flash("success", "
                <i class='icon fas fa-check'></i> Depoimento cadastrado com sucesso!
            ");
            echo Message::ajaxResponse("redirect", [
                //"url" => url("admin/testimony/testimony/{$testimony->id}")
                "url" => url("admin/testimony/testimony")
            ]);
            return;
        }

        //update
        if (!empty($data["action"]) && $data["action"] == "update") {
            $content = $data["content"];
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $form = [$data["title"], $data["status"], $data["author"]];
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
                    "message" => "                 
                    Oops! Erro ao enviar o formulário!<br>
                    Por favor, atualize a página e tente novamente!
                "
                ]);
                return;
            }

            $testimony = (new \Source\Models\Testimony())->findById("{$data["id"]}");
            $testimony->title = $data["title"];
            $testimony->status = $data["status"];
            $testimony->author = $data["author"];
            $testimony->content = str_replace(["{title}"], [$testimony->title], $content);
            $testimony->updated_at = date("Y-m-d H:i:s");
            $testimony->save();

            if (!empty($_FILES["cover"])) {
                $upload = new \CoffeeCode\Uploader\Image("storage", "testimony");
                $file = $_FILES["cover"];

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

                $uploaded = $upload->upload($file, $testimony->id . "-" . slug($testimony->title), 730);
                $cover = substr($uploaded, strrpos($uploaded, 'storage/') + 8);
                $testimony->cover = $cover;
                $testimony->save();
            }

            flash("success", "
                <i class='icon fas fa-check'></i> Post atualizado com sucesso!
            ");
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
        if (!empty($data["id"])) {
            $postId = filter_var($data["id"], FILTER_VALIDATE_INT);
            $testimony = (new \Source\Models\Testimony())->findById("{$postId}");
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
     * ADMIN COMMENTS DELETE
     * @param int $data
     */
    public function delete($data): void
    {
        $data = filter_var_array($data, FILTER_VALIDATE_INT);
        $testimony = (new \Source\Models\Testimony())->findById("{$data["id"]}");

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
