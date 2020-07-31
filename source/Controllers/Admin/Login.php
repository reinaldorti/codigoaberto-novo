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
        parent::__construct(__DIR__ . "/../../../themes/" . CONF_VIEW['ADMIN'] . "/");

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
        //login
        if (!empty($data["action"]) && $data["action"] == "login") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $login = [$data["email"], $data["password"]];
            if (in_array("", $login)) {
                echo Message::ajaxResponse("message", [
                    "type" => "error",
                    "message" => "<i class='icon fas fa-ban'></i> Oops! Informe seu e-mail e senha para logar!"
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

            if (!is_email($data["email"])) {
                echo Message::ajaxResponse("message", [
                    "type" => "alert",
                    "message" => "
                    <i class='icon fas fa-exclamation-triangle'></i> Oops! E-email informado não válido!
                "
                ]);
                return;
            }

            if (!is_passwd($data["password"])) {
                echo Message::ajaxResponse("message", [
                    "type" => "alert",
                    "message" => "
                    <i class='icon fas fa-exclamation-triangle'></i>Oops! Sua senha deve ter entre " . CONF_PASSWD['MIN'] . " e " . CONF_PASSWD['MAX'] . " caracteres!
                "
                ]);
                return;
            }

            /** ADMIN CREATED DEFAULT **/
            $userAdmin = (new User())->find("email = :e", "e={$data["email"]}")->count();
            if (!$userAdmin && CONF_MAIL["FROM_EMAIL"] == $data["email"]) {
                $userAdmin = new User();
                $userAdmin->first_name = CONF_MAIL["FROM_NAME"];
                $userAdmin->last_name = CONF_MAIL["FROM_LASTNAME"];
                $userAdmin->email = $data["email"];
                $userAdmin->password = $data["password"];
                $userAdmin->ip = $_SERVER['REMOTE_ADDR'];
                $userAdmin->level = 10;
                $userAdmin->status = 1;
                $userAdmin->genre = 1;
                $userAdmin->save();
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
                    "message" => "
                        <i class='icon fas fa-info'></i>
                        Oops, {$user->first_name}!<br>
                        Você não tem permissão para acessar!<br>
                        Por favor, entre em contato pelo e-mail: " . CONF_MAIL["FROM_EMAIL"] . "!
                    "
                ]);
                return;
            }

            /** MULTIPLO LOGIN **/
            if (CONF_LOGIN["LOGIN"]) {
                $LoginTrue = true;
            } else {
                $LoginCookieFree = filter_input(INPUT_COOKIE, "user_cookie", FILTER_DEFAULT);
                $LoginTimeFree = (!empty($user->user_login) ? $user->user_login + (CONF_LOGIN["LOGIN_BLOCK"] * 60) : 0);

                if (!$user->user_cookie || time() > $LoginTimeFree || ($LoginCookieFree && $LoginCookieFree == $user->user_cookie)) {
                    $login_cookie = hash("sha512", time());
                    $_SESSION['login_cookie'] = $login_cookie;
                    setcookie('login_cookie', $login_cookie, time() + 2592000, '/');

                    $user->lastaccess = date('Y-m-d H:i:s');
                    $user->user_login = time();
                    $user->user_cookie = $login_cookie;
                    $user->save();

                    $LoginTrue = true;
                } else {
                    echo Message::ajaxResponse("message", [
                        "type" => "info",
                        "message" => "
                            <i class='icon fas fa-info'></i>
                            Oops, {$user->first_name}!<br>
                            sua <b>conta já esta conectada por outro dispositivo!</b><br>                       
                            Caso tenha efetuado login em outro dispositivo, você pode conectar por ele agora,
                            ou espere até as " . date("H\hi", $LoginTimeFree + 60) . " para conectar novamente!<br>                  
                        "
                    ]);
                    return;
                }

                /** SESSION USER ID **/
                $_SESSION["user"] = $user->id;

                /** SAVE COOKIE **/
                $Remember = (isset($data['remember']) ? 1 : null);
                if ($Remember) {
                    setcookie('email', $data["email"], time() + 2592000, '/');
                } else {
                    setcookie('email', '', 60, '/');
                }

                /** VERIFY IP **/
                $ip = $_SERVER['REMOTE_ADDR'];

                if ($ip != $user->ip) {
                    $link = url('admin');
                    $button = "ACESSAR CONTA";

                    $message = "
                        <strong style='font-size:17px'>Prezado(a), {$user->first_name}! É importante!</strong> <br>
                        Detectamos um novo acesso á sua conta do " . CONF_SITE['NAME'] . "!
                        Foi efetuado a partir de uma rede de IP ou dispositivo diferente do habitual, confira se foi você:<br><br>
                    
                        <b>IP:</b> {$ip}<br>
                        <b>Data:</b> " . date('d/m/Y H:i:s') . "<br><br>
                    
                        <b>NÃO FOI VOCÊ?</b><br> É importante atualizar sua conta o quanto antes para manter seus dados seguros.<br> Para isso é preciso aterar sua senha.<br><br>
                        <b>FOI VOCÊ?</b><br> Então pode ignorar este e-mail, mas ele sempre será enviado como medida de segurança para que você tenha certeza que está tudo certo com sua conta.<br>
                        Como você sabe, nela existem seus dados pessoais.<br><br>
                                                              
                        <b>DÚVIDAS, CRÍTICAS OU SUGESTÕES?</b> <br>
                        Estamos sempre à disposição para melhor atendê-los! Você sempre pode contar com nossa equipe de suporte!<br><br>
                    
                        <p> — Atenciosamente " . CONF_SITE['NAME'] . "</p>
                    ";

                    $Mail = new Email();
                    $Mail->add(
                        "Tudo certo {$user->first_name}? | " . CONF_SITE['NAME'],
                        $this->view->render("templates/email", [
                            "message" => $message,
                            "button" => $button,
                            "link" => $link
                        ]),
                        "{$user->first_name} {$user->last_name}",
                        $user->email
                    )->send();
                }
            }

            /** SAVE IP **/
            $user->ip = $ip;
            $user->save();

            if ($LoginTrue) {
                echo Message::ajaxResponse("redirect", [
                    "url" => url("admin/dash")
                ]);
                return;
            }
        }

        $email = filter_input(INPUT_COOKIE, 'email', FILTER_VALIDATE_EMAIL);
        $head = $this->seo->render(
            CONF_SITE['NAME'] . " - " . CONF_SITE['TITLE'],
            CONF_SITE['DESC'],
            url('admin'),
            asset("/assets/images/logo/logo.png")
        );

        echo $this->view->render("widgets/login/login", [
            "head" => $head,
            "csrf" => csrf_input(),
            "email" => $email
        ]);
    }

    /**
     * FORGET
     * @param array|null $data
     */
    public function forget(?array $data): void
    {
        //forget
        if (!empty($data["action"]) && $data["action"] == "forget") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $login = [$data["email"]];
            if (in_array("", $login)) {
                echo Message::ajaxResponse("message", [
                    "type" => "error",
                    "message" => "<i class='icon fas fa-ban'></i> Oops! Informe seu e-mail para continuar!"
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

            if (!is_email($data["email"])) {
                echo Message::ajaxResponse("message", [
                    "type" => "alert",
                    "message" => "
                    <i class='icon fas fa-exclamation-triangle'></i>
                    Oops! E-email informado não válido!
                "
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

            if ($user->status == 1) {
                echo Message::ajaxResponse("message", [
                    "type" => "info",
                    "message" => "
                        <i class='icon fas fa-info'></i>
                        Oops, {$user->first_name}!<br>
                        Você não tem permissão de acesso!<br>
                        Por favor, entre em contato pelo e-mail: " . CONF_MAIL["FROM_EMAIL"] . "!
                    "
                ]);
                return;
            }

            $user->forget = (md5(uniqid(rand(), true)));
            $user->save();

            $_SESSION["forget"] = $user->id;

            $link = url("/admin/senha/{$user->email}/{$user->forget}");
            $button = "ALTERAR SENHA";

            $message = "
                <strong style='font-size:17px'>Prezado(a), {$user->first_name}!</strong> <br>
                Recebemos em nosso site uma solicitação para recuperar sua senha.<br><br>               
                                   
                <b>NÃO FOI VOCÊ?</b><br> É importante atualizar sua conta o quanto antes para manter seus dados seguros.
                Para isso é preciso aterar sua senha.<br><br>
                                                                      
                <b>DÚVIDAS, CRÍTICAS OU SUGESTÕES?</b> <br>
                Estamos sempre à disposição para melhor atendê-los! <br>
                Você sempre pode contar com nossa equipe de suporte!<br><br>
            
                <p> — Atenciosamente " . CONF_SITE['NAME'] . "</p>
            ";

            $mail = new Email();
            $mail->add(
                "Recupere sua senha | " . CONF_SITE["NAME"],
                $this->view->render("templates/email", [
                    "message" => $message,
                    "button" => $button,
                    "link" => $link
                ]),
                "{$user->first_name} {$user->last_name}",
                $user->email
            )->send();

            echo Message::ajaxResponse("message", [
                "type" => "success",
                "message" => "<i class='icon fas fa-check'></i> Tudo certo, {$user->first_name}!<br> 
                    Enviamos um link de recuperação para seu e-mail!
                ",
                "clear" => [
                    "clear" => true,
                ],
            ]);
            return;
        }

        $head = $this->seo->render(
            "Recuperar Senha - " . CONF_SITE['NAME'],
            CONF_SITE['DESC'],
            url('admin/recuperar'),
            asset("/assets/images/logo/logo.png")
        );

        echo $this->view->render("widgets/login/forget", [
            "head" => $head,
            "csrf" => csrf_input(),
        ]);
    }

    /**
     * ADMIN TELA RESET
     * @param array $data
     */
    public function reset(?array $data): void
    {
        if (empty($_SESSION["forget"])) {
            flash("info", "<i class='icon fas fa-info'></i> Oops! Informe seu e-mail para continuar!");
            redirect("admin/recuperar");
        }

        //reset
        if (!empty($data["action"]) && $data["action"] == "reset") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            if (in_array("", $data)) {
                echo Message::ajaxResponse("message", [
                    "type" => "error",
                    "message" => "<i class='icon fas fa-ban'></i> Oops! Por favor, preencha todos os campos para continuar!"
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

            if (!is_passwd($data["password"])):
                echo Message::ajaxResponse("message", [
                    "type" => "alert",
                    "message" => "
                        <i class='icon fas fa-exclamation-triangle'></i>
                        Oops! Sua senha deve ter entre " . CONF_PASSWD['MIN'] . " e " . CONF_PASSWD['MAX'] . " caracteres!
                    "
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
                flash("info", "
                    <i class='icon fas fa-info'></i>
                    Oops! Não foi possivel recuperar sua senha! <br>Por favor, tente novamente!
                ");
                echo Message::ajaxResponse("redirect", [
                    "url" => url("admin/recuperar")
                ]);
                return;
            }

            $user->password = $data["password"];
            $user->forget = null;

            if (!$user->save()) {
                echo Message::ajaxResponse("redirect", [
                    "type" => "error",
                    "message" => $user->fail()->getMessage()
                ]);
                return;
            }

            $link = url("/admin");
            $button = "ACESSAR CONTA";

            $message = "
                <strong style='font-size:17px'>Prezado(a), {$user->first_name}! Tudo certo?</strong> <br>
                Sua senha foi redefinida com sucesso em nosso site!<br><br> 
                
                <b>IP:</b> " . $_SERVER['REMOTE_ADDR'] . " <br/>
                <b>Data:</b> ". date('d/m/Y H:i:s') . "<br/><br/>              
                                   
                <b>NÃO FOI VOCÊ?</b><br> É importante atualizar sua conta o quanto antes para manter seus dados seguros.<br><br>
                                                                      
                <b>DÚVIDAS, CRÍTICAS OU SUGESTÕES?</b> <br>
                Estamos sempre à disposição para melhor atendê-los! <br>
                Você sempre pode contar com nossa equipe de suporte!<br><br>
            
                <p> — Atenciosamente " . CONF_SITE['NAME'] . "</p>
            ";

            $mail = new Email();
            $mail->add(
                "Tudo certo {$user->first_name}! | " . CONF_SITE['NAME'],
                $this->view->render("templates/email", [
                    "message" => $message,
                    "button" => $button,
                    "link" => $link
                ]),
                "{$user->first_name} {$user->last_name}",
                $user->email
            )->send();

            unset($_SESSION["forget"]);

            flash("success", "
                <i class='icon fas fa-check'></i>
                Pronto, {$user->first_name}! <br> Sua senha foi atualizada com sucesso!
            ");
            echo Message::ajaxResponse("redirect", [
                "url" => url("admin")
            ]);
            return;
        }

        $email = filter_var($data["email"], FILTER_VALIDATE_EMAIL);
        $forget = filter_var($data["forget"], FILTER_DEFAULT);
        if (!$email || !$forget) {
            flash("info", "
                <i class='icon fas fa-info'></i>
                Oops! Não foi possivel recuperar sua senha! <br>
                Por favor, tente novamente!
            ");
            redirect("admin/recuperar");
        }

        $user = (new User())->find("email = :e AND forget = :f", "e={$email}&f={$forget}")->fetch();
        if (!$user) {
            flash("info", "
                <i class='icon fas fa-info'></i> Oops! Usuário não encontrado! <br>Por favor, tente novamente!
            ");
            redirect("admin/recuperar");
        }

        $head = $this->seo->render(
            CONF_SITE['NAME'] . " - " . CONF_SITE['TITLE'],
            CONF_SITE['DESC'],
            url('admin/senha'),
            asset("/assets/images/logo/logo.png")
        );

        echo $this->view->render("widgets/login/reset", [
            "head" => $head,
            "csrf" => csrf_input(),
        ]);
    }
}