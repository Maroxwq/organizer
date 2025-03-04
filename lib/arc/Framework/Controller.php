<?php declare(strict_types=1);

namespace Arc\Framework;

use Arc\Http\Request;
use Arc\View\View;

class Controller
{
    public function __construct(protected Request $request, protected View $view) {}

    public function render(string $templatePath, array $params = []): string
    {
        return $this->view->render($templatePath, $params);
    }
}
