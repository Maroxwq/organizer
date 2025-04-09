<?php declare(strict_types=1);

namespace Arc\Http;

class RedirectResponse extends Response
{
    public function __construct(private string $url, int $statusCode = 302)
    {
        parent::__construct();
        $this->addHeader('Location', $this->url);
        $this->setStatusCode($statusCode);
    }
}
