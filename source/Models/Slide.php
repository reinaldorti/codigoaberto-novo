<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

/**
 * Class Slide
 * @package Source\Models
 */
class Slide extends DataLayer
{
    /**
     * Slide constructor.
     */
    public function __construct()
    {
        parent::__construct("slides", ["title", "subtitle", "status"]);
    }
}