<?php declare(strict_types=1);

namespace Org\Core;

class BaseController
{
    private View $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../templates/');
    }

    public function view(): View
    {
        return $this->view;
    }
}