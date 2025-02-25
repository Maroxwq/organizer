<?php declare(strict_types=1);

namespace Arc\Http;

class Request
{
    private array $query; // $_GET
    private array $post; // $_POST
    private array $server; // $_SERVER
    private array $attributes; // Custom attributes e.g. _controller, _method, _params

    public function __construct(array $query, array $post, array $server, array $attributes = [])
    {
        $this->query = $query;
        $this->post = $post;
        $this->server = $server;
        $this->attributes = $attributes;
    }

    public function query(string $key = null): string|array|null
    {
        
    }

    public function requestUri(): string
    {
        return $this->server['REQUEST_URI'];
    }

    public function isPost(): bool
    {
        //$_SERVER['REQUEST_METHOD'] === 'POST'
    }
}
