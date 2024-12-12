<?php

namespace Source\Support;

use CoffeeCode\Optimizer\Optimizer;

/**
 * Class Seo
 *
 * @package Source\Support
 */
class Seo
{
    /** @var Optimizer */
    protected $optimizer;

    /**
     * Seo constructor.
     * @param string $schema
     */
    public function __construct(string $schema = "article")
    {
        $this->optimizer = new Optimizer();
        $this->optimizer->openGraph(
            CONF_SITE['NAME'],
            CONF_SITE['LANG'],
            $schema
        )->twitterCard(
            CONF_SOCIAL['TWITTER_CREATOR'],
            CONF_SOCIAL['TWITTER_PUBLISHER'],
            CONF_SITE['DOMAIN']
        )->publisher(
            CONF_SOCIAL['FACEBOOK_PAGE'],
            CONF_SOCIAL['FACEBOOK_AUTHOR'],
            CONF_SOCIAL['GOOGLE_PAGE'],
            CONF_SOCIAL['GOOGLE_AUTHOR']
        )->facebook(
            CONF_SOCIAL['FACEBOOK_APP']
        );
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->optimizer->data()->$name;
    }

    /**
     * @param string $title
     * @param string $description
     * @param string $url
     * @param string $image
     * @param bool $follow
     * @return string
     */
    public function render(string $title, string $description, string $url, string $image, bool $follow = true): string
    {
        return $this->optimizer->optimize($title, $description, $url, $image, $follow)->render();
    }

    /**
     * @return Optimizer
     */
    public function optimizer(): Optimizer
    {
        return $this->optimizer;
    }

    /**
     * @param string|null $title
     * @param string|null $desc
     * @param string|null $url
     * @param string|null $image
     * @return null|object
     */
    public function data(?string $title = null, ?string $desc = null, ?string $url = null, ?string $image = null)
    {
        return $this->optimizer->data($title, $desc, $url, $image);
    }
}