<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

/**
 * Class Testimony
 * @package Source\Models
 */
class Testimony extends DataLayer
{
    /**
     * Testimony constructor.
     */
    public function __construct()
    {
        parent::__construct("testimony", ["id", "title", "status", "author"]);
    }
}