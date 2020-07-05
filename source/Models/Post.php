<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;
use Exception;

/**
 * Class Post
 * @package Source\Models
 */
class Post extends DataLayer
{
    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct("posts", ["title", "subtitle", "content"]);
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        $checkUri = (new Post())->find("uri = :uri AND id != :id", "uri={$this->uri}&id={$this->id}");

        if ($checkUri->count()) {
            $this->uri = "{$this->uri}-". time();
        }

        return parent::save();
    }


    /**
     * @return null|User
     */
    public function author(): ?User
    {
        if ($this->author) {
            return (new User())->find("id = :id", "id={$this->author}")->fetch();
        }
        return null;
    }
}