<?php declare(strict_types=1);

namespace Arc\Http;

class Response
{
    public function __construct(string $content, array $headers = []) {}
    public function setContent(string $content): self {}
    public function addHeader(string $name, string $value): self {}
    public function cleanHeaders(): self {}
    public function send(): self {}
}
