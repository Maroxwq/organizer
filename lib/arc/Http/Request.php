<?php declare(strict_types=1);

namespace Arc\Http;

class Request
{
    private array $query;
    private array $post;
    private array $server;
    private array $attributes;

    public function __construct(array $query, array $post, array $server, array $attributes = [])
    {
        $this->query = $query;
        $this->post = $post;
        $this->server = $server;
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
