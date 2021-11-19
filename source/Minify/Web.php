<?php
// www.site.com.br/?web=1
$minify = filter_input(INPUT_GET, "web", FILTER_VALIDATE_BOOLEAN);
if ($minify) {
    /*
     * MINIFY CSS
     */
    $minCSS = new MatthiasMullie\Minify\CSS();
    $minCSS->add(dirname(__DIR__, 2) . "/shared/css/boot.css");
    $minCSS->add(dirname(__DIR__, 2) . "/shared/css/load.css");

    $minCSS->add(dirname(__DIR__, 2) . "/shared/css/message.css");
    $cssDir = scandir(dirname(__DIR__, 2) . "/public/" . CONF_VIEW["THEME"] . "/assets/css");
    foreach ($cssDir as $cssItem) {
        $cssFile = dirname(__DIR__, 2) . "/public/" . CONF_VIEW["THEME"] . "/assets/css/{$cssItem}";
        if (is_file($cssFile) && pathinfo($cssFile)["extension"] == "css") {
            $minCSS->add($cssFile);
        }
    }
    $minCSS->minify(dirname(__DIR__, 2) . "/public/" . CONF_VIEW["THEME"] . "/assets/style.min.css");

    /*
     * MINIFY JS
     */
    $minJS = new MatthiasMullie\Minify\JS();
    $minJS->add(dirname(__DIR__, 2) . "/public/" . CONF_VIEW["THEME"] . "/assets/js/vendor/jquery-1.12.4.min.js");
    $minJS->add(dirname(__DIR__, 2) . "/shared/js/jquery.form.js");
    $minJS->add(dirname(__DIR__, 2) . "/shared/js/jquery-ui.js");
    $minJS->add(dirname(__DIR__, 2) . "/shared/js/web.js");
    $minJS->add(dirname(__DIR__, 2) . "/shared/js/lgpd.js");
    $minJS->add(dirname(__DIR__, 2) . "/public/" . CONF_VIEW["THEME"] . "/assets/js/vendor/modernizr-3.5.0.min.js");
    $jsDir = scandir(dirname(__DIR__, 2) . "/public/" . CONF_VIEW["THEME"] . "/assets/js");
    foreach ($jsDir as $jsItem) {
        $jsFile = dirname(__DIR__, 2) . "/public/" . CONF_VIEW["THEME"] . "/assets/js/{$jsItem}";
        if (is_file($jsFile) && pathinfo($jsFile)["extension"] == "js") {
            $minJS->add($jsFile);
        }
    }
    $minJS->minify(dirname(__DIR__, 2) . "/public/" . CONF_VIEW["THEME"] . "/assets/scripts.min.js");
}
