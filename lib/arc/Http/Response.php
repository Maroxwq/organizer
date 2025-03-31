<?php declare(strict_types=1);

namespace Arc\Http;

class Response
{
    public function __construct(private string $content, private array $headers = []) {}

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
        foreach ($this->headers as $name => $value) {
            header("{$name}: {$value}");
        }
        echo $this->content;

        return $this;
    }
}
