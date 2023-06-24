<?php

namespace JonathanRayln\Framework\Http;

/**
 * Class Response
 *
 * @package JonathanRayln\Framework\Http;
 */
class Response
{

    public function setStatusCode(int $code): void
    {
        http_response_code($code);
    }
}