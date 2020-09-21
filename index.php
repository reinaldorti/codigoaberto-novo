<?php
ob_start();
session_start();

require __DIR__ . "/vendor/autoload.php";

use CoffeeCode\Router\Router;

$router = new Router(url(), ":");
$router->namespace("Source\Controllers");

//WEB ROUTES
$router->group(null);
$router->get("/", "Web:home");
$router->get("/sobre", "Web:about");
$router->get("/contato", "Web:contact");
$router->post("/contato", "Web:contact");

//BLOG
$router->group("/blog");
$router->get("/", "Web:posts");
$router->get("/{uri}", "Web:post");

//ADMIN ROUTES
$router->namespace("Source\Controllers\Admin");
$router->group("/admin");

//LOGIN
$router->get("/", "Login:login");
$router->post("/login", "Login:login");
$router->get("/recuperar", "Login:forget");
$router->post("/forget", "Login:forget");
$router->get("/senha/{email}/{forget}", "Login:reset");
$router->post("/reset", "Login:reset");

//DASHBOARD
$router->get("/dash", "Dash:home");
$router->post("/dash", "Dash:dashboard");
$router->get("/dash/sair", "Dash:logoff");

//USERS
$router->get("/users/home", "Users:home");
$router->post("/users/home", "Users:home");
$router->get("/users/home/{search}/{page}", "Users:home");
$router->get("/users/user", "Users:user");
$router->post("/users/user", "Users:user");
$router->get("/users/user/{id}", "Users:user");
$router->post("/users/user/{id}", "Users:user");
$router->get("/users/delete/{id}", "Users:delete");
$router->post("/users/address/{id}", "Address:address");

//POSTS
$router->get("/posts/home", "Posts:home");
$router->post("/posts/home", "Posts:home");
$router->get("/posts/post", "Posts:post");
$router->post("/posts/post", "Posts:post");
$router->get("/posts/post/{id}", "Posts:post");
$router->post("/posts/post/{id}", "Posts:post");
$router->get("/posts/home/{search}/{page}", "Posts:home");
$router->get("/posts/delete/{id}", "Posts:delete");

//END ADMIN
$router->namespace("Source\Controllers");

//ERROR ROUTES
$router->group("/ops");
$router->get("/{errcode}", "Web:error");

//ROUTE
$router->dispatch();

//ERROR REDIRECT
if ($router->error()) {
    $router->redirect("/ops/{$router->error()}");
}

ob_flush();

if (!file_exists('.htaccess')) {
    $htaccesswrite = "RewriteEngine On\r\nOptions All -Indexes\r\n\r\n# WWW Redirect.\r\n#RewriteCond %{HTTP_HOST} !^www\. [NC]\r\n#RewriteRule ^ https://www.%{HTTP_HOST}%{REQUEST_URI} [L,R=301]\r\n\r\n# HTTPS Redirect\r\nRewriteCond %{HTTP:X-Forwarded-Proto} !https\r\nRewriteCond %{HTTPS} off\r\nRewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]\r\n\r\n# URL Rewrite\r\nRewriteCond %{SCRIPT_FILENAME} !-f\r\nRewriteCond %{SCRIPT_FILENAME} !-d\r\nRewriteRule ^(.*)$ index.php?route=/$1";
    $htaccess = fopen('.htaccess', "w");
    fwrite($htaccess, str_replace("'", '"', $htaccesswrite));
    fclose($htaccess);
}