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
                    $param = $matches[$index + 1];
                    $param = is_numeric($param) ? (int) $param : $param;
                    $params[$paramName] = $param;
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
}
