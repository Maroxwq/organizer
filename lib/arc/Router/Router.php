<?php declare(strict_types=1);

namespace Arc\Router;

class Router
{
    private array $routes;

    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    public function detect(string $requestUri): array
    {
        foreach ($this->routes as $route => $action) {
            $pattern = preg_replace('/:\w+/', '(\w+)', $route) . '/?';
            
            if (preg_match('#^' . $pattern . '$#', $requestUri, $matches)) {
                $parts = explode('/', $action);
                $params = [];

                preg_match_all('/:(\w+)/', $route, $paramNames);
                foreach ($paramNames[1] as $index => $paramName) {
                    $params[$paramName] = $matches[$index + 1];
                }

                return [
                    'controllerClassName' => '\\Org\\Controller\\' . ucfirst($parts[0]) . 'Controller',
                    'methodName' => $parts[1],
                    'params' => $params
                ];
            }
        }

        throw new \RuntimeException('Route not found: ' . $requestUri);
    }
}
