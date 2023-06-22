<?php

namespace EduLink\Controllers;

/**
 * Class SiteController
 *
 * @package EduLink\Controllers;
 */
class SiteController
{
    public function index()
    {
        echo '<pre>';
        print_r('[SiteController::class], index');
        echo '</pre>';
    }

    public function about()
    {
        var_dump('this is the foo method');
    }
}