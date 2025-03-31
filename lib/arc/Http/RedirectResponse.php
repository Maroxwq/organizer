<?php declare(strict_types=1);

namespace Arc\Http;

class RedirectResponse extends Response
{
    public function __construct(private string $url, private int $statusCode = 302)
    {
        parent::__construct('');
        $this->addHeader('Location', $this->url);
    }

    public function send(): self
    {
        http_response_code($this->statusCode);
        header("Location: " . $this->url);

        return $this;
    }
}
