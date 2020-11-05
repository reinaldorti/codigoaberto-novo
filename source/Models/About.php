<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

/**
 * Class About
 * @package Source\Models
 */
class About extends DataLayer
{
    /**
     * About constructor.
     */
    public function __construct()
    {
        parent::__construct("about",  ["title", "status", "content"]);
    }
}