<?php

namespace JonathanRayln\Framework\Middleware;

/**
 * Class Guest
 *
 * @package JonathanRayln\Framework\Middleware;
 */
class Guest implements MiddlewareInterface
{

    /**
     * @inheritDoc
     */
    public function handle(): void
    {
        var_dump('this is the guest middleware');
    }
}