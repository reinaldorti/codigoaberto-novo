<?php

namespace Source\Controllers;

use CoffeeCode\Router\Router;
use ElePHPant\Cookie\Cookie;
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
    /**
     * @var
     */
    protected $router;

    /**
     * Web constructor.
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        parent::__construct(__DIR__ . "/../../public/" . CONF_VIEW["THEME"] . "/");

        $this->view->data([
            "router" => $router,
            "csrf" => csrf_input()
        ]);
    }

    /**
     * SITE HOME
     */
    public function home(): void
    {
        $head = $this->seo->render(
            CONF_SITE["NAME"] . " - " . CONF_SITE["TITLE"],
            CONF_SITE["DESC"],
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
            "Sobre - " . CONF_SITE["NAME"],
            CONF_SITE["DESC"],
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
            "Blog - " . CONF_SITE["NAME"],
            CONF_SITE["DESC"],
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
            "Blog - " . CONF_SITE["NAME"],
            CONF_SITE["DESC"],
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

        $post = (new Blog())->find("status = :status AND uri = :url AND post_at <= NOW() ", "status=1&url={$data["uri"]}")->fetch();
        if (!$post) {
            redirect("/404");
        }

        $post->views += 1;
        $post->save();

        $head = $this->seo->render(
            "{$post->title} - " . CONF_SITE["NAME"],
            CONF_SITE["DESC"],
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
            "Blog - " . CONF_SITE["NAME"],
            CONF_SITE["DESC"],
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
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        //send contact
        if (!empty($data["action"]) && $data["action"] == "contact") {

            $form = [$data["name"], $data["email"], $data["subject"], $data["message"]];
            if (in_array("", $form)) {
                echo Message::ajaxResponse("message", [
                    "type" => "error",
                    "message" => "<i class='fa fa-warning'></i> Oops! Por favor, preencha todos os campos para continuar!",
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

            $url = url();
            $button = "ACESSAR SITE";
            $subject = $data["subject"];

            $mail = new Email();
            $mail->add(
                "{$subject}",
                $this->view->render(__DIR__ . "/../../shared/views/email/web/contact", [
                    "subject" => $subject,
                    "data" => $data,
                    "url" => $url,
                    "button" => $button,
                ]),
                CONF_MAIL["FROM_NAME"],
                CONF_MAIL["FROM_EMAIL"]
            )->send();

            echo Message::ajaxResponse("message", [
                "type" => "success",
                "message" => "<i class='fa fa-check'></i>Pronto, {$data["name"]}! Sua mensagem foi enviada com sucesso!",
                "clear" => true
            ]);
            return;
        }

        $head = $this->seo->render(
            CONF_SITE["NAME"] . " - " . CONF_SITE["TITLE"],
            CONF_SITE["DESC"],
            url(),
            asset("/assets/images/logo/logo.png")
        );

        echo $this->view->render("contact", [
            "head" => $head
        ]);
    }

    /**
     * SITE COOKIE POLICY
     * @param array $data
     */
    public function cookieConsent(array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        Cookie::set("cookieConsent", $data["cookie"], (12 * 43200)); // 1 year

        //ACCEPT
        if ($data["cookie"] == "accept") {
            $json["gtmHead"] = $this->view->render("gtm/gtm-head");
            $json["gtmBody"] = $this->view->render("gtm/gtm-body");
        }

        $json["cookie"] = true;
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
            "Oops {$error}" . " | " . CONF_SITE["NAME"],
            CONF_SITE["DESC"],
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