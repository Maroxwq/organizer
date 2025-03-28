<?php declare(strict_types=1);

namespace Org\Controller;

use Arc\Db\Query;
use Arc\Framework\Controller;
use Note;

class DraftController extends Controller
{
    public function index()
    {
        session_start();
        // $_SESSION['key1'] = 'Vasya';






        return $this->render('draft/index');
    }
}
