<?php 

use Src\Core\Http\Route;
use Src\Core\Http\Router;
use Src\Controllers\HomeController;

$router = new Router([
    new Route('homepage', '/', [HomeController::class, 'index']),
    new Route('test', '/welcome', [HomeController::class, 'show'])
]);

echo ($router->generateUri('test'));
