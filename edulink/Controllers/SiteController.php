<?php

namespace EduLink\Controllers;

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
        if (Request::isPost()) {
            echo 'posted';
        }
        
        echo '<pre>';
        print_r($this);
        echo '</pre>';

        return $this->render('test', [
            'var' => 'value'
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