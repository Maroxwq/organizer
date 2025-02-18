<?php declare(strict_types=1);

namespace Org\Core;

class App
{
    public function run()
    {
        try {
            $routes = include __DIR__ . '/../../config/routes.php';
            $router = new Router($routes);
            $routeInfo = $router->detect($_SERVER['REQUEST_URI']);

            echo (new $routeInfo['controllerClassName']())->{$routeInfo['methodName']}($routeInfo['params']);
        } catch (\Throwable $exception) {
            echo '<h1>', $exception->getMessage(), '</h1>';
            echo nl2br($exception->getTraceAsString()), '<br>';
        }
    }
}
