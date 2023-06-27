<?php

namespace JonathanRayln\Framework\Http;

use JonathanRayln\Framework\Template\Template;

/**
 * Class Application
 *
 * @package JonathanRayln\Framework\Http;
 */
class Application
{
    public static Application $app;
    public const TEMPLATE_DIR = BASE_PATH . 'edulink/templates/';
    public string $layout = Template::DEFAULT_LAYOUT;
    public static $container;
    public Request $request;
    public Response $response;
    public Router $router;
    public ?Controller $controller = null;
    public Template $template;

    public function __construct()
    {
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->template = new Template();

        $this->loadRequiredFiles();
    }

    /**
     * Loads required files.
     *
     * @return void
     */
    private function loadRequiredFiles(): void
    {
        require_once BASE_PATH . 'framework/functions.php';
    }

    /**
     * Entry point for resolving routes.
     *
     * @return void
     */
    public function run(): void
    {
        try {
            $this->router->resolve();
        } catch (\Exception $exception) {
            echo $exception->getCode() . ' ' . $exception->getMessage();
            exit();
        }
    }

    /**
     * Returns the controller for the current url path.
     *
     * @return \JonathanRayln\Framework\Http\Controller|null
     */
    public function getController(): ?Controller
    {
        return $this->controller;
    }

    /**
     * Sets the controller for the current url path.
     *
     * @param \JonathanRayln\Framework\Http\Controller|null $controller
     */
    public function setController(?Controller $controller): void
    {
        $this->controller = $controller;
    }

    public static function setContainer($container)
    {
        static::$container = $container;
    }

    public static function container()
    {
        return static::$container;
    }

    public static function bind($key, $resolver)
    {
        static::container()->bind($key, $resolver);
    }

    public static function resolve($key)
    {
        return static::container()->resolve($key);
    }
}