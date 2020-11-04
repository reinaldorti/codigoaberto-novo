<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

/**
 * Class PostGallery
 * @package Source\Models
 */
class PostGallery extends DataLayer
{
    /**
     * PostGallery constructor.
     */
    public function __construct()
    {
        parent::__construct("posts_images", ["post_id", "images"]);
    }
}