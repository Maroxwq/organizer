<?php declare(strict_types=1);

namespace Org\Controller;

use Arc\Framework\Controller;
use Arc\Http\Request;
use Arc\View\View;

class AboutController extends Controller
{
    public function __construct(Request $request, View $view)
    {
        parent::__construct($request, $view);
        $this->view->setLayout('layout');
    }

    public function index()
    {
        return $this->render('about/index');
    }
}
