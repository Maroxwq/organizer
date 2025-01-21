<?php declare(strict_types=1);

namespace Org\Core;

class App
{
    public function run()
    {
        try {
            $routes = include __DIR__ . '/../../config/routes.php';

            $uri = $_SERVER['REQUEST_URI'];
            if (!isset($routes[$uri])) {
                throw new \RuntimeException('Route not found for URI: ' . $uri);
            }

            $parts = explode('/', $routes[$uri]);
    
            $methodName = $parts[1];
            $className = '\\Org\\Controller\\' . ucfirst($parts[0]) . 'Controller';
    
            $controller = new $className();
            echo $controller->$methodName();
        } catch (\Throwable $exception) {
            echo '<h1>', $exception->getMessage(), '</h1>', '<br>';
            echo nl2br($exception->getTraceAsString()), '<br>';
        }
    }
}
