<?php declare(strict_types=1);

namespace Arc\Http;

class RedirectResponse extends Response
{
    public function __construct(string $url, int $statusCode = 302) {}
    public function send(): self { /*Here just send "Location header without content" */ }
}
