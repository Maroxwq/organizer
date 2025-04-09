<?php declare(strict_types = 1);

namespace Arc\View;

use Arc\Http\Session;

class View
{
    private string $basePath;
    private ?string $layout;
    private ?Session $session = null;

    public function __construct(string $basePath)
    {
        $this->basePath = $basePath;
    }

    public function setLayout(?string $layout)
    {
        $this->layout = $layout;
    }

    public function setSession(Session $session): void
    {
        $this->session = $session;
    }

    public function session(): ?Session
    {
        return $this->session;
    }

    public function renderPartial(string $templatePath, array $params = []): string
    {
        extract($params);
        ob_start();
        ob_implicit_flush(false);

        require $this->basePath . $templatePath . '.php';

        return ob_get_clean();
    }

    public function render(string $templatePath, array $params = []): string
    {
        $rendered = $this->renderPartial($templatePath, $params);

        if ($this->layout) {
            return $this->renderPartial($this->layout, ['content' => $rendered]);
        }

        return $rendered;
    }

    // public function extends(string $layoutPath): void
    // {
    
    // }
}
