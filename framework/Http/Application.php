<?php

namespace JonathanRayln\Framework\Http;

/**
 * Class Application
 *
 * @package JonathanRayln\Framework\Http;
 */
class Application
{
    public static Application $app;
    public Request $request;
    public Response $response;
    public Router $router;

    public function __construct()
    {
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);

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
}