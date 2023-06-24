<?php

namespace JonathanRayln\Framework\Middleware;

/**
 * Class Middleware
 *
 * @package JonathanRayln\Framework\Middleware;
 */
class Middleware
{
    /** @var string Default middleware to apply if none is specified. */
    public const DEFAULT_MIDDLEWARE = 'guest';

    /** @var array[] Associative array of middleware classes to apply. */
    public const MAP = [
        'auth'  => Auth::class,
        'guest' => Guest::class
    ];

    /**
     * Instantiate the middleware for the given $key.
     *
     * @param string $key The key that matches the middleware class that you
     *                    wish to apply to that route.  Keys are defined in
     *                    the MAP constant.
     * @return void
     * @throws \Exception
     */
    public static function resolve(string $key): void
    {
        if (!$key) {
            return;
        }

        $middleware = static::MAP[$key] ?? false;

        if (!$middleware) {
            throw new \Exception("No matching middleware found for key \"{$key}\"");
        }

        (new $middleware)->handle();
    }
}