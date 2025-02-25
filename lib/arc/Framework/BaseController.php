<?php declare(strict_types=1);

namespace Arc\Framework;

use Arc\Http\Request;
use Arc\View\View;

class BaseController
{
    protected View $view;
    protected Request $request;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates/');
    }

    public function view(): View
    {
        return $this->view;
    }
}