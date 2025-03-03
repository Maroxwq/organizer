<?php declare(strict_types=1);

namespace Arc\Framework;

class Config
{
    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function routes(): array
    {
        return $this->config['routes'];
    }

    public function namespacePrefix(): string
    {
        return $this->config['base_namespace'];
    }

    public function get(string $key)
    {
        return $this->config[$key];
    }
}
