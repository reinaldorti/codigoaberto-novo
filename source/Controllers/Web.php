<?php


namespace Source\Controllers;

use Source\Support\Message;
use Source\Support\Email;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager;
/**
 * Class Web
 * @package Source\Controllers
 */
class Web extends Controller
{
    /**
     * Web constructor.
     * @param $router
     */
    public function __construct($router)
    {
        $this->router = $router;
        parent::__construct(__DIR__ . "/../../themes/" . CONF_VIEW['THEME'] . "/");
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
        ]);
    }

    /**
     * SITE SOBRE
     */
    public function about(): void
    {
        $head = $this->seo->render(
            CONF_SITE['NAME'] . " - " . CONF_SITE['TITLE'],
            CONF_SITE['DESC'],
            url(),
            asset("/assets/images/logo/logo.png")
        );

        echo $this->view->render("about", [
            "head" => $head
        ]);
    }

    /**
     * SITE BLOG
     * @param array|null $data
     */
    public function blog(?array $data): void
    {
        $head = $this->seo->render(
            CONF_SITE['NAME'] . " - " . CONF_SITE['TITLE'],
            CONF_SITE['DESC'],
            url(),
            asset("/assets/images/logo/logo.png")
        );

        echo $this->view->render("blog", [
            "head" => $head
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
                    "message" => "<i class='fa fa-warning'></i> Oops! Por favor, preencha todos os campos para continuar!"
                ]);
                return;
            }

            //VERIFY CSRF TOKEN
            if (!csrf_verify($data['csrf_token'])) {
                echo Message::ajaxResponse("message", [
                    "type" => "alert",
                    "message" => "
                    <i class='fa fa-warning'></i> 
                    Oops! Erro ao enviar o formulário!<br>
                    Por favor, atualize a página e tente novamente!
                "
                ]);
                return;
            }

            //VALIDATE EMAIL
            if (!is_email($data["email"])){
                echo Message::ajaxResponse("message", [
                    "type" => "alert",
                    "message" => "
                    <i class='fa fa-warning'></i>
                    Oops! O e-email informado não é válido!
                "
                ]);
                return;
            }

            $Mail = new Email();
            $Mail->add(
                $data["subject"],
                $this->view->render("emails/contact", [
                    "data" => $data,
                    "link" => url(),
                ]),
                "{$data["name"]}",
                $data["email"]
            )->send();

            echo Message::ajaxResponse("message", [
                "type" => "success",
                "message" => "
                <i class='fa fa-check'></i> Pronto, {$data["name"]}! <br>
                Sua mensagem foi enviada com sucesso!
            "
            ]);
            return;
        }

        $csrf = csrf_input();
        $head = $this->seo->render(
            CONF_SITE['NAME'] . " - " . CONF_SITE['TITLE'],
            CONF_SITE['DESC'],
            url(),
            asset("/assets/images/logo/logo.png")
        );

        echo $this->view->render("contact", [
            "head" => $head,
            "csrf" => $csrf

        ]);
    }

    /**
     * START DATABASE
     * @param null|array $data
     */
    public function database(?array $data): void
    {
        $capsule = new Capsule();
        $capsule->addConnection([
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'codigoaberto',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]);
        $capsule->setEventDispatcher(new Dispatcher(new Container));
        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        $minify = filter_input(INPUT_GET, "db", FILTER_VALIDATE_BOOLEAN);
        if ($minify) {

            var_dump("aqui");

            Manager::schema()->dropIfExists('users');
            Manager::schema()->create('users', function ($table) {
                $table->increments('id');
                $table->bigInteger('logged')->nullable();
                $table->bigInteger('level')->default('1');
                $table->string('status', 50)->nullable()->comment('1 ativo 2 inativo');
                $table->string('first_name')->nullable();
                $table->string('last_name')->nullable();
                $table->string('email')->unique();
                $table->string('password')->nullable();
                $table->string('telephone')->nullable();
                $table->string('forget')->nullable();
                $table->string('token')->nullable();
                $table->string('genre', 20)->nullable()->comment('1 male, 2 female');
                $table->string('document')->nullable();
                $table->string('photo')->nullable();
                $table->string('facebook_id')->nullable();
                $table->string('google_id')->nullable();
                $table->string('user_login')->nullable();
                $table->string('ip')->nullable();
                $table->string('lastaccess')->nullable();
                $table->date('datebirth')->nullable();
                $table->timestamps();
            });

            Manager::schema()->dropIfExists('address');
            Manager::schema()->create('address', function ($table) {
                $table->unsignedInteger('user_id')->nullable();
                $table->increments('id');
                $table->string('zipcode')->nullable();
                $table->string('street')->nullable();
                $table->string('number')->nullable();
                $table->string('complement')->nullable();
                $table->string('district')->nullable();
                $table->string('city')->nullable();
                $table->string('state')->nullable();
                $table->string('country')->nullable();
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
            });

            Manager::schema()->dropIfExists('categories');
            Manager::schema()->create('categories', function ($table) {
                $table->increments('id');
                $table->bigInteger('status')->default('1');
                $table->string('uri')->nullable();
                $table->string('type')->nullable();
                $table->text('description')->nullable();
                $table->timestamps();
            });

            Manager::schema()->dropIfExists('posts');
            Manager::schema()->create('posts', function ($table) {
                $table->increments('id');
                $table->unsignedInteger('author')->nullable();
                $table->unsignedInteger('category')->nullable();
                $table->string('status', 20)->default('1')->comment('1 ativo, 2 inativo');
                $table->string('title')->nullable();
                $table->string('uri')->nullable();
                $table->string('cover')->nullable();
                $table->string('video')->nullable();
                $table->string('tag')->nullable();
                $table->text('subtitle')->nullable();
                $table->text('content')->nullable();
                $table->decimal('views', 10, 2)->nullable();
                $table->timestamp('post_at')->nullable();
                $table->timestamps();

                $table->foreign('author')->references('id')->on('users')->onDelete('CASCADE');
                $table->foreign('category')->references('id')->on('categories')->onDelete('CASCADE');
            });

            flash("success", "
                    <i class='icon fas fa-check'></i> Pronto! Tabelas foram criadas com sucesso!
                ");
            redirect("/admin");
        }
    }

    /**
     * @param $data
     */
    public function error($data): void
    {
        $error = filter_var($data["errcode"], FILTER_VALIDATE_INT);
        $head = $this->seo->render(
            "Oops {$error}" . " | " .  CONF_SITE['NAME'],
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