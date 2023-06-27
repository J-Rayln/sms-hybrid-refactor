<?php

use JonathanRayln\Framework\Container\Container;
use JonathanRayln\Framework\Database\Database;
use JonathanRayln\Framework\Http\Application;

$container = new Container();

$container->bind('JonathanRayln\Framework\Database\Database', function () {
    return Database::getInstance();
});

Application::setContainer($container);