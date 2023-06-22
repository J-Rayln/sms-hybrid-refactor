<?php

use EduLink\Controllers\SiteController;
use JonathanRayln\Framework\Http\Application;

// Full path to the directory above this one including the trailing slash/
define('BASE_PATH', dirname(__DIR__, 1) . '/');

// Get the autoloader
require_once BASE_PATH . 'vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$app = new Application();

$app->router->get('/', [SiteController::class, 'index'], 'auth');

// standard action
$app->router->get('/about', [SiteController::class, 'about'], 'foo');
// optional variable
$app->router->get('/about/{id:\+d}', [SiteController::class, 'individual']);
// No action
$app->router->get('/help', [SiteController::class], 'foo');


$app->run();