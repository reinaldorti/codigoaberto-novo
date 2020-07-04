<?php
ob_start();
session_start();

require __DIR__ . "/vendor/autoload.php";

/**
 * BOOTSTRAP
 */

use CoffeeCode\Router\Router;

$router = new Router(url(), ":");
$router->namespace("Source\Controllers");

/**
 * WEB ROUTES
 */
$router->group(null);
$router->get("/", "Web:home");
$router->get("/sobre", "Web:about");
$router->get("/contato", "Web:contact");
$router->post("/contato", "Web:contact");
$router->get("/banco", "Web:database");

//blog
$router->group("/blog");
$router->get("/", "Web:blog","web.blog");

/**
 * ADMIN ROUTES
 */
$router->namespace("Source\Controllers\Admin");
$router->group("/admin");

//login
$router->get("/", "Login:login");
$router->post("/login", "Login:login");
$router->get("/recuperar", "Login:forget");
$router->post("/forget", "Login:forget");
$router->get("/senha/{email}/{forget}", "Login:reset");
$router->post("/reset", "Login:reset");

//dash
$router->get("/dash", "Dash:home");
$router->post("/dash", "Dash:dashboard");
$router->get("/dash/sair", "Dash:logoff");

//users
$router->get("/users/home", "Users:home");
$router->post("/users/home", "Users:home");
$router->get("/users/home/{search}/{page}", "Users:home");
$router->get("/users/user", "Users:user");
$router->post("/users/user", "Users:user");
$router->get("/users/user/{user_id}", "Users:user");
$router->post("/users/user/{user_id}", "Users:user");
$router->get("/users/delete/{user_id}", "Users:delete");
$router->post("/users/address/{user_id}", "Address:address");

//blog
$router->get("/blog/home", "Blog:home");
$router->post("/blog/home", "Blog:home");
$router->get("/blog/post", "Blog:post");
$router->post("/blog/post", "Blog:post");
$router->get("/blog/post/{post_id}", "Blog:post");
$router->post("/blog/post/{post_id}", "Blog:post");
$router->get("/blog/home/{search}/{page}", "Blog:home");
$router->get("/blog/delete/{id}", "Blog:delete");

//END ADMIN
$router->namespace("Source\Controllers");

/**
 * ERROR ROUTES
 */
$router->group("/ops");
$router->get("/{errcode}", "Web:error");

/**
 * ROUTE
 */
$router->dispatch();

/**
 * ERROR REDIRECT
 */
if ($router->error()) {
    $router->redirect("/ops/{$router->error()}");
}

ob_flush();