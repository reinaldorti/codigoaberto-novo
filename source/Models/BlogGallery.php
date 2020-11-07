<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

/**
 * Class BlogGallery
 * @package Source\Models
 */
class BlogGallery extends DataLayer
{
    /**
     * PostGallery constructor.
     */
    public function __construct()
    {
        parent::__construct("posts_images", ["post_id", "images"]);
    }
}