<?php declare(strict_types=1);

namespace Org\Controller;

use Arc\Framework\Controller;
use Arc\Http\RedirectResponse;
use Arc\Http\Response;
use Org\Model\User;
use Arc\Db\Repository;

class AuthController extends Controller
{
    public function before(): bool|Response
    {
        $this->view->setLayout('auth_layout');

        return parent::before();
    }


    public function login(): Response|string
    {
        $user = new User();
        if ($this->request->isPost()) {
            $user->load($this->request->post());
            if ($pass = $this->request->post('password')) {
                $user->setPasswordPlain(trim($pass));
            }
            if ($user->isValid()) {
                $found = $this->findUserByEmail($user->getEmail());
                if ($found && $found->checkPassword($user->getPasswordPlain())) {
                    $this->webUser->login($found);

                    return $this->redirect($this->url('about/index'));
                }
                $user->addError('email', 'Invalid email or password');
            }
        }

        return $this->render('auth/login', ['user' => $user]);
    }

    public function register(): Response|string
    {
        $user = new User();
        if ($this->request->isPost()) {
            $user->load($this->request->post());
            if ($pass = $this->request->post('password')) {
                $user->setPasswordPlain(trim($pass));
            }
            if ($user->isValid()) {
                if ($this->findUserByEmail($user->getEmail())) {
                    $user->addError('email', 'Email already exists');
                } else {
                    $user->setName($user->getEmail());
                    $this->getUserRepo()->save($user);
                    $this->webUser->login($user);

                    return $this->redirect($this->url('about/index'));
                }
            }
        }

        return $this->render('auth/register', ['user' => $user]);
    }

    public function logout(): RedirectResponse
    {
        $this->webUser->logout();

        return $this->redirect($this->url('about/index'));
    }

    private function getUserRepo(): Repository
    {
        return $this->repository(User::class);
    }

    private function findUserByEmail(string $email): ?User
    {
        return $this->getUserRepo()->findOne(['email' => $email]);
    }
}
