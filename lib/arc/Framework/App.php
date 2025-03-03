<?php declare(strict_types=1);

namespace Arc\Framework;

use Arc\Router\Router;
use Arc\Http\Request;
use Arc\View\View;

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
            $config = new Config($this->config);
            $routes = $config->routes();
            $router = new Router($routes, $config);
            $request = new Request($_GET, $_POST, $_SERVER);
            $view = new View(__DIR__ . '/../../../templates/');
            $routeInfo = $router->detect($request->requestUri());
            $controllerClass = $routeInfo['controllerClassName'];
            $controller = new $controllerClass($request, $view);
            echo $controller->{$routeInfo['methodName']}($routeInfo['params']);
        } catch (\Throwable $exception) {
            echo '<h1>' . $exception->getMessage() . '</h1>';
            echo nl2br($exception->getTraceAsString()), '<br>';
        }
    }
}
