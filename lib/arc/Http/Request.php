<?php declare(strict_types=1);

namespace Arc\Http;

class Request
{
    private array $query; // $_GET
    private array $post; // $_POST
    private array $server; // $_SERVER
    private array $attributes; // Custom attributes e.g. _controller, _method, _params

    public function __construct(array $query = null, array $post = null, array $server = null, array $attributes = [])
    {
        $this->query = $query ?? $_GET;
        $this->post = $post ?? $_POST;
        $this->server = $server ?? $_SERVER;
        $this->attributes = $attributes;
    }

    public function query(string $key = null): string|array|null
    {
        if ($key === null) {
            return $this->query;
        }
        return $this->query[$key]; 
    }

    public function getPost(): array
    {
        return $this->post;
    }

    public function requestUri(): string
    {
        return $this->server['REQUEST_URI'];
    }

    public function isPost(): bool
    {
        return $this->server['REQUEST_METHOD'] === 'POST';
    }
}
