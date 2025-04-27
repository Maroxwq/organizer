<?php declare(strict_types=1);

namespace Arc\View;

use Arc\Http\Session;
use Arc\Router\Router;
use Arc\Security\WebUser;

class View
{
    private ?string $layout;
    private array $globalVars = [];

    public function __construct(
        private string $basePath,
        private Session $session,
        private Router $router,
        private WebUser $webUser
    ) {}

    public function setLayout(?string $layout): void
    {
        $this->layout = $layout;
    }

    public function session(): Session
    {
        return $this->session;
    }

    public function url(string $route, array $params = []): string
    {
        return $this->router->url($route, $params);
    }

    public function webUser(): WebUser
    {
        return $this->webUser;
    }

    public function setGlobalVar(string $key, mixed $value): self
    {
        $this->globalVars[$key] = $value;

        return $this;
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
