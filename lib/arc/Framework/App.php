<?php declare(strict_types=1);

namespace Arc\Framework;

use Arc\Db\DbManager;
use Arc\Router\Router;
use Arc\Http\Request;
use Arc\View\View;

class App
{
    public function __construct(private array $config) {}

    public function run()
    {
        try {
            $config = new Config($this->config);
            $router = new Router($config->routes());
            $request = Request::createFromGlobals();
            $view = new View($config->basePath() . '/templates/');
            $dbManager = new DbManager($config->db());
            $router->resolveRequest($request);
            $controllerClass = $config->namespacePrefix() . 'Controller\\' . ucfirst($request->attributes('_controller')) . 'Controller';
            $controller = new $controllerClass($request, $view, $dbManager);
            $method = $request->attributes('_action');
            $params = $request->attributes('_param');
            echo $controller->$method(...$params);
        } catch (\Throwable $exception) {
            echo '<h1>' . $exception->getMessage() . '</h1>';
            echo nl2br($exception->getTraceAsString()), '<br>';
        }
    }
}
