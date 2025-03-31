<?php declare(strict_types=1);

namespace Arc\Framework;

use Arc\Db\DbManager;
use Arc\Db\Repository;
use Arc\Http\Request;
use Arc\View\View;

class Controller
{
    public function __construct(
        protected Request $request,
        protected View $view,
        protected DbManager $dbManager
    ) {
        $this->view->setLayout('layout');
    }

    public function render(string $templatePath, array $params = []): string
    {
        return $this->view->render($templatePath, $params);
    }

    public function repository(string $modelClass): Repository
    {
        return $this->dbManager->getRepository($modelClass);
    }
}
