<?php

namespace JonathanRayln\Framework\Http;

/**
 * Class Router
 *
 * @package JonathanRayln\Framework\Http;
 */
class Router
{
    protected array $routes = [];
    protected string $middleware = 'default2';

    /**
     * Adds a new route to the $routes[] array for the given $method and $path.
     *
     * @param string      $method     Server request method for the given route.
     * @param string      $path       Server request uri (without route params) for the
     *                                given path.
     * @param array       $controller Array of Controller class to be instantiated
     *                                and the method within that controller to be
     *                                called.
     * @param string|null $middleware Optional.  Middleware to be applied to the
     *                                route.  If omitted, the default middleware
     *                                will be applied.
     * @return $this
     */
    public function add(string $method, string $path, array $controller, ?string $middleware): static
    {
        $this->routes[$method][$path] = [
            'controller' => $controller,
            'middleware' => $middleware,
        ];

        return $this;
    }

    public function get(string $path, array $controller, ?string $middleware = null): static
    {
        return $this->add('GET', $path, $controller, $middleware);
    }

    public function post(string $path, array $controller, ?string $middleware = null): static
    {
        return $this->add('POST', $path, $controller, $middleware);
    }

    public function delete(string $path, array $controller, ?string $middleware = null): static
    {
        return $this->add('DELETE', $path, $controller, $middleware);
    }

    public function patch(string $path, array $controller, ?string $middleware = null): static
    {
        return $this->add('PATCH', $path, $controller, $middleware);
    }

    public function put(string $path, array $controller, ?string $middleware = null): static
    {
        return $this->add('PUT', $path, $controller, $middleware);
    }

    public function method()
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

    public function resolve(): void
    {
        try {
            $callback = $this->routes[$this->method()][$this->path()]['controller'] ?? false;

            if (!$callback) {
                exit('there is no callback for that path');
            }

            // Instantiate the controller
            $controller = new $callback[0]();
            // Put the controller object back into the $callback
            $callback[0] = $controller;

            call_user_func($callback);

        } catch (\TypeError $e) {
            echo $e->getMessage();
        }
    }
}