<?php

use Src\Database\Migrations\CreateUserTable;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';  
// require_once __DIR__ . '/src/router.php';
require_once __DIR__ . '/src/Core/Helpers/index.php';

// try {
//     $route = $router->matchFromPath($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

//     $parameters = $route->getParameters();
//     $arguments = $route->getVars();

//     $controller = $parameters[0];
//     $method = $parameters[1] ?? null;

//     $controller = new $controller();
//     if(!is_callable($controller)) {
//         $controller = [$controller, $method];
//     }

//     echo $controller(...array_values($arguments));
// } catch (\Exception $exception){
//     header("HTTP/1.0 404 Not found");
// }

