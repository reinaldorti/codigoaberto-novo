<?php
ob_start();
session_start();

require __DIR__ . "/vendor/autoload.php";

use CoffeeCode\Router\Router;

$router = new Router(url(), ":");
$router->namespace("Source\Controllers");

//WEB ROUTES
$router->group(null);
$router->get("/", "Web:home", "web.home");
$router->get("/sobre", "Web:about", "web.about");
$router->get("/contato", "Web:contact", "web.contact");
$router->post("/contato", "Web:contact", "web.contact");
$router->post("/cookie", "Web:cookiePolicy", "web.cookie.policy");

//BLOG
$router->group("/blog");
$router->get("/", "Web:posts", "web.blog");
$router->post("/buscar", "Web:postSearch");
$router->get("/buscar/{search}/{page}", "Web:postSearch");
$router->get("/{uri}", "Web:post");
$router->get("/tag/{tag}", "Web:tag");

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

//SLIDES
$router->get("/slides/home", "Slides:home");
$router->post("/slides/home", "Slides:home");
$router->get("/slides/slide", "Slides:slide");
$router->post("/slides/slide", "Slides:slide");
$router->get("/slides/slide/{id}", "Slides:slide");
$router->post("/slides/slide/{id}", "Slides:slide");
$router->get("/slides/home/{search}/{page}", "Slides:home");
$router->get("/slides/delete/{id}", "Slides:delete");

//POSTS
$router->get("/posts/home", "Posts:home");
$router->post("/posts/home", "Posts:home");
$router->get("/posts/post", "Posts:post");
$router->post("/posts/post", "Posts:post");
$router->get("/posts/post/{id}", "Posts:post");
$router->post("/posts/post/{id}", "Posts:post");
$router->get("/posts/home/{search}/{page}", "Posts:home");
$router->get("/posts/delete/{id}", "Posts:delete");

//TESTIMONY
$router->get("/testimony/home", "Testimony:home");
$router->post("/testimony/home", "Testimony:home");
$router->get("/testimony/testimony", "Testimony:testimony");
$router->post("/testimony/testimony", "Testimony:testimony");
$router->get("/testimony/testimony/{id}", "Testimony:testimony");
$router->post("/testimony/testimony/{id}", "Testimony:testimony");
$router->get("/testimony/home/{search}/{page}", "Testimony:home");
$router->get("/testimony/delete/{id}", "Testimony:delete");

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

if (!file_exists('.htaccess')) {
    $htaccesswrite = "RewriteEngine On\r\nOptions All -Indexes\r\n\r\n# WWW Redirect.\r\nRewriteCond %{HTTP_HOST} !^www\. [NC]\r\nRewriteRule ^ https://www.%{HTTP_HOST}%{REQUEST_URI} [L,R=301]\r\n\r\n# HTTPS Redirect\r\nRewriteCond %{HTTP:X-Forwarded-Proto} !https\r\nRewriteCond %{HTTPS} off\r\nRewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]\r\n\r\n# URL Rewrite\r\nRewriteCond %{SCRIPT_FILENAME} !-f\r\nRewriteCond %{SCRIPT_FILENAME} !-d\r\nRewriteRule ^(.*)$ index.php?route=/$1";
    $htaccess = fopen('.htaccess', "w");
    fwrite($htaccess, str_replace("'", '"', $htaccesswrite));
    fclose($htaccess);
}

ob_flush();