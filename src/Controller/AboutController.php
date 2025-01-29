<?php declare(strict_types=1);

namespace Org\Controller;

use Org\Core\BaseController;

class AboutController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->view()->setLayout('layout');
    }

    public function index()
    {
        return $this->view()->render('about/index');
    }
}
