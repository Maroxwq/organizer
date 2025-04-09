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
    }

    public function run(): void
    {
        try {
            $config = new Config($this->config);
            $session = new Session();
            $router = new Router($config->routes());
            $request = Request::createFromGlobals();
            $view = new View($config->basePath() . '/templates/');
            $view->setSession($session);
            $dbManager = new DbManager($config->db());
            $userRepository = $dbManager->getRepository(\Org\Model\User::class);
            $webUser = new WebUser($session, $userRepository);
            $router->resolveRequest($request);
            $controllerClass = $config->namespacePrefix() . 'Controller\\' . ucfirst($request->attributes('_controller')) . 'Controller';
            /** @var Controller $controller */
            $controller = new $controllerClass($request, $view, $dbManager, $webUser, $config);
            $method = $request->attributes('_action');
            $params = $request->attributes('_params');
            $beforeResult = $controller->before();
            if ($beforeResult instanceof Response) {
                $beforeResult->send();
                return;
            }
            $response = $controller->$method(...$params);
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
