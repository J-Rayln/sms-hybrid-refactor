<?php

namespace EduLink\Controllers;

use JonathanRayln\Framework\Database\Database;
use JonathanRayln\Framework\Http\Application;
use JonathanRayln\Framework\Http\Controller;
use JonathanRayln\Framework\Http\Request;

/**
 * Class SiteController
 *
 * @package EduLink\Controllers;
 */
class SiteController extends Controller
{
    public function index()
    {
        $db = Application::resolve(Database::class);
        echo '<pre>';
        var_dump($db);
        echo '</pre>';
        
        if (Request::isPost()) {
            echo 'posted';
        }

        echo '<pre>';
        print_r($this);
        echo '</pre>';

        return $this->render('test', 'Home Page', [
            'foo' => 'bar'
        ]);
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