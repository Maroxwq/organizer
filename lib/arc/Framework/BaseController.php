<?php declare(strict_types=1);

namespace Arc\Framework;

use Arc\Http\Request;
use Arc\View\View;

class BaseController
{
    protected View $view;
    protected Request $request;

    public function __construct(Request $request, View $view)
    {
        $this->request = $request;
        $this->view = $view;
    }
}
