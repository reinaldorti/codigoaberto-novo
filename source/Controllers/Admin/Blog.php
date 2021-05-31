<?php

namespace Source\Controllers\Admin;

use CoffeeCode\Uploader\Image;
use Source\Models\BlogGallery;
use Source\Models\User;
use Source\Support\Message;
use Source\Support\Pager;

/**
 * Class Blog
 * @package Source\Controllers\Admin
 */
class Blog extends Admin
{
    /**
     * BLOG HOME
     * @param array|null $data
     */
    public function home(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        //search redirect
        if (!empty($data["s"])) {
            $s = str_search($data["s"]);

            echo Message::ajaxResponse("redirect", [
                "url" => url("/admin/blog/home/{$s}/1")
            ]);
            return;
        }

        $search = null;
        $posts = (new \Source\Models\Blog())->find()->order("id DESC");

        if (!empty($data["search"]) && str_search($data["search"]) != "all") {
            $search = str_search($data["search"]);
            $posts = (new \Source\Models\Blog())->find("MATCH(title) AGAINST(:s)", "s={$search}");
            if (!$posts->count()) {
                flash("info", "Oops! Sua pesquisa não retornou resultados!");
                redirect("/admin/blog/home");
            }
        }

        $all = ($search ?? "all");
        $pager = new Pager(url("/admin/blog/home/{$all}/"));
        $pager->pager($posts->count(), 15, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE['NAME'] . " - " . CONF_SITE['TITLE'],
            CONF_SITE['DESC'],
            url('admin/users/home'),
            asset("/assets/images/logo/logo.png")
        );

        echo $this->view->render("widgets/blog/home", [
            "app" => "blog",
            "head" => $head,
            "search" => $search,
            "posts" => $posts->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render()
        ]);
    }

    /**
     * MANAGER BLOG
     * @param array|null $data
     * @throws \Exception
     */
    public function blog(?array $data): void
    {
        if (!empty($data["content"])) {
            $content = $data["content"];
        }

        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        //create
        if (!empty($data["action"]) && $data["action"] == "create") {

            unset($data["cover"]);

            $form = [$data["title"], $data["subtitle"], $data["tag"], $data["status"], $data["author"], $data["content"]];
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

            $post = new \Source\Models\Blog();
            $post->title = $data["title"];
            $post->subtitle = $data["subtitle"];
            $post->uri = str_slug($post->title);
            $post->tag = $data["tag"];
            $post->video = $data["video"];
            $post->status = $data["status"];
            $post->author = $data["author"];
            $post->content = str_replace(["{title}"], [$post->title], $content);
            $post->post_at = (empty($data["post_at"]) ? date("Y-m-d") : date_fmt($data["post_at"]));
            $post->created_at = date("Y-m-d H:i:s");

            if (!empty($_FILES["cover"])) {
                $upload = new Image("storage", "blog");
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
                        "message" => "Oops! Selecione uma imagem válida!"
                    ]);
                    return;
                }

                $uploaded = $upload->upload($file, str_slug($data["title"]) . time() . "-", 730);
                $cover = substr($uploaded, strrpos($uploaded, 'storage/') + 8);
                $post->cover = $cover;
            }

            $post->save();

            flash("success", "<i class='icon fas fa-check'></i> Post cadastrado com sucesso!");
            echo Message::ajaxResponse("redirect", [
                "url" => url("admin/blog/blog/{$post->id}")
            ]);
            return;
        }

        //update
        if (!empty($data["action"]) && $data["action"] == "update") {

            $form = [$data["title"], $data["subtitle"], $data["tag"], $data["status"], $data["author"]];
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

            $post = (new \Source\Models\Blog())->findById("{$data["post_id"]}");
            $post->title = $data["title"];
            $post->subtitle = $data["subtitle"];
            $post->uri = str_slug($post->title);
            $post->tag = $data["tag"];
            $post->video = $data["video"];
            $post->status = $data["status"];
            $post->author = $data["author"];
            $post->content = str_replace(["{title}"], [$post->title], $content);
            $post->post_at = date_fmt($data["post_at"]);
            $post->updated_at = date("Y-m-d H:i:s");
            $post->save();

            if (!empty($_FILES["cover"])) {
                $upload = new Image("storage", "blog");
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
                        "message" => "Oops! Selecione uma imagem válida!"
                    ]);
                    return;
                }

                if (file_exists(CONF_UPLOAD["STORAGE"] . "/{$post->cover}") && !is_dir(CONF_UPLOAD["STORAGE"] . "/{$post->cover}")) {
                    unlink(CONF_UPLOAD["STORAGE"] . "/{$post->cover}");
                }

                $uploaded = $upload->upload($file, $post->id . "-" . str_slug($post->title), 730);
                $cover = substr($uploaded, strrpos($uploaded, 'storage/') + 8);
                $post->cover = $cover;
                $post->save();
            }

            //gallery
            if (!empty($_FILES["images"])) {

                $images = $_FILES["images"];

                for ($i = 0; $i < count($images["type"]); $i++) {
                    foreach (array_keys($images) as $keys) {
                        $imageFiles[$i][$keys] = $images[$keys][$i];
                    }
                }

                $upload = new Image("storage", "blog");

                foreach ($imageFiles as $file) {
                    if (empty($file["type"])) {
                        echo Message::ajaxResponse("message", [
                            "type" => "error",
                            "message" => "<i class='icon fas fa-ban'></i> Oops! Selecione uma imagem válida!"
                        ]);
                        return;
                    } elseif (!in_array($file["type"], $upload::isAllowed())) {
                        echo Message::ajaxResponse("message", [
                            "type" => "error",
                            "message" => "<i class='icon fas fa-ban'></i> O arquivo {$file["name"]} não é válido!"
                        ]);
                        return;
                    } else {

                        ini_set('memory_limit', '-1');
                        ini_set('max_execution_time', '0');
                        ini_set('max_input_vars', 3000);
                        set_time_limit(0);

                        $uploaded = $upload->upload($file, pathinfo($data["post_id"] . "-" .$file["name"], PATHINFO_FILENAME), 730);
                        $images = substr($uploaded, strrpos($uploaded, 'storage/') + 8);

                        $gallery = new BlogGallery();
                        $gallery->images = $images;
                        $gallery->post_id = $data["post_id"];
                        $gallery->save();
                    }
                }
            }

            flash("success", "<i class='icon fas fa-check'></i> Post atualizado com sucesso!");
            echo Message::ajaxResponse("redirect", [
                "url" => url("admin/blog/blog/{$post->id}")
            ]);
            return;
        }

        $head = $this->seo->render(
            CONF_SITE['NAME'] . " - " . CONF_SITE['TITLE'],
            CONF_SITE['DESC'],
            url('admin/blog/blog'),
            asset("/assets/images/logo/logo.png")
        );

        $post = null;
        if (!empty($data["post_id"])) {
            $postId = filter_var($data["post_id"], FILTER_VALIDATE_INT);
            $post = (new \Source\Models\Blog())->findById("{$postId}");
        }

        echo $this->view->render("widgets/blog/blog", [
            "app" => "blog/blog",
            "head" => $head,
            "csrf" => csrf_input(),
            "post" => $post,
            "gallery" => (!empty($data["post_id"]) ? (new BlogGallery())->find("post_id=:id","id={$data["post_id"]}")->fetch(true) : null),
            "authors" => (new User())->find("level >= :level", "level=6")->fetch(true)
        ]);
    }

    /**
     * DELETE GALLERY
     * @param array $data
     */
    public function GalleryDelete(array $data): void
    {
        $data = filter_var_array($data, FILTER_VALIDATE_INT);

        $gallery = (new BlogGallery())->findById("{$data["post_id"]}");
        $post = (new \Source\Models\Blog())->findById("{$gallery->post_id}");

        if (file_exists(CONF_UPLOAD["STORAGE"] . "/{$gallery->images}") && !is_dir(CONF_UPLOAD["STORAGE"] . "/{$gallery->images}")) {
            unlink(CONF_UPLOAD["STORAGE"] . "/{$gallery->images}");
        }

        $gallery->destroy();

        flash("success", "<i class='icon fas fa-check'></i> Imagem foi removido com sucesso!");
        redirect("admin/blog/blog/{$post->id}");
    }

    /**
     * DELETE BLOG
     * @param int $data
     */
    public function delete($data): void
    {
        $data = filter_var_array($data, FILTER_VALIDATE_INT);

        $post = (new \Source\Models\Blog())->findById("{$data["post_id"]}");
        if (!$post) {
            flash("error", "Oops! Você tentou gerenciar um post que não existe!");
            redirect("admin/blog/home");
        }

        if (file_exists(CONF_UPLOAD["STORAGE"] . "/{$post->cover}") && !is_dir(CONF_UPLOAD["STORAGE"] . "/{$post->cover}")) {
            unlink(CONF_UPLOAD["STORAGE"] . "/{$post->cover}");
        }

        $post->destroy();

        flash("success", "<i class='icon fas fa-check'></i> Post foi removido com sucesso!");
        redirect("admin/blog/home");
    }
}
