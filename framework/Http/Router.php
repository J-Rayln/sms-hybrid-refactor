<?php

namespace JonathanRayln\Framework\Http;

use JonathanRayln\Framework\Middleware\Middleware;

/**
 * Class Router
 *
 * @package JonathanRayln\Framework\Http;
 */
class Router
{
    public Request $request;
    public Response $response;
    protected array $routes = [];
    protected string $middleware = Middleware::DEFAULT_MIDDLEWARE;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

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
            'middleware' => $middleware ?? $this->middleware,
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

    public function resolve()
    {
        $callback = $this->routes[$this->request->method()][$this->request->path()]['controller'] ?? false;

        if (!$callback) {
            $this->response->setStatusCode(500);
            exit('there is no callback for that path');
        }

        // Instantiate the controller
        $controller = new $callback[0]();
        // Put the controller object back into the $callback
        $callback[0] = $controller;

        echo '<pre style="color: red">' . __FILE__ . ' (' . __LINE__ . ')</pre>';
        echo '<pre>';
        print_r($this->routes);
        echo '</pre>';
        exit;

        return call_user_func($callback, $this->request, $this->response);
    }
}