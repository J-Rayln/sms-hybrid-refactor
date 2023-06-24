<?php

namespace EduLink\Controllers;

use JonathanRayln\Framework\Http\Request;

/**
 * Class SiteController
 *
 * @package EduLink\Controllers;
 */
class SiteController
{
    public function index()
    {
        if (Request::isPost()) {
            echo 'posted';
        }
        echo '<pre>';
        print_r('[SiteController::class], index');
        echo '</pre>';
    }

    public function about()
    {
        var_dump('this is the about method');
    }

    public function foo(Request $request)
    {
        var_dump('this is the foo method');
        echo '<pre>';
        var_dump($request->getRouteParams());
        echo '</pre>';
        exit;
    }
}