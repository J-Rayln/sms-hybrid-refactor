<?php

namespace EduLink\Controllers;

use JonathanRayln\Framework\Http\Application;

/**
 * Class SiteController
 *
 * @package EduLink\Controllers;
 */
class SiteController
{
    public function index()
    {
        if (Application::$app->request->method() === 'POST') {
            echo 'posted';
        }
        echo '<pre>';
        print_r('[SiteController::class], index');
        echo '</pre>';
    }

    public function about()
    {
        var_dump('this is the foo method');
    }
}