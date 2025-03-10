<?php declare(strict_types=1);

namespace Org\Controller;

use Arc\Framework\BaseController;
use Org\Model\User;
use Arc\Http\Request;
use Arc\View\View;

class DraftController extends BaseController
{
    public function __construct(Request $request, View $view)
    {
        parent::__construct($request, $view);
        $this->view->setLayout('layout');
    }

    public function index()
    {
        $user = new User('', '', 0);
        $user->load($_POST);

        return $this->view->render('draft/index');
    }
}
