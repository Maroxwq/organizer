<?php declare(strict_types=1);

namespace Org\Controller;

use Arc\Framework\BaseController;
use Arc\Http\Request;
use Arc\View\View;

class AboutController extends BaseController
{
    public function __construct(Request $request, View $view)
    {
        parent::__construct($request, $view);
        $this->view->setLayout('layout');
    }

    public function index()
    {
        return $this->view->render('about/index');
    }
}
