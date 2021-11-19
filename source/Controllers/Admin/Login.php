<?php

namespace Source\Controllers\Admin;

use Source\Controllers\Controller;
use Source\Models\User;
use Source\Support\Email;
use Source\Support\Message;

/**
 * Class Login
 * @package Source\Controllers\Admin
 */
class Login extends Controller
{
    /**
     * Login constructor.
     */
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../../../public/" . CONF_VIEW["ADMIN"] . "/");

        if (!empty($_SESSION["user"])) {
            redirect("/admin/dash");
        }
    }

    /**
     * LOGIN
     * @param array|null $data
     */
    public function login(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        //login
        if (!empty($data["action"]) && $data["action"] == "login") {

            $login = [$data["email"], $data["password"]];
            if (in_array("", $login)) {
                echo Message::ajaxResponse("message", [
                    "type" => "error",
                    "message" => "<i class='icon fas fa-ban'></i> Oops! Informe seu e-mail e senha para logar!"
                ]);
                return;
            }

            if (!is_email($data["email"])) {
                echo Message::ajaxResponse("message", [
                    "type" => "alert",
                    "message" => "<i class='icon fas fa-exclamation-triangle'></i> Oops! E-email informado não é válido!"
                ]);
                return;
            }

            if (!is_passwd($data["password"])) {
                echo Message::ajaxResponse("message", [
                    "type" => "alert",
                    "message" => "<i class='icon fas fa-exclamation-triangle'></i>Oops! Sua senha deve ter entre " . CONF_PASSWD["MIN"] . " e " . CONF_PASSWD["MAX"] . " caracteres!"
                ]);
                return;
            }

            /** ADMIN CREATED DEFAULT **/
            $admin = (new User())->find("email = :e", "e={$data["email"]}")->count();
            if (!$admin && CONF_MAIL["FROM_EMAIL"] == $data["email"]) {
                $admin = new User();
                $admin->first_name = CONF_MAIL["FROM_NAME"];
                $admin->last_name = CONF_MAIL["FROM_LASTNAME"];
                $admin->document = CONF_MAIL["FROM_DOCUMENT"];
                $admin->email = $data["email"];
                $admin->password = $data["password"];
                $admin->ip = $_SERVER["REMOTE_ADDR"];
                $admin->level = 10;
                $admin->status = 1;
                $admin->genre = 1;
                $admin->save();
            }

            $user = (new User())->find("email = :e", "e={$data["email"]}")->fetch();
            if (!$user) {
                echo Message::ajaxResponse("message", [
                    "type" => "error",
                    "message" => "<i class='icon fas fa-ban'></i> Oops! Esse e-mail não está cadastrado!"
                ]);
                return;
            }

            if (!passwd_verify($data["password"], $user->password)) {
                echo Message::ajaxResponse("message", [
                    "type" => "error",
                    "message" => "<i class='icon fas fa-ban'></i> Oops! Sua senha não conferem!"
                ]);
                return;
            }

            if (passwd_rehash($user->password)):
                $user->password = $data["password"];
                $user->updated_at = date("Y-m-d H:i:s");
                $user->save();
            endif;

            if ($user->status != 1) {
                echo Message::ajaxResponse("message", [
                    "type" => "info",
                    "message" => "<i class='icon fas fa-info'></i> Oops, {$user->first_name}! Você não tem permissão para acessar! Por favor, entre em contato pelo e-mail: " . CONF_MAIL["FROM_EMAIL"] . "!"
                ]);
                return;
            }

            /** MULTIPLO LOGIN **/
            if (CONF_LOGIN["MULTIPLE"]) {
                $LoginTrue = true;
            } else {

                $LoginCookieFree = filter_input(INPUT_COOKIE, "user_cookie", FILTER_DEFAULT);
                $LoginTimeFree = (!empty($user->user_login) ? $user->user_login + (CONF_LOGIN["BLOCK"] * 60) : 0);

                if (!$user->user_cookie || time() > $LoginTimeFree || ($LoginCookieFree && $LoginCookieFree == $user->user_cookie)) {
                    $login_cookie = hash("sha512", time());
                    $_SESSION["login_cookie"] = $login_cookie;
                    setcookie("login_cookie", $login_cookie, time() + 2592000, "/");

                    $user->lastaccess = date("Y-m-d H:i:s");
                    $user->user_login = time();
                    $user->user_cookie = $login_cookie;
                    $user->save();

                    $LoginTrue = true;
                } else {
                    echo Message::ajaxResponse("message", [
                        "type" => "info",
                        "message" => "<i class='icon fas fa-info'></i> Oops, {$user->first_name}! sua <b>conta já esta conectada por outro dispositivo!</b> Caso tenha efetuado login em outro dispositivo, você pode conectar por ele agora, ou espere até as " . date("H\hi", $LoginTimeFree + 60) . " para conectar novamente!"
                    ]);
                    return;
                }
            }

            /** SAVE COOKIE **/
            $Remember = (isset($data["remember"]) ? 1 : null);
            if ($Remember) {
                setcookie("email", $data["email"], time() + 2592000, "/");
            } else {
                setcookie("email", "", 60, "/");
            }

            /** VERIFY IP **/
            $ip = $_SERVER["REMOTE_ADDR"];

            if ($ip != $user->ip) {
                $url = url("/admin");
                $button = "ACESSAR CONTA";
                $subject = "Tudo certo {$user->first_name}? | " . CONF_SITE["NAME"];

                $Mail = new Email();
                $Mail->add(
                    $subject,
                    $this->view->render(__DIR__ . "/../../../shared/views/email/admin/login", [
                        "user" => $user,
                        "ip" => $ip,
                        "subject" => $subject,
                        "button" => $button,
                        "url" => $url
                    ]),
                    "{$user->first_name} {$user->last_name}",
                    $user->email
                )->send();
            }

            /** SESSION USER ID **/
            $_SESSION["user"] = $user->id;

            /** SAVE IP **/
            $user->ip = $_SERVER["REMOTE_ADDR"];
            //$user->save();

            if ($LoginTrue) {
                echo Message::ajaxResponse("redirect", [
                    "url" => url("admin/dash")
                ]);
                return;
            }
        }

        $email = filter_input(INPUT_COOKIE, "email", FILTER_VALIDATE_EMAIL);
        $head = $this->seo->render(
            CONF_SITE["NAME"] . " - " . CONF_SITE["TITLE"],
            CONF_SITE["DESC"],
            url("admin"),
            asset("/assets/images/logo/logo.png")
        );

        echo $this->view->render("widgets/login/login", [
            "head" => $head,
            "email" => $email
        ]);
    }

    /**
     * FORGET
     * @param array|null $data
     */
    public function forget(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        //forget
        if (!empty($data["action"]) && $data["action"] == "forget") {

            $login = [$data["email"]];
            if (in_array("", $login)) {
                echo Message::ajaxResponse("message", [
                    "type" => "error",
                    "message" => "<i class='icon fas fa-ban'></i> Oops! Informe seu e-mail para continuar!"
                ]);
                return;
            }

            if (!is_email($data["email"])) {
                echo Message::ajaxResponse("message", [
                    "type" => "alert",
                    "message" => "<i class='icon fas fa-exclamation-triangle'></i> Oops! E-email informado não válido!"
                ]);
                return;
            }

            $user = (new User())->find("email = :e", "e={$data["email"]}")->fetch();
            if (!$user) {
                echo Message::ajaxResponse("message", [
                    "type" => "error",
                    "message" => "<i class='icon fas fa-ban'></i> Oops! Esse e-mail não está cadastrado!"
                ]);
                return;
            }

            if ($user->status != 1) {
                echo Message::ajaxResponse("message", [
                    "type" => "info",
                    "message" => "<i class='icon fas fa-info'></i> Oops, {$user->first_name}! Você não tem permissão de acesso! Por favor, entre em contato pelo e-mail: " . CONF_MAIL["FROM_EMAIL"] . "!"
                ]);
                return;
            }

            $user->forget = (md5(uniqid(rand(), true)));
            $user->save();

            $_SESSION["forget"] = $user->id;

            $url = url("/admin/senha/{$user->email}/{$user->forget}");
            $button = "ALTERAR SENHA";
            $subject = "Recupere sua senha | " . CONF_SITE["NAME"];

            $mail = new Email();
            $mail->add(
                $subject,
                $this->view->render(__DIR__ . "/../../../shared/views/email/admin/forget", [
                    "subject" => $subject,
                    "button" => $button,
                    "url" => $url,
                    "user" => $user
                ]),
                "{$user->first_name} {$user->last_name}",
                "{$user->email}"
            )->send();

            echo Message::ajaxResponse("message", [
                "type" => "success",
                "message" => "<i class='icon fas fa-check'></i> Tudo certo, {$user->first_name}! Enviamos um link de recuperação para seu e-mail!",
                "clear" => true
            ]);
            return;
        }

        $head = $this->seo->render(
            "Recuperar Senha - " . CONF_SITE["NAME"],
            CONF_SITE["DESC"],
            url("admin/recuperar"),
            asset("/assets/images/logo/logo.png")
        );

        echo $this->view->render("widgets/login/forget", [
            "head" => $head
        ]);
    }

    /**
     * VIEW RESET
     * @param array $data
     */
    public function reset(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        if (empty($_SESSION["forget"])) {
            flash("info", "<i class='icon fas fa-info'></i> Oops! Informe seu e-mail para continuar!");
            redirect("admin/recuperar");
        }

        //reset
        if (!empty($data["action"]) && $data["action"] == "reset") {

            if (in_array("", $data)) {
                echo Message::ajaxResponse("message", [
                    "type" => "error",
                    "message" => "<i class='icon fas fa-ban'></i> Oops! Por favor, preencha todos os campos para continuar!"
                ]);
                return;
            }

            if (!is_passwd($data["password"])):
                echo Message::ajaxResponse("message", [
                    "type" => "alert",
                    "message" => "<i class='icon fas fa-exclamation-triangle'></i> Oops! Sua senha deve ter entre " . CONF_PASSWD["MIN"] . " e " . CONF_PASSWD["MAX"] . " caracteres!"
                ]);
                return;
            endif;

            if ($data["password"] != $data["password_re"]) {
                echo Message::ajaxResponse("message", [
                    "type" => "error",
                    "message" => "<i class='icon fas fa-ban'></i> Oops! Você informe 2 senhas diferentes!"
                ]);
                return;
            }

            if (empty($_SESSION["forget"]) || !$user = (new User())->findById("{$_SESSION["forget"]}")) {
                flash("info", "<i class='icon fas fa-info'></i> Oops! Não foi possivel recuperar sua senha! <br>Por favor, tente novamente!");
                echo Message::ajaxResponse("redirect", [
                    "url" => url("admin/recuperar")
                ]);
                return;
            }

            $ip = $_SERVER["REMOTE_ADDR"];
            $user->password = $data["password"];
            $user->ip = $ip;
            $user->forget = null;
            $user->user_login = null;
            $user->user_cookie = null;

            if (!$user->save()) {
                echo Message::ajaxResponse("redirect", [
                    "type" => "error",
                    "message" => $user->fail()->getMessage()
                ]);
                return;
            }

            $url = url("/admin");
            $button = "ACESSAR CONTA";
            $subject = "Tudo certo {$user->first_name}! | " . CONF_SITE["NAME"];

            $mail = new Email();
            $mail->add(
                "{$subject}",
                $this->view->render(__DIR__ . "/../../../shared/views/email/admin/reset", [
                    "subject" => $subject,
                    "button" => $button,
                    "url" => $url,
                    "ip" => $ip,
                    "user" => $user
                ]),
                "{$user->first_name} {$user->last_name}",
                "{$user->email}"
            )->send();

            unset($_SESSION["forget"]);

            flash("success", "<i class='icon fas fa-check'></i> Pronto, {$user->first_name}! <br> Sua senha foi atualizada com sucesso!");
            echo Message::ajaxResponse("redirect", [
                "url" => url("admin")
            ]);
            return;
        }

        $email = filter_var($data["email"], FILTER_VALIDATE_EMAIL);
        $forget = filter_var($data["forget"], FILTER_DEFAULT);
        if (!$email || !$forget) {
            flash("info", "<i class='icon fas fa-info'></i>Oops! Não foi possivel recuperar sua senha! Por favor, tente novamente!");
            redirect("admin/recuperar");
        }

        $user = (new User())->find("email = :e AND forget = :f", "e={$email}&f={$forget}")->fetch();
        if (!$user) {
            flash("info", "<i class='icon fas fa-info'></i> Oops! Usuário não encontrado! <br>Por favor, tente novamente!");
            redirect("admin/recuperar");
        }

        $head = $this->seo->render(
            CONF_SITE["NAME"] . " - " . CONF_SITE["TITLE"],
            CONF_SITE["DESC"],
            url("admin/senha"),
            asset("/assets/images/logo/logo.png")
        );

        echo $this->view->render("widgets/login/reset", [
            "head" => $head
        ]);
    }
}