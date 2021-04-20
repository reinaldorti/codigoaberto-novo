<?php
ob_start();
session_start();

require __DIR__ . "/vendor/autoload.php";

if (!strpos($_SERVER['HTTP_HOST'], "localhost")) {
    //SITEMAP GENERATE (1X DAY)
    $SiteMapCheck = fopen('sitemap.txt', "a+");
    $SiteMapCheckDate = fgets($SiteMapCheck);
    if ($SiteMapCheckDate != date('Y-m-d')) {
        $SiteMapCheck = fopen('sitemap.txt', "w");
        fwrite($SiteMapCheck, date('Y-m-d'));
        fclose($SiteMapCheck);

        $SiteMap = new \Source\Support\Sitemap();
        $SiteMap->exeSitemap(1);
    }
}

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
$router->get("/", "Web:blog", "web.blog");
$router->post("/buscar", "Web:blogSearch");
$router->get("/buscar/{search}/{page}", "Web:blogSearch");
$router->get("/{uri}", "Web:blogPost");
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
$router->get("/dash", "Dash:home", "dash.home");
$router->get("/logoff", "Dash:logoff", "dash.logoff");

//redirect user login
$router->post("/dash", "Admin:dashboard");

//USERS
$router->get("/users/home", "Users:home");
$router->post("/users/home", "Users:home");
$router->get("/users/home/{search}/{page}", "Users:home");
$router->get("/users/user", "Users:user");
$router->post("/users/user", "Users:user");
$router->get("/users/user/{user_id}", "Users:user");
$router->post("/users/user/{user_id}", "Users:user");
$router->get("/users/delete/{user_id}", "Users:delete");

//ABOUT
$router->get("/about/home", "About:home");
$router->post("/about/home", "About:home");
$router->get("/about/home/{search}/{page}", "About:home");
$router->get("/about/about", "About:about");
$router->post("/about/about", "About:about");
$router->get("/about/about/{about_id}", "About:about");
$router->post("/about/about/{about_id}", "About:about");
$router->get("/about/delete/{about_id}", "About:delete");

//SLIDES
$router->get("/slides/home", "Slides:home");
$router->post("/slides/home", "Slides:home");
$router->get("/slides/home/{search}/{page}", "Slides:home");
$router->get("/slides/slide", "Slides:slide");
$router->post("/slides/slide", "Slides:slide");
$router->get("/slides/slide/{slide_id}", "Slides:slide");
$router->post("/slides/slide/{slide_id}", "Slides:slide");
$router->get("/slides/delete/{slide_id}", "Slides:delete");
$router->post("/slides/order", "Slides:SlideOrder");

//BLOG
$router->get("/blog/home", "Blog:home");
$router->post("/blog/home", "Blog:home");
$router->get("/blog/home/{search}/{page}", "Blog:home");
$router->get("/blog/blog", "Blog:blog");
$router->post("/blog/blog", "Blog:blog");
$router->get("/blog/blog/{post_id}", "Blog:blog");
$router->post("/blog/blog/{post_id}", "Blog:blog");
$router->get("/blog/delete/{post_id}", "Blog:delete");
$router->get("/blog/gallery/{post_id}", "Blog:GalleryDelete");

//TESTIMONY
$router->get("/testimony/home", "Testimonys:home");
$router->post("/testimony/home", "Testimonys:home");
$router->get("/testimony/home/{search}/{page}", "Testimonys:home");
$router->get("/testimony/testimony", "Testimonys:testimony");
$router->post("/testimony/testimony", "Testimonys:testimony");
$router->get("/testimony/testimony/{testimony_id}", "Testimonys:testimony");
$router->post("/testimony/testimony/{testimony_id}", "Testimonys:testimony");
$router->get("/testimony/delete/{testimony_id}", "Testimonys:delete");
$router->post("/testimony/order", "Testimonys:TestimonyOrder");

//DATABASE
$router->get("/database/home", "Database:home", "admin.backup.home");
$router->get("/database/delete", "Database:delete", "admin.backup.delete");
$router->get("/database/backup", "Database:backup", "admin.backup.backup");

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