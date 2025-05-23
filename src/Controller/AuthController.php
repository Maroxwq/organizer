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
            $email = trim($this->request->post('email'));
            $password = trim($this->request->post('passwordPlain'));
            $user->setEmail($email);
            $found = $this->findUserByEmail($email);
            if ($found && $found->checkPassword($password)) {
                $this->webUser->login($found);

                return $this->redirectToRoute('about/index');
            }
            $error = 'Invalid email or password';
        }

        return $this->render('auth/login', ['user' => $user, 'error' => $error ?? null]);
    }

    public function register(): Response|string
    {
        $user = new User();
        $repo = $this->getUserRepo();
        if ($this->request->isPost() && $user->load($this->request->post()) && $user->isValid()) {
            if ($repo->findOne(['email' => $user->getEmail()])) {
                $user->addError('email', 'Email already exists');
            } else {
                $user->setName($user->getEmail());
                $repo->save($user);
                $this->webUser->login($user);

                return $this->redirectToRoute('about/index');
            }
        }

        return $this->render('auth/register', ['user' => $user]);
    }

    public function logout(): RedirectResponse
    {
        $this->webUser->logout();

        return $this->redirectToRoute('about/index');
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
