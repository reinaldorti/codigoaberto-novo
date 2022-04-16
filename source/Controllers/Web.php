<?php

namespace Source\Controllers;

use CoffeeCode\Router\Router;
use Source\Models\About;
use Source\Models\Blog;
use Source\Models\Slide;
use Source\Models\Testimony;
use Source\Support\Message;
use Source\Support\Email;
use Source\Support\Pager;

/**
 * Class Web
 * @package Source\Controllers
 */
class Web extends Controller
{
    protected $router;

    /**
     * Web constructor.
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        parent::__construct(__DIR__ . "/../../public/" . CONF_VIEW['THEME'] . "/");

        $this->view->data([
            "router" => $router
        ]);
    }

    /**
     * SITE HOME
     */
    public function home(): void
    {
        $head = $this->seo->render(
            CONF_SITE['NAME'] . " - " . CONF_SITE['TITLE'],
            CONF_SITE['DESC'],
            url(),
            asset("/assets/images/logo/logo.png")
        );

        echo $this->view->render("home", [
            "head" => $head,
            "about" => (new About())->find()->order("id DESC")->limit(1)->fetch(true),
            "slides" => (new Slide())->find()->order("slide_order ASC")->fetch(true),
            "testimony" => (new Testimony())->find()->order("testimony_order ASC")->fetch(true)
        ]);
    }

    /**
     * SITE ABOUT
     */
    public function about(): void
    {
        $head = $this->seo->render(
            "Sobre - " . CONF_SITE['NAME'],
            CONF_SITE['DESC'],
            url("sobre"),
            asset("/assets/images/logo/logo.png")
        );

        echo $this->view->render("about", [
            "head" => $head,
            "about" => (new About())->find()->order("id DESC")->limit(1)->fetch(true)
        ]);
    }

    /**
     * SITE BLOG
     * @param array|null $data
     */
    public function blog(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $posts = (new Blog())->find("status = :status AND post_at <= NOW()", "status=1")->order("id DESC");

        $pager = new Pager(url("/blog/"));
        $pager->pager($posts->count(), 15, (!empty($data["page"]) ? $data["page"] : 1));
        $head = $this->seo->render(
            "Blog - " . CONF_SITE['NAME'],
            CONF_SITE['DESC'],
            url(),
            asset("/assets/images/logo/logo.png")
        );

        echo $this->view->render("blog", [
            "head" => $head,
            "posts" => $posts->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "views" => (new Blog())->find("status = :status AND post_at <= NOW()", "status=1")->order("views DESC")->fetch(true),
            "tags" => (new Blog())->find("status = :status AND post_at <= NOW()", "status=1")->order("id DESC")->fetch(true),
            "paginator" => $pager->render()
        ]);
    }

    /**
     * SITE BLOG SEARCH
     * @param array $data
     */
    public function blogSearch(array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        //search redirect
        if (!empty($data["s"])) {
            $s = str_search($data["s"]);

            echo Message::ajaxResponse("redirect", [
                "url" => url("/blog/buscar/{$s}/1")
            ]);
            return;
        }

        $search = null;
        $posts = (new Blog())->find("status = :status AND post_at <= NOW()", "status=1")->order("id DESC")->fetch();

        if (!empty($data["search"]) && str_search($data["search"]) != "all") {
            $search = str_search($data["search"]);
            $posts = (new Blog())->find("MATCH(title) AGAINST(:s)", "s={$search}");
            if (!$posts->count()) {
                flash("info", "Oops! Sua pesquisa não retornou resultados!");
                redirect("/blog/");
            }
        }

        $all = ($search ?? "all");
        $pager = new Pager(url("/blog/{$all}/"));
        $pager->pager($posts->count(), 15, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            "Blog - " . CONF_SITE['NAME'],
            CONF_SITE['DESC'],
            url(),
            asset("/assets/images/logo/logo.png")
        );

        echo $this->view->render("blog", [
            "head" => $head,
            "search" => $search,
            "posts" => $posts->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "tags" => (new Blog())->find("status = :status AND post_at <= NOW()", "status=1")->order("id DESC")->fetch(true),
            "views" => (new Blog())->find("status = :status AND post_at <= NOW()", "status=1")->order("views DESC")->fetch(true),
            "paginator" => $pager->render()
        ]);
    }

    /**
     * SITE BLOG POST
     * @param array $data
     */
    public function blogPost(array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $post = (new Blog())->find("status = :status AND uri = :url AND post_at <= NOW() ", "status=1&url={$data['uri']}")->fetch();
        if (!$post) {
            redirect("/404");
        }

        $post->views += 1;
        $post->save();

        $head = $this->seo->render(
            "{$post->title} - " . CONF_SITE['NAME'],
            CONF_SITE['DESC'],
            url(),
            asset("/assets/images/logo/logo.png")
        );

        echo $this->view->render("blog-post", [
            "head" => $head,
            "post" => $post,
            "tags" => (new Blog())->find("status = :status AND post_at <= NOW()", "status=1")->order("id DESC")->fetch(true),
            "views" => (new Blog())->find("status = :status AND post_at <= NOW()", "status=1")->order("views DESC")->fetch(true),
        ]);
    }

    /**
     * SITE BLOG TAG
     * @param array|null $data
     */
    public function tag(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $search = null;

        $search = str_search($data["tag"]);

        $tag = (new Blog())->find("MATCH(tag) AGAINST(:s)", "s={$search}");
        if (!$tag->count()) {
            flash("info", "Oops! Sua pesquisa não retornou resultados!");
            redirect("/blog/");
        }

        $all = ($search ?? "all");
        $pager = new Pager(url("/blog/{$all}/"));
        $pager->pager($tag->count(), 15, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            "Blog - " . CONF_SITE['NAME'],
            CONF_SITE['DESC'],
            url(),
            asset("/assets/images/logo/logo.png")
        );

        echo $this->view->render("blog", [
            "head" => $head,
            "search" => $search,
            "posts" => $tag->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "tags" => (new Blog())->find("status = :status AND post_at <= NOW()", "status=1")->order("id DESC")->fetch(true),
            "views" => (new Blog())->find("status = :status AND post_at <= NOW()", "status=1")->order("views DESC")->fetch(true),
            "paginator" => $pager->render()
        ]);
    }

    /**
     * SITE CONTATO
     * @param null|array $data
     */
    public function contact(?array $data): void
    {
        //send contact
        if (!empty($data["action"]) && $data["action"] == "contact") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $form = [$data["name"], $data["email"], $data["subject"], $data["message"]];
            if (in_array("", $form)) {
                echo Message::ajaxResponse("message", [
                    "type" => "error",
                    "message" => "<i class='fa fa-warning'></i> Oops! Por favor, preencha todos os campos para continuar!",
                    "top" => true,
                ]);

                return;
            }

            //VERIFY CSRF TOKEN
            if (!csrf_verify($data['csrf_token'])) {
                echo Message::ajaxResponse("message", [
                    "type" => "error",
                    "message" => "<i class='fa fa-warning'></i> Oops! Erro ao enviar o formulário! Por favor, atualize a página e tente novamente!",
                    "top" => true,
                ]);

                return;
            }

            //VALIDATE EMAIL
            if (!is_email($data["email"])) {
                echo Message::ajaxResponse("message", [
                    "type" => "error",
                    "message" => "<i class='fa fa-warning'></i>Oops! O e-email informado não é válido!",
                    "top" => true,
                ]);

                return;
            }

            $mail = new Email();
            $mail->add(
                $data["subject"],
                $this->view->render("../../shared/templates/contact", [
                    "message" => $data["message"],
                    "link" => url(),
                ]),
                CONF_MAIL['FROM_NAME'],
                CONF_MAIL['FROM_EMAIL']
            )->send();

            echo Message::ajaxResponse("message", [
                "type" => "success",
                "message" => "<i class='fa fa-check'></i>Pronto, {$data["name"]}! Sua mensagem foi enviada com sucesso!",
                "clear" => true
            ]);
            return;
        }

        $head = $this->seo->render(
            CONF_SITE['NAME'] . " - " . CONF_SITE['TITLE'],
            CONF_SITE['DESC'],
            url(),
            asset("/assets/images/logo/logo.png")
        );

        echo $this->view->render("contact", [
            "head" => $head,
            "csrf" => csrf_input(),
            //"siteKey" => CONF_GOOGLE_RECAPTCHA['SITE'],
        ]);
    }

    public function cookiePolicy(array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        setcookie("cookiePolicy", $data["cookie"], time() + (12 * 43200), "/");

        $json["agree"] = true;
        echo json_encode($json);
        return;
    }

    /**
     * SITE ERROR
     * @param $data
     */
    public function error($data): void
    {
        $error = filter_var($data["errcode"], FILTER_VALIDATE_INT);

        $head = $this->seo->render(
            "Oops {$error}" . " | " . CONF_SITE['NAME'],
            CONF_SITE['DESC'],
            url("/ops/{$error}"),
            asset("/assets/images/logo/logo.png"),
            false
        );

        echo $this->view->render("error", [
            "head" => $head,
            "error" => $error
        ]);
    }
}