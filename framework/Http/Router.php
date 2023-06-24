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

    /**
     * Resolves the current URL to the $routes[] map and parses any parameters
     * passed.
     *
     * @throws \Exception An exception is thrown if middleware is specified in
     *                    the route that does not exist.
     */
    public function resolve()
    {
        $callback = $this->routes[$this->request->method()][$this->request->path()] ?? false;
        $middleware = $callback['middleware'] ?? null;

        if (!$callback) {

            $callback = $this->parseRouteParams($this->request->method(), $this->request->path());

            if ($callback === false) {
                $this->response->setStatusCode(500);
                exit('there is no callback for that path');
            }
        }

        // Instantiate the controller
        $controller = new $callback['controller'][0]();
        // Put the controller object back into the $callback
        $callback['controller'][0] = $controller;

        // Resolve the specified middleware (default if none is specified).
        Middleware::resolve($middleware);

        return call_user_func([$callback['controller'][0], $callback['controller'][1]], $this->request, $this->response);
    }

    /**
     * Parses route params for routes containing wildcards and returns a valid
     * $callback to the resolve() method.
     *
     * Example routes might be:
     * * /profile/{id:\d+}/{username}
     * * /login/{id}
     *
     * @param string $method
     * @param string $path
     * @return false|array
     */
    protected function parseRouteParams(string $method, string $path): bool|array
    {
        $path = trim($path, '/');

        // Get all routes for the current request method
        $routes = $this->routes[$method] ?? [];

        $routeParams = false;

        // Iterate over registered routes
        foreach ($routes as $route => $callback) {
            $route = trim($route, '/');
            $routeNames = [];

            if (!$route) {
                continue;
            }

            // Find all route names from $route and save in $routeNames
            if (preg_match_all('/\{(\w+)(:[^}]+)?}/', $route, $matches)) {
                $routeNames = $matches[1];
            }

            // Convert route names into regex pattern
            $routeRegex = "@^" . preg_replace_callback('/\{\w+(:([^}]+))?}/', fn($m) => isset($m[2]) ? "({$m[2]})" : '([\w-]+)', $route) . "$@";

            // Test and match current route against $routeRegex
            if (preg_match_all($routeRegex, $path, $valueMatches)) {
                $values = [];
                for ($i = 1; $i < count($valueMatches); $i++) {
                    $values[] = $valueMatches[$i][0];
                }
                $routeParams = array_combine($routeNames, $values);

                $this->request->setRouteParams($routeParams);
                return $callback;
            }
        }

        return false;
    }
}