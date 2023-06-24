<?php

namespace JonathanRayln\Framework\Http;

/**
 * Class Request
 *
 * @package JonathanRayln\Framework\Http;
 */
class Request
{
    /**
     * Gets the current request method.  If a custom method has been set
     * via a POST request, that value is used, otherwise the value is taken
     * from the $_SERVER['REQUEST_METHOD'].
     *
     * @return string
     */
    public function method(): string
    {
        return $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Parses the $_SERVER['REQUEST_URI'] and returns the 'path' key,
     * effectively ignoring any query string present in the URL.  If the result
     * is '/' (the root URL of the site), that is returned.  If not, any trailing
     * slashes are trimmed.
     *
     * @return string
     */
    public function path(): string
    {
        $path = parse_url($_SERVER['REQUEST_URI'])['path'];
        return ($path === '/') ? $path : rtrim($path, '/');
    }
}