<?php

namespace Source\Controllers\Admin;

use CoffeeCode\Uploader\Image;
use Source\Models\User;
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
            $users = (new User())->find("MATCH(first_name, last_name, email) AGAINST(:s)", "s={$search}");
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

            if (!csrf_verify($data['csrf_token'])) {
                echo Message::ajaxResponse("message", [
                    "type" => "alert",
                    "message" => "  
                        <i class='icon fas fa-exclamation-triangle'></i>               
                        Oops! Erro ao enviar o formulário!<br>
                        Por favor, atualize a página e tente novamente!
                    "
                ]);
                return;
            }

            $user = new User();
            $user->first_name = $data["first_name"];
            $user->last_name = $data["last_name"];
            $user->email = $data["email"];
            $user->telephone = preg_replace('/[^0-9]/', '', $data["telephone"]);
            $user->document = preg_replace('/[^0-9]/', '', $data["document"]);
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

                $password =$data["password"];

                $link = url('admin');
                $button = "ACESSAR CONTA";

                $email = new Email();
                $email->add(
                    "Bem-vindo (a) {$data["first_name"]}! | " . CONF_SITE['NAME'],
                    $this->view->render("templates/newuser", [
                        "user" => $user,
                        "password" => $password,
                        "button" => $button,
                        "link" => $link
                    ]),
                    "{$data["first_name"]} {$data["last_name"]}",
                    $data["email"]
                )->send();
            }

            if (!empty($_FILES["photo"])) {
                $upload = new Image("storage", "users");
                $file = $_FILES["photo"];

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

                $uploaded = $upload->upload($file, $user->id . "-" . slug($user->first_name), 500);
                $photo = substr($uploaded, strrpos($uploaded, 'storage/') + 8);
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

            $user = (new User())->findById("{$data["id"]}");

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
                    "message" => "
                        <i class='icon fas fa-ban'></i>
                        Oops! Por favor, preencha todos os campos (*) obrigatórios!
                    "
                ]);
                return;
            }

            if (!csrf_verify($data['csrf_token'])) {
                echo Message::ajaxResponse("message", [
                    "type" => "alert",
                    "message" => "
                        <i class='icon fas fa-exclamation-triangle'></i>                  
                        Oops! Erro ao enviar o formulário!<br>
                        Por favor, atualize a página e tente novamente!
                    "
                ]);
                return;
            }

            $user->first_name = $data["first_name"];
            $user->last_name = $data["last_name"];
            $user->email = $data["email"];
            $user->telephone = preg_replace('/[^0-9]/', '', $data["telephone"]);
            $user->document = preg_replace('/[^0-9]/', '', $data["document"]);
            $user->level = $data["level"];
            $user->genre = $data["genre"];
            $user->status = $data["status"];
            $user->updated_at = date("Y-m-d H:i:s");

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

                $uploaded = $upload->upload($file, $user->id . "-" . slug($user->first_name), 500);
                $photo = substr($uploaded, strrpos($uploaded, 'storage/') + 8);
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

            if (!csrf_verify($data['csrf_token'])) {
                echo Message::ajaxResponse("message", [
                    "type" => "alert",
                    "message" => "  
                        <i class='icon fas fa-exclamation-triangle'></i>              
                        Oops! Erro ao enviar o formulário!<br>
                        Por favor, atualize a página e tente novamente!
                    "
                ]);
                return;
            }

            if (!is_passwd($data["password"])){
                echo Message::ajaxResponse("message", [
                    "type" => "alert",
                    "message" => "
                        <i class='icon fas fa-exclamation-triangle'></i>
                        Oops! A senha deve ter entre " . CONF_PASSWD['MIN'] . " e " . CONF_PASSWD['MAX'] . " caracteres!
                    "
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
                "message" => "
                    <i class='icon fas fa-check'></i> 
                    Tudo certo, {$user->first_name}! Senha foi alterada com sucesso!
                ",
                "clear" => [
                    "clear" => true,
                ],
            ]);
            return;
        }

        $user = null;
        if (!empty($data["id"])) {
            $user = (new User())->findById(filter_var($data["id"], FILTER_VALIDATE_INT));
        }

        $head = $this->seo->render(
            CONF_SITE['NAME'] . " - " . CONF_SITE['TITLE'],
            CONF_SITE['DESC'],
            url('admin/users/create'),
            asset("/assets/images/logo/logo.png")
        );

        echo $this->view->render("widgets/users/user", [
            "app" => "users/user",
            "head" => $head,
            "csrf" => csrf_input(),
            "user" => $user
        ]);
    }

    /**
     * ADMIN USERS DELETE
     * @param array $data
     */
    public function delete($data): void
    {
        $data = filter_var_array($data, FILTER_VALIDATE_INT);

        $userDelete = (new User())->findById("{$data["id"]}");
        if (!$userDelete) {
            flash("error", "
                <i class='icon fas fa-ban'></i>
                Oops! Você tentou deletar um usuário que não existe!
            ");
            redirect("admin/users/home");
        }

        if (User::user()->id == $data['id']) {
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

        flash("success", "<i class='icon fas fa-check'></i>Usuário foi removido com sucesso!");
        redirect("admin/users/home");
    }
}