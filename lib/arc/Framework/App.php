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
            $router = new Router($config->routes());
            $request = Request::createFromGlobals();
            $view = new View($config->basePath() . 'templates/');
            $router->resolveRequest($request);
            $controllerClass = $config->namespacePrefix() . 'Controller\\' . ucfirst($request->attributes('_controller')) . 'Controller';
            $controller = new $controllerClass($request, $view);
            $method = $request->attributes('_action');
            $params = $request->attributes('_params');
            echo $controller->$method(...$params);
        } catch (\Throwable $exception) {
            echo '<h1>' . $exception->getMessage() . '</h1>';
            echo nl2br($exception->getTraceAsString()), '<br>';
        }
    }
}
