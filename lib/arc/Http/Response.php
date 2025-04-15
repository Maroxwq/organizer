<?php declare(strict_types=1);

namespace Arc\Http;

class Response
{
    private int $statusCode = 200;

    public function __construct(private string $content = '', private array $headers = []) {}

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function addHeader(string $name, string $value): self
    {
        $this->headers[$name] = $value;

        return $this;
    }

    public function cleanHeaders(): self
    {
        $this->headers = [];

        return $this;
    }

    public function send(): self
    {
        http_response_code($this->statusCode);
        foreach ($this->headers as $name => $value) {
            header("{$name}: {$value}");
        }
        echo $this->content;

        return $this;
    }

    public function setStatusCode(int $code): self
    {
        $this->statusCode = $code;

        return $this;
    }
}
