<?php declare(strict_types=1);

namespace Arc\Router;

use Arc\Http\Request;

class Router
{
    public function __construct(private array $routes) {}

    public function resolveRequest(Request $request): bool
    {
        $request->addAttributes($this->detect($request->requestUri()));

        return true;
    }

    public function detect(string $uri): array
    {
        foreach ($this->routes as $route => $action) {
            $pattern = preg_replace('/:\w+/', '(\w+)', $route) . '/?';

            if (preg_match('#^' . $pattern . '$#', $uri, $matches)) {
                $parts = explode('/', $action);
                $params = [];

                preg_match_all('/:(\w+)/', $route, $paramNames);
                foreach ($paramNames[1] as $index => $paramName) {
                    $paramValue = $matches[$index + 1];
                    $params[$paramName] = is_numeric($paramValue) ? (int) $paramValue : $paramValue;
                }
                
                return [
                    '_controller' => $parts[0],
                    '_action' => $parts[1],
                    '_params' => $params,
                ];
            }
        }

        throw new \RuntimeException('Route not found: ' . $uri);
    }

    public function url(string $routeOrAction, array $params = []): string
    {
        if (isset($this->routes[$routeOrAction])) {
            $pattern = $routeOrAction;
        } else {
            $pattern = array_search($routeOrAction, $this->routes, true);
            if ($pattern === false) {
                throw new \RuntimeException("Route or action not found: {$routeOrAction}");
            }
        }

        $url = $pattern;
        foreach ($params as $key => $value) {
            $url = preg_replace('/:' . preg_quote($key, '/') . '\b/', (string) $value, $url);
        }

        return $url;
    }
}
