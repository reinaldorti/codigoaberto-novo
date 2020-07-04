<?php

namespace Source\Support;

use League\Plates\Engine;

/**
 * Class View
 *
 * @package Source\Support
 */
class View
{
    /** @var Engine */
    private $engine;

    /**
     * View constructor.
     * @param string $path
     * @param string $ext
     */
    public function __construct(string $path = CONF_VIEW['PATH'], string $ext = CONF_VIEW['EXT'])
    {
        $this->engine = Engine::create($path, $ext);
    }

    /**
     * @param string $name
     * @param string $path
     * @return View
     */
    public function path(string $name, string $path): View
    {
        $this->engine->addFolder($name, $path);
        return $this;
    }

    /**
     * @param string $templateName
     * @param array $data
     * @return string
     */
    public function render(string $templateName, array $data): string
    {
        return $this->engine->render($templateName, $data);
    }

    /**
     * @return Engine
     */
    public function engine(): Engine
    {
        return $this->engine();
    }
}