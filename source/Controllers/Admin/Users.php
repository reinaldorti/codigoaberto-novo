<?php


namespace Source\Controllers\Admin;

use CoffeeCode\Uploader\Image;
use Source\Models\User;
use Source\Support\Message;
use Source\Support\Pager;

/**
 * Class Users
 * @package Source\Controllers\Admin
 */
class Users extends Admin
{

    /**
     * Dash constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * ADMIN TELA USERS HOME
     * @param array|null $data
     */
    public function home(?array $data): void
    {
        //search redirect
        if (!empty($data["s"])) {
            $s = str_search($data["s"]);

            echo Message::ajaxResponse("redirect", [
                "url" => url("/admin/users/home/{$s}/1")
            ]);
            return;
        }

        $search = null;
        $users = (new User())->find()->order("id DESC");

        if (!empty($data["search"]) && str_search($data["search"]) != "all") {
            $search = str_search($data["search"]);
            //$users = (new User())->find("first_name LIKE '%' :s '%' OR email LIKE '%' :s '%'", "status=1&s={$search}&s={$search}");
            //$users = (new User())->find("MATCH(first_name) AGAINST(:s)", "s={$search}");
            $users = (new User())->find("MATCH(first_name) AGAINST(:s)", "s={$search}");
            if (!$users->count()) {
                flash("info", "
                    <i class='icon fas fa-info'></i> Oops! Sua pesquisa não retornou resultados!
                ");
                redirect("/admin/users/home");
            }
        }

        $all = ($search ?? "all");
        $pager = new Pager(url("/admin/users/home/{$all}/"));
        $pager->pager($users->count(), 15, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE['NAME'] . " - " . CONF_SITE['TITLE'],
            CONF_SITE['DESC'],
            url('admin/users/home'),
            asset("/assets/images/logo/logo.png")
        );

        echo $this->view->render("widgets/users/home", [
            "app" => "users",
            "head" => $head,
            "search" => $search,
            "users" => $users->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render()
        ]);
    }

    /**
     * ADMIN TELA USERS CREATE/UPDATE
     * @param array|null $data
     */
    public function user(?array $data): void
    {
        //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $form = [$data["first_name"], $data["last_name"], $data["email"], $data["genre"], $data["level"], $data["status"], $data["password"]];
            if (in_array("", $form)) {
                echo Message::ajaxResponse("message", [
                    "type" => "error",
                    "message" => "Oops! Por favor, preencha todos os campos (*) obrigatórios!"
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

            if (!is_passwd($data["password"])){
                echo Message::ajaxResponse("message", [
                    "type" => "alert",
                    "message" => "
                    Oops! A senha deve ter entre " . CONF_PASSWD['MIN'] . " e " . CONF_PASSWD['MAX'] . " caracteres!
                "
                ]);
                return;
            };

            $userCreate = new User();
            $userCreate->first_name = $data["first_name"];
            $userCreate->last_name = $data["last_name"];
            $userCreate->email = $data["email"];
            $userCreate->telephone = preg_replace('/[^0-9]/', '', $data["telephone"]);
            $userCreate->genre = $data["genre"];
            $userCreate->level = $data["level"];
            $userCreate->status = $data["status"];
            $userCreate->password = $data["password"];

            if (!$userCreate->save()) {
                echo Message::ajaxResponse("message", [
                    "type" => "error",
                    "message" => $userCreate->fail()->getMessage()
                ]);
                return;
            }

            if (!empty($_FILES["photo"])) {
                $upload = new Image("storage", "users");
                $file = $_FILES["photo"];

                if (empty($file["type"]) || !in_array($file["type"], $upload::isAllowed())) {
                    echo Message::ajaxResponse("message", [
                        "type" => "error",
                        "message" => "Oops! Selecione uma imagem válida!"
                    ]);
                    return;
                }

                if (file_exists(CONF_UPLOAD["STORAGE"] . "/{$userCreate->photo}") && !is_dir(CONF_UPLOAD["STORAGE"] . "/{$userCreate->photo}")) {
                    unlink(CONF_UPLOAD["STORAGE"] . "/{$userCreate->photo}");
                }

                $uploaded = $upload->upload($file, $userCreate->id . "-" . str_slug($userCreate->first_name), 500);
                $photo = substr($uploaded, strrpos($uploaded, 'storage/') + 8);
                $userCreate->photo = $photo;
                $userCreate->save();
            }

            flash("success", "
                <i class='icon fas fa-check'></i> Usuário cadastrado com sucesso!
            ");
            echo Message::ajaxResponse("redirect", [
                "url" => url("admin/users/user/{$userCreate->id}")
            ]);
            return;
        }

        //update
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $userEdit = (new User())->findById("{$data["user_id"]}");

            if (!$userEdit) {
                echo Message::ajaxResponse("message", [
                    "type" => "error",
                    "message" => "Oops! Você tentou gerenciar um usuário que não existe!"
                ]);
                return;
            }

            $form = [$data["first_name"], $data["last_name"], $data["email"], $data["genre"], $data["level"], $data["status"]];
            if (in_array("", $form)) {
                echo Message::ajaxResponse("message", [
                    "type" => "error",
                    "message" => "Oops! Por favor, preencha todos os campos (*) obrigatórios!"
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

            if (!is_email($data["email"])){
                echo Message::ajaxResponse("message", [
                    "type" => "alert",
                    "message" => "
                    Oops! O e-email informado não é válido!
                "
                ]);
                return;
            }

            if (!empty($data["password"])){
                if (!is_passwd($data["password"])){
                    echo Message::ajaxResponse("message", [
                        "type" => "alert",
                        "message" => "
                        Oops! A senha deve ter entre " . CONF_PASSWD['MIN'] . " e " . CONF_PASSWD['MAX'] . " caracteres!
                    "
                    ]);
                    return;
                }
            }

            $userEdit->first_name = $data["first_name"];
            $userEdit->last_name = $data["last_name"];
            $userEdit->email = $data["email"];
            $userEdit->password = (!empty($data["password"]) ? $data["password"] : $userEdit->password);
            $userEdit->level = $data["level"];
            $userEdit->genre = $data["genre"];
            $userEdit->status = $data["status"];
            $userEdit->updated_at = date("Y-m-d H:i:s");

            if (!$userEdit->save()) {
                echo Message::ajaxResponse("message", [
                    "type" => "error",
                    "message" => $userEdit->fail()->getMessage()
                ]);
                return;
            }

            if (!empty($_FILES["photo"])) {
                $upload = new Image("storage", "users");
                $file = $_FILES["photo"];

                if (empty($file["type"]) || !in_array($file["type"], $upload::isAllowed())) {
                    echo Message::ajaxResponse("message", [
                        "type" => "error",
                        "message" => "Oops! Selecione uma imagem válida!"
                    ]);
                    return;
                }

                if (file_exists(CONF_UPLOAD["STORAGE"] . "/{$userEdit->photo}") && !is_dir(CONF_UPLOAD["STORAGE"] . "/{$userEdit->photo}")) {
                    unlink(CONF_UPLOAD["STORAGE"] . "/{$userEdit->photo}");
                }

                $uploaded = $upload->upload($file, $userEdit->id . "-" . str_slug($userEdit->first_name), 500);
                $photo = substr($uploaded, strrpos($uploaded, 'storage/') + 8);
                $userEdit->photo = $photo;
                $userEdit->save();
            }

            flash("success", "<i class='icon fas fa-check'></i> Usuário ataualizado com sucesso!");
            echo Message::ajaxResponse("redirect", [
                "url" => url("admin/users/user/{$userEdit->id}")
            ]);
            return;
        }

        $userEdit = null;
        if (!empty($data["user_id"])) {
            $userId = filter_var($data["user_id"], FILTER_VALIDATE_INT);
            $userEdit = (new User())->findById("{$userId}");
        }

        $csrf = csrf_input();
        $head = $this->seo->render(
            CONF_SITE['NAME'] . " - " . CONF_SITE['TITLE'],
            CONF_SITE['DESC'],
            url('admin/users/create'),
            asset("/assets/images/logo/logo.png")
        );

        echo $this->view->render("widgets/users/user", [
            "app" => "users/user",
            "head" => $head,
            "csrf" => $csrf,
            "user" => $userEdit
        ]);
    }

    /**
     * ADMIN USERS DELETE
     * @param array $data
     */
    public function delete($data): void
    {
        $data = filter_var_array($data, FILTER_VALIDATE_INT);

        $userDelete = (new User())->findById("{$data["user_id"]}");
        if (!$userDelete) {
            flash("error", "
                <i class='icon fas fa-ban'></i> 
                Oops! Você tentou deletar um usuário que não existe!
            ");
            redirect("admin/users/home");
        }

        if (User::user()->id == $data['user_id']) {
            flash("error", "
                <i class='icon fas fa-ban'></i> 
                Oops! Por questões de segurança, o sistema não permite que você remova sua própria conta!
            ");
            redirect("admin/users/home");
        }

        if (file_exists(CONF_UPLOAD["STORAGE"] . "/{$userDelete->photo}") && !is_dir(CONF_UPLOAD["STORAGE"] . "/{$userDelete->photo}")) {
            unlink(CONF_UPLOAD["STORAGE"] . "/{$userDelete->photo}");
        }

        $userDelete->destroy();

        flash("success", "
            <i class='icon fas fa-check'></i>
            Usuário foi removido com sucesso!
        ");
        redirect("admin/users/home");
    }
}