<?php

namespace JonathanRayln\Framework\Middleware;

/**
 * Class Auth
 *
 * @package JonathanRayln\Framework\Middleware;
 */
class Auth implements MiddlewareInterface
{

    /**
     * @inheritDoc
     */
    public function handle(): void
    {
        var_dump('this is the auth middleware');
    }
}