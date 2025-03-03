<?php declare(strict_types=1);

namespace Org\Controller;

use Arc\Framework\BaseController;

class AboutController extends BaseController
{
    public function __construct(\Arc\Http\Request $request, \Arc\View\View $view)
    {
        parent::__construct($request, $view);
        $this->view->setLayout('layout');
    }

    public function index()
    {
        return $this->view->render('about/index');
    }
}
