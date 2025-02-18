<?php declare(strict_types=1);

namespace Org\Controller;

use Org\Core\BaseController;
use Org\Model\User;

class DraftController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->view()->setLayout('layout');
    }

    public function index()
    {
        $user = new User('', '', 0);
        $user->load($_POST);

        return $this->view()->render('draft/index');
    }
}
