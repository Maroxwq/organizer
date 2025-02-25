<?php declare(strict_types=1);

namespace Arc\Framework;

use Arc\Router\Router;

class App
{
    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }
    
    public function run()
    {
        try {
            $routes = $this->config['routes'];
            $router = new Router($routes);
            $routeInfo = $router->detect($_SERVER['REQUEST_URI']);

            echo (new $routeInfo['controllerClassName']())->{$routeInfo['methodName']}($routeInfo['params']);
        } catch (\Throwable $exception) {
            echo '<h1>' . $exception->getMessage() . '</h1>';
            echo nl2br($exception->getTraceAsString()), '<br>';
        }
    }
}
