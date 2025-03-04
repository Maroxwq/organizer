<?php declare(strict_types=1);

namespace Arc\Http;

class Request
{
    public function __construct(
        private array $query = [],
        private array $post = [],
        private array $server = [],
        private array $attributes = []
    ) {}

    public function query(?string $key = null): string|array|null
    {
        if ($key === null) {
            return $this->query;
        }

        return $this->query[$key] ?? null; 
    }

    public function post(?string $key = null): string|array|null
    {
        if ($key === null) {
            return $this->post;
        }

        return $this->post[$key] ?? null;
    }

    public function requestUri(): string
    {
        return preg_replace('/\?.*/', '', $this->server['REQUEST_URI']);
    }

    public function isPost(): bool
    {
        return $this->server['REQUEST_METHOD'] === 'POST';
    }

    public function addAttributes(array $attrs): void
    {
        $this->attributes = array_merge($this->attributes, $attrs);
    }

    public function attributes(?string $key = null): string|array|null
    {
        if ($key === null) {
            return $this->attributes;
        }

        return $this->attributes[$key] ?? null;
    }

    public static function createFromGlobals(): self
    {
        return new Request($_GET, $_POST, $_SERVER);
    }
}
