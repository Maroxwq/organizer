<?php declare(strict_types=1);

namespace Arc\Router;

use Arc\Framework\Config;

class Router
{
    private array $routes;
    private Config $config;

    public function __construct(array $routes, Config $config)
    {
        $this->routes = $routes;
        $this->config = $config;
    }

    public function detect(string $requestUri): array
    {
        $uriParts = explode('?', $requestUri);
        $uri = $uriParts[0];

        foreach ($this->routes as $route => $action) {
            $pattern = preg_replace('/:\w+/', '(\w+)', $route) . '/?';
            
            if (preg_match('#^' . $pattern . '$#', $uri, $matches)) {
                $parts = explode('/', $action);
                $params = [];

                preg_match_all('/:(\w+)/', $route, $paramNames);
                foreach ($paramNames[1] as $index => $paramName) {
                    $params[$paramName] = $matches[$index + 1];
                }

                return [
                    'controllerClassName' => $this->config->namespacePrefix() . 'Controller\\' . ucfirst($parts[0]) . 'Controller',
                    'methodName' => $parts[1],
                    'params' => $params
                ];
            }
        }

        throw new \RuntimeException('Route not found: ' . $uri);
    }
}
