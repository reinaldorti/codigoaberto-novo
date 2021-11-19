<?php

namespace Source\Controllers\Admin;

use CoffeeCode\Uploader\Image;
use Source\Models\Address;
use Source\Models\User;
use Source\Models\Blog;
use Source\Support\Email;
use Source\Support\Message;
use Source\Support\Pager;

/**
 * Class Users
 * @package Source\Controllers\Admin
 */
class Users extends Admin
{
    /**
     * USERS HOME
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
            $users = (new User())->find("MATCH(first_name, last_name, email) AGAINST(:s)", "s={$search}");
            if (!$users->count()) {
                flash("info", "<i class='icon fas fa-info'></i> Oops! Sua pesquisa não retornou resultados!");
                redirect("/admin/users/home");
            }
        }

        $all = ($search ?? "all");
        $pager = new Pager(url("/admin/users/home/{$all}/"));
        $pager->pager($users->count(), 15, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE["NAME"] . " - " . CONF_SITE["TITLE"],
            CONF_SITE["DESC"],
            url("admin/users/home"),
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
     * MANAGER USERS
     * @param array|null $data
     * @throws \Exception
     */
    public function user(?array $data): void
    {
        //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $form = [$data["first_name"], $data["last_name"], $data["email"], $data["telephone"], $data["genre"], $data["level"], $data["status"], $data["password"]];
            if (in_array("", $form)) {
                echo Message::ajaxResponse("message", [
                    "type" => "error",
                    "message" => "<i class='icon fas fa-ban'></i> Oops! Os os campos (*) são obrigatórios!"
                ]);
                return;
            }

            $user = new User();
            $user->first_name = $data["first_name"];
            $user->last_name = $data["last_name"];
            $user->email = $data["email"];
            $user->telephone = is_number($data["telephone"]);
            $user->document = is_number($data["document"]);
            $user->genre = $data["genre"];
            $user->level = $data["level"];
            $user->status = $data["status"];
            $user->password = $data["password"];

            if (!$user->save()) {
                echo Message::ajaxResponse("message", [
                    "type" => "error",
                    "message" => $user->fail()->getMessage()
                ]);
                return;
            }

            if($data["send_email"] == 1){

                $password = $data["password"];
                $url = url("/admin");
                $button = "ACESSAR CONTA";
                $subject = "Bem-vindo (a) {$data["first_name"]}! | " . CONF_SITE["NAME"];

                $email = new Email();
                $email->add(
                    "{$subject}",
                    $this->view->render(__DIR__ . "/../../../shared/views/email/admin/newuser", [
                        "user" => $user,
                        "password" => $password,
                        "subject" => $subject,
                        "button" => $button,
                        "url" => $url
                    ]),
                    "{$data["first_name"]} {$data["last_name"]}",
                    $data["email"]
                )->send();
            }

            if (!empty($_FILES["photo"])) {
                $upload = new Image("storage", "users");
                $file = $_FILES["photo"];

                $size = 2048 * 2048 * 2;
                if ($file["size"] > $size) {
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

                if (file_exists(CONF_UPLOAD["STORAGE"] . "/{$user->photo}") && !is_dir(CONF_UPLOAD["STORAGE"] . "/{$user->photo}")) {
                    unlink(CONF_UPLOAD["STORAGE"] . "/{$user->photo}");
                }

                $uploaded = $upload->upload($file, $user->id . "-" . str_slug($user->first_name), 500);
                $photo = substr($uploaded, strrpos($uploaded, "storage/") + 8);
                $user->photo = $photo;
                $user->save();
            }

            flash("success", "<i class='icon fas fa-check'></i> Usuário cadastrado com sucesso!");
            echo Message::ajaxResponse("redirect", [
                "url" => url("admin/users/user/{$user->id}")
            ]);
            return;
        }

        //update
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $user = (new User())->findById("{$data["user_id"]}");
            if (!$user) {
                echo Message::ajaxResponse("message", [
                    "type" => "error",
                    "message" => "<i class='icon fas fa-ban'></i>Oops! Você tentou gerenciar um usuário que não existe!"
                ]);
                return;
            }

            $form = [$data["first_name"], $data["last_name"], $data["email"], $data["telephone"], $data["genre"], $data["level"], $data["status"]];
            if (in_array("", $form)) {
                echo Message::ajaxResponse("message", [
                    "type" => "error",
                    "message" => "<i class='icon fas fa-ban'></i> Oops! Por favor, preencha todos os campos (*) obrigatórios!"
                ]);
                return;
            }

            $user->first_name = $data["first_name"];
            $user->last_name = $data["last_name"];
            $user->email = $data["email"];
            $user->telephone = is_number($data["telephone"]);
            $user->document = is_number($data["document"]);
            $user->level = $data["level"];
            $user->genre = $data["genre"];
            $user->status = $data["status"];

            if (!$user->save()) {
                echo Message::ajaxResponse("message", [
                    "type" => "error",
                    "message" => $user->fail()->getMessage()
                ]);
                return;
            }

            if (!empty($_FILES["photo"])) {
                $upload = new Image("storage", "users");
                $file = $_FILES["photo"];

                $size = 2048 * 2048 * 2;
                if ($file["size"] > $size) {
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

                if (file_exists(CONF_UPLOAD["STORAGE"] . "/{$user->photo}") && !is_dir(CONF_UPLOAD["STORAGE"] . "/{$user->photo}")) {
                    unlink(CONF_UPLOAD["STORAGE"] . "/{$user->photo}");
                }

                $uploaded = $upload->upload($file, $user->id . "-" . str_slug($user->first_name), 500);
                $photo = substr($uploaded, strrpos($uploaded, "storage/") + 8);
                $user->photo = $photo;
                $user->save();
            }

            flash("success", "<i class='icon fas fa-check'></i> Usuário ataualizado com sucesso!");
            echo Message::ajaxResponse("redirect", [
                "url" => url("admin/users/user/{$user->id}")
            ]);
            return;
        }

        //password
        if (!empty($data["action"]) && $data["action"] == "password") {

            $password = [$data["password_at"], $data["password"], $data["password_re"]];
            if (in_array("", $password)) {
                echo Message::ajaxResponse("message", [
                    "type" => "error",
                    "message" => "<i class='icon fas fa-ban'></i> Oops! Preencha todos os campus para continuar!"
                ]);
                return;
            }

            if (!is_passwd($data["password"])){
                echo Message::ajaxResponse("message", [
                    "type" => "alert",
                    "message" => "<i class='icon fas fa-exclamation-triangle'></i> Oops! A senha deve ter entre " . CONF_PASSWD["MIN"] . " e " . CONF_PASSWD["MAX"] . " caracteres!"
                ]);
                return;
            }

            if ($data["password"] != $data["password_re"]) {
                echo Message::ajaxResponse("message", [
                    "type" => "error",
                    "message" => "<i class='icon fas fa-ban'></i> Oops! Você informe 2 senhas diferentes!"
                ]);
                return;
            }

            $user = (new User())->find("id = :id", "id={$data["user_id"]}")->fetch();

            if (!passwd_verify($data["password_at"], $user->password)) {
                echo Message::ajaxResponse("message", [
                    "type" => "error",
                    "message" => "<i class='icon fas fa-ban'></i> Oops! Sua senha atual não conferem!"
                ]);
                return;
            }

            $user->password = $data["password"];
            $user->save();

            echo Message::ajaxResponse("message", [
                "type" => "success",
                "message" => "<i class='icon fas fa-check'></i> Tudo certo, {$user->first_name}! Senha foi alterada com sucesso!",
                "clear" => true
            ]);
            return;
        }

        //address
        if (!empty($data["action"]) && $data["action"] == "address") {

            $form = [$data["zipcode"], $data["street"], $data["number"], $data["district"], $data["city"]];
            if (in_array("", $form)) {
                echo Message::ajaxResponse("message", [
                    "type" => "error",
                    "message" => "<i class='icon fas fa-ban'></i> Oops! Por favor, preencha todos os campos (*) obrigatórios!"
                ]);
                return;
            }

            $addr = (new Address())->find("user_id = :id", "id={$data["user_id"]}")->fetch();
            if(!$addr){
                $addr = new Address();
                $addr->user_id = $data["user_id"];
                $addr->created_at = date("Y-d-m H:i:s");
            }

            $addr->zipcode = is_number($data["zipcode"]);
            $addr->street = mb_convert_case($data["street"], MB_CASE_TITLE);
            $addr->number = $data["number"];
            $addr->complement = (!empty($data["complement"]) ? is_number($data["zipcode"]) : "Não informado");
            $addr->district = mb_convert_case($data["district"], MB_CASE_TITLE);
            $addr->city = mb_convert_case($data["city"], MB_CASE_TITLE);
            $addr->state = mb_convert_case($data["state"], MB_CASE_UPPER);
            $addr->country = (!empty($data["country"]) ? mb_convert_case($data["country"], MB_CASE_TITLE) : "Brasil");
            $addr->save();

            echo Message::ajaxResponse("message", [
                "type" => "success",
                "message" => "<i class='icon fas fa-check'></i> Endereço atualizado com sucesso!",
            ]);
            return;
        }

        $user = null;
        if (!empty($data["user_id"])) {
            $user = (new User())->findById(filter_var($data["user_id"], FILTER_VALIDATE_INT));
        }

        $head = $this->seo->render(
            CONF_SITE["NAME"] . " - " . CONF_SITE["TITLE"],
            CONF_SITE["DESC"],
            url("admin/users/create"),
            asset("/assets/images/logo/logo.png")
        );

        echo $this->view->render("widgets/users/user", [
            "app" => "users/user",
            "head" => $head,
            "user" => $user,
            "blog" => (!empty($user)? (object)["posts" => (new Blog())->find("author=:user","user={$user->id}")->count()] : "")
        ]);
    }

    /**
     * DELETE USERS
     * @param array $data
     */
    public function delete(?array $data): void
    {
        $data = filter_var_array($data, FILTER_VALIDATE_INT);

        $userDelete = (new User())->findById("{$data["user_id"]}");
        if (!$userDelete) {
            flash("error", "<i class='icon fas fa-ban'></i> Oops! Você tentou deletar um usuário que não existe!");
            redirect("admin/users/home");
        }

        if (User::user()->id == $data["user_id"]) {
            flash("error", "<i class='icon fas fa-ban'></i> Oops! Por questões de segurança, o sistema não permite que você remova sua própria conta!");
            redirect("admin/users/home");
        }

        if (file_exists(CONF_UPLOAD["STORAGE"] . "/{$userDelete->photo}") && !is_dir(CONF_UPLOAD["STORAGE"] . "/{$userDelete->photo}")) {
            unlink(CONF_UPLOAD["STORAGE"] . "/{$userDelete->photo}");
        }

        $userDelete->destroy();

        flash("success", "<i class='icon fas fa-check'></i>Usuário foi removido com sucesso!");
        redirect("admin/users/home");
    }
}