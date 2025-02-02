<?php declare(strict_types=1);

namespace Org\Core;

class Router
{
    private array $routes;

    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    public function detect(string $uri): array
    {
        return [];
    }
}
