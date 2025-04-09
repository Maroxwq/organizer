<?php declare(strict_types=1);

namespace Arc\Framework;

use Arc\Db\DbManager;
use Arc\Db\Repository;
use Arc\Http\RedirectResponse;
use Arc\Http\Request;
use Arc\Http\Response;
use Arc\Security\WebUser;
use Arc\View\View;

class Controller
{
    public function __construct(
        protected Request $request,
        protected View $view,
        protected DbManager $dbManager,
        protected WebUser $webUser,
        protected Config $config,
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

    public function before(): bool|Response {
        if ($this->webUser->isAuthenticated()) {
            return true;
        }
        $currentUri = $this->request->requestUri();
        $security = $this->config->security();
        $publicUrls = $security['public_urls'] ?? [];
        foreach ($publicUrls as $pattern) {
            if (preg_match($pattern, $currentUri)) {
                return true;
            }
        }
        return new RedirectResponse($security['login_url']);
    }
}
