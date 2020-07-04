<?php

namespace Source\Controllers;

use Source\Support\View;
use CoffeeCode\Router\Router;
use Source\Support\Message;
use Source\Support\Seo;

/**
 * Class Controller
 *
 * @package Source\Controllers
 */
class Controller
{
    /** @var View */
    protected $view;

    /** @var Router */
    protected $router;

    /** @var Seo */
    protected $seo;

    /** @var Message */
    protected $message;

    /**
     * Controller constructor.
     * @param string|null $pathToViews
     * @param null $router
     */
    public function __construct(string $pathToViews = null, string $router = null)
    {
        $this->router = $router;
        $this->view = new View($pathToViews);
        $this->seo = new Seo();
        $this->message = new Message();
    }
}