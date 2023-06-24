<?php

namespace JonathanRayln\Framework\Middleware;

interface MiddlewareInterface
{
    /**
     * Applies middleware to the route.
     *
     * @return void
     */
    public function handle(): void;
}