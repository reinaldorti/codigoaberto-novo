<?php

// DATABASE CONNECT
if (strpos($_SERVER['HTTP_HOST'], "localhost")) {
    define("DATA_LAYER_CONFIG", [
        "driver" => "mysql",
        "host" => "localhost",
        "port" => "3306",
        "dbname" => "codigoaberto",
        "username" => "root",
        "passwd" => "",
        "options" => [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_CASE => PDO::CASE_NATURAL
        ]
    ]);
} else {
    define("DATA_LAYER_CONFIG", [
        "driver" => "mysql",
        "host" => "localhost",
        "port" => "3306",
        "dbname" => "banco_online",
        "username" => "username_online",
        "passwd" => "passowrd_online",
        "options" => [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_CASE => PDO::CASE_NATURAL
        ]
    ]);
}

// COOKIE POLICY
define("COOKIEPOLICY", filter_input(INPUT_COOKIE, "cookiePolicy", FILTER_SANITIZE_STRIPPED));

// VIEW
define("CONF_VIEW", [
    "PATH" => __DIR__ . "/../../shared",
    "EXT" => "php",
    "THEME" => "anipat",
    "ADMIN" => "admin",
]);

// PROJECT URLs
define("CONF_URl", [
    "TEST" => "https://www.localhost/codigoaberto",
    "BASE" => "https://www.seudominio.com.br"
]);

// PASSWORD
define("CONF_PASSWD", [
    "MIN" => 6,
    "MAX" => 40,
    "ALGO" => PASSWORD_DEFAULT,
    "OPTION" => ["cost" => 8],
]);

// MULTIPLO LOGIN
define("CONF_LOGIN", [
    "MULTIPLE" => 1,
    "BLOCK" => 60
]);

// SITE
define("CONF_SITE", [
    "NAME" => "Código aberto - Auth em MVC com php",
    "TITLE" => "Código aberto - Auth em MVC com php",
    "DESC" => "Aprenda a construir uma plicação de autenticação em MVC com php do Jeito Certo",
    "LANG" => "pt_BR",
    "DOMAIN" => "www.ra3.ao",
    "ADDR_STREET" => "Projecto Nova Vida ",
    "ADDR_NUMBER" => "14",
    "ADDR_DISTRICT" => "Belas",
    "ADDR_COMPLEMENT" => "Casa",
    "ADDR_CITY" => "Luanda",
    "ADDR_STATE" => "LA",
    "ADDR_ZIPCODE" => "244",
    "ADDR_TELEPHONE" => "991696254",
    "ADDR_WHATSAPP" => "929667246",
    "ADDR_CODE" => "244"
]);

// SOCIAL
define("CONF_SOCIAL", [
    "TWITTER_CREATOR" => "@creator",
    "TWITTER_PUBLISHER" => "@creator",
    "TWITTER_PAGE" => "https://twitter.com/home",
    "FACEBOOK_APP" => "https://www.facebook.com/reinaldorti",
    "FACEBOOK_PAGE" => "https://www.facebook.com/reinaldorti",
    "FACEBOOK_AUTHOR" => "https://www.facebook.com/reinaldorti",
    "LINKDIN_PAGE" => "https://www.linkedin.com/in/reinaldo-dorti-1a17a0198",
    "GOOGLE_PAGE" => "https://www.facebook.com/reinaldorti",
    "GOOGLE_AUTHOR" => "https://www.facebook.com/reinaldorti",
    "INSTAGRAM_PAGE" => "https://www.instagram.com/reinaldodorti",
    "YOUTUBE_PAGE" => "https://www.youtube.com/channel/UCfB0XRFZgoCFSi0wNYebUFA"
]);

// UPLOAD
define("CONF_UPLOAD", [
    "STORAGE" => "storage",
    "IMAGES" => "images",
    "CACHE" => "cache",
    "FILES" => "files",
    "MEDIAS" => "medias",
]);

// EMAIL CONNECT
define("CONF_MAIL", [
    "HOST" => "smtp.sendgrid.net",
    "PORT" => "587",
    "USER" => "apikey",
    "PASSWD" => "**********",
    "MODE" => "tls",
    "FROM_NAME" => "Revista APosta",
    "FROM_LASTNAME" => "Revista Aposta",
    "FROM_EMAIL" => "info@ra3.ao",
    "FROM_DOCUMENT_NIF" => "5454510217",
    "FROM_TELEPHONE" => "+55 (99) 99999-9999",
    "FROM_WHATSAPP" => "5599999999999",
    "SENDER", ["name" => "Robson V. Leite", "address" => "email@email.com"],
    "SUPPORT" => "email@email.com",
    "LANG" => "br",
    "HTML" => true,
    "AUTH" => true,
    "SECURE" => "tls",
    "CHARSET" => "utf-8",
]);

// SOCIAL LOGIN: FACEBOOK
define("FACEBOOK_LOGIN", [
    "clientId" => "",
    "clientSecret" => "",
    "redirectUri" => CONF_URl["TEST"] . "/facebook",
    "graphApiVersion" => "v4.0"
]);

// SOCIAL LOGIN: GOOGLE
define("GOOGLE_LOGIN", [
    "clientId" => "",
    "clientSecret" => "",
    "redirectUri" => CONF_URl["TEST"] . "/google"
]);

// GOOGLE RECAPTCHA
define("CONF_GOOGLE_RECAPTCHA", [
    "SITE" => "",
    "SERET" => ""
]);

/**
 * ALERTS
 */
define("CONF_ALERT_MESSAGE", "alert");
define("CONF_ALERT_SUCCESS", ["class" => "alert-success", "icon" => "fas fa-fw fa-check-circle"]);
define("CONF_ALERT_DANGER", ["class" => "alert-danger", "icon" => "fas fa-fw fa-times-circle"]);
define("CONF_ALERT_WARNING", ["class" => "alert-warning", "icon" => "fas fa-fw fa-exclamation-circle"]);
define("CONF_ALERT_INFO", ["class" => "alert-info", "icon" => "fas fa-fw fa-info-circle"]);

/**
 * IMAGES
 */
define("CONF_IMAGE_DEFAULT_AVATAR", "/assets/images/webp/default-avatar.webp");
define("CONF_IMAGE_NO_AVAILABLE_1BY1", "/assets/images/webp/no-image-available-1by1.webp");
define("CONF_IMAGE_NO_AVAILABLE_16BY9", "/assets/images/webp/no-image-available-16by9.webp");