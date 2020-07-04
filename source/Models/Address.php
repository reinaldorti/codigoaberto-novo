<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

/**
 * Class Address
 * @package Source\Models
 */
class Address extends DataLayer
{
    /**
     * Address constructor.
     */
    public function __construct()
    {
        parent::__construct("address", ["user_id"], "id", false);
    }
}