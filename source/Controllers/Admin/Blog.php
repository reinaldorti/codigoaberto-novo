<?php


namespace Source\Controllers\Admin;

use CoffeeCode\Uploader\Image;
use Source\Models\Post;
use Source\Models\User;
use Source\Support\Message;
use Source\Support\Pager;

class Blog extends Admin
{

    /**
     * Dash constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * ADMIN BLOG HOME
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
        $posts = (new Post())->find()->order("id DESC");

        if (!empty($data["search"]) && str_search($data["search"]) != "all") {
            $search = str_search($data["search"]);
            $posts = (new Post())->find("MATCH(title) AGAINST(:s)", "s={$search}");
            //$posts = (new User())->find("first_name LIKE = %{$search}%");
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
            "app" => "posts",
            "head" => $head,
            "search" => $search,
            "posts" => $posts->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render()
        ]);
    }

    /**
     * ADMIN BLOG POST
     * @param array $data
     */
    public function post(?array $data): void
    {
        //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $content = $data["content"];
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

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
                    "message" => "                 
                    Oops! Erro ao enviar o formulário!<br>
                    Por favor, atualize a página e tente novamente!
                "
                ]);
                return;
            }

            $postCreate = new Post();
            $postCreate->title = $data["title"];
            $postCreate->subtitle = $data["subtitle"];
            $postCreate->uri = str_slug($postCreate->title);
            $postCreate->tag = $data["tag"];
            $postCreate->video = $data["video"];
            $postCreate->status = $data["status"];
            $postCreate->author = $data["author"];
            $postCreate->title = $data["title"];
            $postCreate->content = str_replace(["{title}"], [$postCreate->title], $content);
            $postCreate->subtitle = $data["subtitle"];
            $postCreate->created_at = date("Y-m-d H:i:s");
            $postCreate->save();

            if (!empty($_FILES["cover"])) {
                $upload = new \CoffeeCode\Uploader\Image("storage", "posts");
                $file = $_FILES["cover"];

                if (empty($file["type"]) || !in_array($file["type"], $upload::isAllowed())) {
                    echo Message::ajaxResponse("message", [
                        "type" => "error",
                        "message" => "Oops! Selecione uma imagem válida!"
                    ]);
                    return;
                }

                if (file_exists(CONF_UPLOAD["STORAGE"] . "/{$postCreate->cover}") && !is_dir(CONF_UPLOAD["STORAGE"] . "/{$postCreate->cover}")) {
                    unlink(CONF_UPLOAD["STORAGE"] . "/{$postCreate->cover}");
                }

                $uploaded = $upload->upload($file, $postCreate->id . "-" . str_slug($postCreate->title), 500);
                $cover = substr($uploaded, strrpos($uploaded, 'storage/') + 8);
                $postCreate->cover = $cover;
                $postCreate->save();
            }

            flash("success", "
                <i class='icon fas fa-check'></i> Post cadastrado com sucesso!
            ");
            echo Message::ajaxResponse("redirect", [
                "url" => url("admin/blog/post/{$postCreate->id}")
            ]);
            return;
        }

        //update
        if (!empty($data["action"]) && $data["action"] == "update") {
            $content = $data["content"];
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

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
                    "message" => "                 
                    Oops! Erro ao enviar o formulário!<br>
                    Por favor, atualize a página e tente novamente!
                "
                ]);
                return;
            }

            $postEdit = (new Post())->findById("{$data["post_id"]}");
            $postEdit->title = $data["title"];
            $postEdit->subtitle = $data["subtitle"];
            $postEdit->uri = str_slug($postEdit->title);
            $postEdit->tag = $data["tag"];
            $postEdit->video = $data["video"];
            $postEdit->status = $data["status"];
            $postEdit->author = $data["author"];
            $postEdit->title = $data["title"];
            $postEdit->content = str_replace(["{title}"], [$postEdit->title], $content);
            $postEdit->subtitle = $data["subtitle"];
            $postEdit->updated_at = date("Y-m-d H:i:s");
            $postEdit->save();

            if (!empty($_FILES["cover"])) {
                $upload = new \CoffeeCode\Uploader\Image("storage", "posts");
                $file = $_FILES["cover"];

                if (empty($file["type"]) || !in_array($file["type"], $upload::isAllowed())) {
                    echo Message::ajaxResponse("message", [
                        "type" => "error",
                        "message" => "Oops! Selecione uma imagem válida!"
                    ]);
                    return;
                }

                if (file_exists(CONF_UPLOAD["STORAGE"] . "/{$postEdit->cover}") && !is_dir(CONF_UPLOAD["STORAGE"] . "/{$postEdit->cover}")) {
                    unlink(CONF_UPLOAD["STORAGE"] . "/{$postEdit->cover}");
                }

                $uploaded = $upload->upload($file, $postEdit->id . "-" . str_slug($postEdit->title), 500);
                $cover = substr($uploaded, strrpos($uploaded, 'storage/') + 8);
                $postEdit->cover = $cover;
                $postEdit->save();
            }

            flash("success", "
                <i class='icon fas fa-check'></i> Post cadastrado com sucesso!
            ");
            echo Message::ajaxResponse("redirect", [
                "url" => url("admin/blog/post/{$postEdit->id}")
            ]);
            return;
        }

        $head = $this->seo->render(
            CONF_SITE['NAME'] . " - " . CONF_SITE['TITLE'],
            CONF_SITE['DESC'],
            url('admin/users/create'),
            asset("/assets/images/logo/logo.png")
        );

        $postEdit = null;
        if (!empty($data["post_id"])) {
            $postId = filter_var($data["post_id"], FILTER_VALIDATE_INT);
            $postEdit = (new Post())->findById("{$postId}");
        }

        $csrf = csrf_input();
        echo $this->view->render("widgets/blog/post", [
            "app" => "blog/post",
            "head" => $head,
            "csrf" => $csrf,
            "post" => $postEdit,
            "authors" => (new User())->find("level >= :level", "level=6")->fetch(true)

        ]);
    }

    /**
     * ADMIN BLOG DELETE
     * @param array $data
     */
    public function delete($data): void
    {
        $data = filter_var_array($data, FILTER_VALIDATE_INT);
        $post = (new Post())->findById("{$data["id"]}");

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