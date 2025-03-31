<?php declare(strict_types=1);

namespace Org\Controller;

use Arc\Framework\Controller;

class AboutController extends Controller
{
    public function index()
    {
        return $this->render('about/index');
    }
}
