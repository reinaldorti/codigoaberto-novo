<?php

namespace Source\Support;

/**
 * Class Message
 * @package Source\Support
 */
class Message
{
    /**
     * @param string $param
     * @param array $values
     * @return string
     */
    public static function ajaxResponse(string $param, array $values): string
    {
        return json_encode([$param => $values]);
    }
}