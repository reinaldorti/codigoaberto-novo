<?php

/**
 * @return \Source\Models\User|null
 */
function user(): ?\Source\Models\User
{
    return \Source\Models\User::user();
}

/**
 * @param string $image
 * @return string
 */
function image(?string $image): ?string
{
    if ($image) {
        return (file_exists(CONF_UPLOAD["STORAGE"] . "/{$image}") && !is_dir(CONF_UPLOAD["STORAGE"] . "/{$image}") ? url() . "/" . CONF_UPLOAD["STORAGE"] . "/{$image}" : asset("assets/images/no_avatar.jpg", CONF_VIEW['ADMIN']));
    }

    return null;
}

/**
 * @param string|null $date
 * @return string|null
 */
function date_fmt(?string $date): ?string
{
    if (!$date) {
        return null;
    }

    if (strpos($date, " ")) {
        $date = explode(" ", $date);
        return implode("-", array_reverse(explode("/", $date[0]))) . " " . $date[1];
    }

    return implode("-", array_reverse(explode("/", $date)));
}

/**
 * @param string $string
 * @param int $limit
 * @param string $pointer
 * @return string
 */
function str_chars(string $string, int $limit, string $pointer = "..."): string
{
    $string = trim(filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS));
    if (mb_strlen($string) <= $limit) {
        return $string;
    }

    $chars = mb_substr($string, 0, mb_strrpos(mb_substr($string, 0, $limit), " "));
    return "{$chars}{$pointer}";
}

/**
 * @param string|null $search
 * @return string
 */
function str_search(?string $search): string
{
    if (!$search) {
        return "all";
    }

    $search = preg_replace("/[^a-z0-9A-Z\@\ ]/", "", $search);
    return (!empty($search) ? $search : "all");
}

/**
 * @param string $string
 * @return string
 */
function slug(string $string): string
{
    $string = filter_var(mb_strtolower($string), FILTER_SANITIZE_STRIPPED);
    $formats = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª';
    $replace = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';

    $slug = str_replace(["-----", "----", "---", "--"], "-",
        str_replace(" ", "-",
            trim(strtr(utf8_decode($string), utf8_decode($formats), $replace))
        )
    );
    return $slug;
}

/**
 * @param string $url
 */
function redirect(string $url): void
{
    header("HTTP/1.1 302 Redirect");
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        header("Location: {$url}");
        exit;
    }

    if (filter_input(INPUT_GET, "route", FILTER_DEFAULT) != $url) {
        $location = url($url);
        header("Location: {$location}");
        exit;
    }
}

/**
 * @param string $path
 * @return string
 */
function url(string $path = null): string
{
    if (filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_STRING) == 'localhost') {
        if ($path) {
            return CONF_URl['TEST'] . "/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
        }
        return CONF_URl['TEST'];
    }

    if ($path) {
        return CONF_URl['BASE'] . "/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
    }

    return CONF_URl['BASE'];
}

/**
 * @param string|null $path
 * @param string $asset
 * @return string
 */
function asset(string $path = null, string $asset = CONF_VIEW['THEME']): string
{
    if (filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_STRING) == 'localhost') {
        if ($path) {
            return CONF_URl['TEST'] . "/themes/{$asset}/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
        }

        return CONF_URl['TEST'] . "/themes/{$asset}";
    }

    if ($path) {
        return CONF_URl['BASE'] . "/themes/{$asset}/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
    }

    return CONF_URl['BASE'] . "/themes/{$asset}";
}

/**
 * @param string|null $type
 * @param string|null $message
 * @return string|null
 */
function flash(string $type = null, string $message = null): ?string
{
    if ($type && $message) {
        $_SESSION["flash"] = [
            "type" => $type,
            "message" => $message
        ];
        return null;
    }

    if (!empty($_SESSION["flash"]) && $flash = $_SESSION["flash"]) {
        unset($_SESSION["flash"]);
        return "<div class=\"message {$flash["type"]}\">{$flash["message"]}</div>";
    }

    return null;
}

/**
 * Executa validação de formato de e-mail.
 * @param STRING $email = Uma conta de e-mail
 * @return BOOL = True para um email válido, ou false
 */
function is_email($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * <b>NewPass:</b> Gera uma nova senha aleatória para um usuário!
 * @param INT $tamanho = Quantidade de caracteres na senha
 * @param BOOL $letters Usar letras maiusculas (ABCDEFGHIJKLMNOPQRSTUVWXYZ)
 * @param BOOL $numbers Usar numeros (1234567890)
 * @param BOOL $symbols Usar simbolos (!@#$%*-')
 */
function new_password($size = 8, $letters = true, $numbers = true, $symbols = true)
{
    $lmin = 'abcdefghijklmnopqrstuvwxyz';
    $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $num = '1234567890';
    $simb = '!@#$%*-';
    $return = '';
    $characters = '';

    $characters .= $lmin;
    if ($letters):
        $characters .= $lmai;
    endif;
    if ($numbers):
        $characters .= $num;
    endif;
    if ($symbols):
        $characters .= $simb;
    endif;

    $len = strlen($characters);
    for ($n = 1; $n <= $size; $n++) {
        $rand = mt_rand(1, $len);
        $return .= $characters[$rand - 1];
    }
    return $return;
}

/**
 * Valida caracteres da senha
 * @param string $password
 * @return bool
 */
function is_passwd($password)
{
    if (password_get_info($password)['algo'] || (mb_strlen($password) >= CONF_PASSWD['MIN'] && mb_strlen($password) <= CONF_PASSWD['MAX'])) {
        return true;
    }

    return false;
}

/**
 * Escrece status
 * @param int|null $data
 */
function status($data = null)
{
    $status = [
        1 => 'Ativo',
        2 => 'Inativo'
    ];

    if (!empty($data)):
        return $status[$data];
    else:
        return $status;
    endif;
}

/**
 * Escrece genero
 * @param int|null $data
 */
function genre($data = null)
{
    $genre = [
        1 => 'Masculino',
        2 => 'Feminino'
    ];

    if (!empty($data)):
        return $genre[$data];
    else:
        return $genre;
    endif;
}

/**
 * Escrece genero
 * @param int|null $data
 */
function level($data = null)
{
    $level = [
        1 => 'Usuário',
        2 => 'Assinante',
        6 => 'Moderador',
        8 => 'Gerente',
        9 => 'Admin',
        10 => 'Super Admin',
    ];

    if (!empty($data)):
        return $level[$data];
    else:
        return $level;
    endif;
}

/**
 * @param string $password
 * @return string
 */
function passwd($password)
{
    if (!empty(password_get_info($password)['algo'])) {
        return $password;
    }

    return password_hash($password, CONF_PASSWD['ALGO'], CONF_PASSWD['OPTION']);
}

/**
 * verifica se a senha é igual
 * @param string $password
 * @param string $hash
 * @return bool
 */
function passwd_verify($password, $hash)
{
    return password_verify($password, $hash);
}

/**
 * @param string $hash
 * @return bool
 */
function passwd_rehash($hash)
{
    return password_needs_rehash($hash, CONF_PASSWD['ALGO'], CONF_PASSWD['OPTION']);
}

/**
 * Gera input de csrf token;
 */
function csrf_input()
{
    $_SESSION['csrf_token'] = md5(uniqid(rand(), true));

    return "<input type='hidden' name='csrf_token' value='{$_SESSION['csrf_token']}'/>";
}

/**
 * Validação do csrf token
 * @param STRING $request = Retorna um csrf_token
 * @return BOOL = True para um csrf_token válido, ou false
 */
function csrf_verify($request)
{
    if (empty($_SESSION['csrf_token'])){
        return false;
    }

    if (empty($request)){
        return false;
    }

    if ($request != $_SESSION['csrf_token']){
        return false;
    }

    return true;
}