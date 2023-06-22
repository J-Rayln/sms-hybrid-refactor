<?php

namespace JonathanRayln\Framework\Http;

/**
 * Class Application
 *
 * @package JonathanRayln\Framework\Http;
 */
class Application
{
    public Router $router;

    public function __construct()
    {
        $this->router = new Router();

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