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
    public function __construct(private array $config) {}

    public function run(): void
    {
        try {
            $config = new Config($this->config);
            $session = new Session();
            $router = new Router($config->routes());
            $request = Request::createFromGlobals();
            $view = new View($config->basePath() . '/templates/', $session, $router, new WebUser($session, (new DbManager($config->db()))->getRepository($config->security()['user_class'])));
            $dbManager  = new DbManager($config->db());
            $webUser = new WebUser($session, $dbManager->getRepository($config->security()['user_class']));
            $router->resolveRequest($request);
            $controllerName  = ucfirst($request->attributes('_controller'));
            $controllerClass = $config->namespacePrefix() . 'Controller\\' . $controllerName . 'Controller';
            /** @var Controller $controller */
            $controller = new $controllerClass($request, $view, $dbManager, $webUser, $config, $router);
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
