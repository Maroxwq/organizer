<?php declare(strict_types=1);

namespace Arc\Framework;

use Arc\Db\DbManager;
use Arc\Http\Request;
use Arc\Http\Response;
use Arc\Http\Session;
use Arc\Router\Router;
use Arc\View\View;
use Arc\Security\WebUser;

class App
{
    public function __construct(private array $config) 
    {
        error_reporting(E_ALL);
        set_error_handler(function ($severity, $message, $file, $line) {
            throw new \ErrorException($message, 0, $severity, $file, $line);
        });
    }

    public function run(): void
    {
        try {
            $config = new Config($this->config);
            $session = new Session();
            $router = new Router($config->routes());
            $request = Request::createFromGlobals();
            $dbManager = new DbManager($config->db());
            $webUser = new WebUser($session, $dbManager->getRepository($config->security()['user_class']));
            $view = new View($config->basePath() . '/templates/', $session, $router, $webUser);
            $router->resolveRequest($request);
            $controllerName = ucfirst($request->attributes('_controller'));
            $controllerClass = $config->namespacePrefix() . 'Controller\\' . $controllerName . 'Controller';
            /** @var Controller $controller */
            $controller = new $controllerClass($request, $view, $dbManager, $webUser, $config, $router, $session);
            $before = $controller->before();
            if ($before instanceof Response) {
                $before->send();

                return;
            }
            $response = $controller->{$request->attributes('_action')}( ...$request->attributes('_params') );
            if (is_string($response)) {
                $response = new Response($response);
            }
            
            $response->send();
        } catch (\Throwable $exception) {
            echo '<h1>' . $exception->getMessage() . '</h1>';
            echo nl2br($exception->getTraceAsString()), '<br>';
        }
    }
}
