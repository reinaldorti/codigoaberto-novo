<?php


namespace Source\Controllers\Admin;

use CoffeeCode\Uploader\Image;
use Source\Models\Post;
use Source\Models\User;
use Source\Support\Message;
use Source\Support\Pager;

/**
 * Class Blog
 * @package Source\Controllers\Admin
 */
class Posts extends Admin
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
                "url" => url("/admin/posts/home/{$s}/1")
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
                redirect("/admin/posts/home");
            }
        }

        $all = ($search ?? "all");
        $pager = new Pager(url("/admin/posts/home/{$all}/"));
        $pager->pager($posts->count(), 15, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE['NAME'] . " - " . CONF_SITE['TITLE'],
            CONF_SITE['DESC'],
            url('admin/users/home'),
            asset("/assets/images/logo/logo.png")
        );

        echo $this->view->render("widgets/posts/home", [
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

            $post = new Post();
            $post->title = $data["title"];
            $post->subtitle = $data["subtitle"];
            $post->uri = (!empty($data["uri"]) ? slug($data["uri"]) : slug($post->title));
            $post->tag = $data["tag"];
            $post->video = $data["video"];
            $post->status = $data["status"];
            $post->author = $data["author"];
            $post->title = $data["title"];
            $post->content = str_replace(["{title}"], [$post->title], $content);
            $post->subtitle = $data["subtitle"];
            $post->post_at = date_fmt($data["post_at"]);
            $post->created_at = date("Y-m-d H:i:s");
            $post->save();

            if (!empty($_FILES["cover"])) {
                $upload = new Image("storage", "posts");
                $file = $_FILES["cover"];

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

                $uploaded = $upload->upload($file, $post->id . "-" . slug($post->title), 730);
                $cover = substr($uploaded, strrpos($uploaded, 'storage/') + 8);
                $post->cover = $cover;
                $post->save();
            }

            flash("success", "
                <i class='icon fas fa-check'></i> Post cadastrado com sucesso!
            ");
            echo Message::ajaxResponse("redirect", [
                "url" => url("admin/posts/post/{$post->id}")
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

            $post = (new Post())->findById("{$data["post_id"]}");
            $post->title = $data["title"];
            $post->subtitle = $data["subtitle"];
            $post->uri = (!empty($data["uri"]) ? slug($data["uri"]) : slug($post->title));
            $post->tag = $data["tag"];
            $post->video = $data["video"];
            $post->status = $data["status"];
            $post->author = $data["author"];
            $post->title = $data["title"];
            $post->content = str_replace(["{title}"], [$post->title], $content);
            $post->subtitle = $data["subtitle"];
            $post->post_at = date_fmt($data["post_at"]);
            $post->updated_at = date("Y-m-d H:i:s");
            $post->save();

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

                if (file_exists(CONF_UPLOAD["STORAGE"] . "/{$post->cover}") && !is_dir(CONF_UPLOAD["STORAGE"] . "/{$post->cover}")) {
                    unlink(CONF_UPLOAD["STORAGE"] . "/{$post->cover}");
                }

                $uploaded = $upload->upload($file, $post->id . "-" . slug($post->title), 730);
                $cover = substr($uploaded, strrpos($uploaded, 'storage/') + 8);
                $post->cover = $cover;
                $post->save();
            }

            flash("success", "
                <i class='icon fas fa-check'></i> Post atualizado com sucesso!
            ");
            echo Message::ajaxResponse("redirect", [
                "url" => url("admin/posts/post/{$post->id}")
            ]);
            return;
        }

        $head = $this->seo->render(
            CONF_SITE['NAME'] . " - " . CONF_SITE['TITLE'],
            CONF_SITE['DESC'],
            url('admin/users/create'),
            asset("/assets/images/logo/logo.png")
        );

        $post = null;
        if (!empty($data["post_id"])) {
            $postId = filter_var($data["post_id"], FILTER_VALIDATE_INT);
            $post = (new Post())->findById("{$postId}");
        }

        echo $this->view->render("widgets/posts/post", [
            "app" => "blog/post",
            "head" => $head,
            "csrf" => csrf_input(),
            "post" => $post,
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
            redirect("admin/posts/home");
        }

        if (file_exists(CONF_UPLOAD["STORAGE"] . "/{$post->cover}") && !is_dir(CONF_UPLOAD["STORAGE"] . "/{$post->cover}")) {
            unlink(CONF_UPLOAD["STORAGE"] . "/{$post->cover}");
        }

        $post->destroy();

        flash("success", "<i class='icon fas fa-check'></i> Post foi removido com sucesso!");
        redirect("admin/blog/home");
    }
}