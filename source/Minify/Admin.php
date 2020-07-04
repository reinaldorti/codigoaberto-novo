<?php
// www.site.com.br/?admin=1
$minify = filter_input(INPUT_GET, "admin", FILTER_VALIDATE_BOOLEAN);
if ($minify) {
    /*
     * MINIFY CSS
     */
    $minCSS = new MatthiasMullie\Minify\CSS();
    $cssDir = scandir(dirname(__DIR__, 2) . "/shared/css");
    foreach ($cssDir as $cssItem) {
        $cssFile = dirname(__DIR__, 2) . "/shared/css/{$cssItem}";
        if (is_file($cssFile) && pathinfo($cssFile)["extension"] == "css") {
            $minCSS->add($cssFile);
        }
    }
    $minCSS->minify(dirname(__DIR__, 2) . "/themes/" . CONF_VIEW['ADMIN'] . "/assets/style.min.css");

    /*
     * MINIFY JS
     */
    $minJS = new MatthiasMullie\Minify\JS();
    $minJS->add(dirname(__DIR__, 2) . "/shared/js/jquery.min.js");
    $jsDir = scandir(dirname(__DIR__, 2) . "/shared/js");
    foreach ($jsDir as $jsItem) {
        $jsFile = dirname(__DIR__, 2) . "/shared/js/{$jsItem}";
        if (is_file($jsFile) && pathinfo($jsFile)["extension"] == "js") {
            $minJS->add($jsFile);
        }
    }
    $minJS->minify(dirname(__DIR__, 2) . "/themes/" . CONF_VIEW['ADMIN'] . "/assets/scripts.min.js");
}
