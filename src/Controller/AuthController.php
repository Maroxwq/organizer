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
        $errors = [];
        $email = '';
        if ($this->request->isPost()) {
            $email = trim($this->request->post('email'));
            $password = trim($this->request->post('password'));
            $user = $this->findUserByEmail($email);
            if (!$user || !$user->checkPassword($password)) {
                $errors[] = 'Invalid email or password';
            } else {
                $this->webUser->login($user);

                return $this->redirectToRoute('/about');
            }
        }

        return $this->render('auth/login', ['errors' => $errors, 'email' => $email]);
    }

    public function register(): Response|string
    {
        $errors = [];
        $user   = new User();
        if ($this->request->isPost()) {
            $data = ['email' => trim($this->request->post('email')), 'name' => trim($this->request->post('email'))];
            $password = trim($this->request->post('password'));
            $user->setPasswordPlain($password);
            if ($user->load($data) && $user->isValid()) {
                if ($this->findUserByEmail($user->getEmail())) {
                    $errors['email'] = 'Email already exists';
                } else {
                    $this->getUserRepo()->save($user);
                    $this->webUser->login($user);

                    return $this->redirectToRoute('/about');
                }
            } else {
                $errors = $user->getErrors();
            }
        }

        return $this->render('auth/register', ['user' => $user, 'errors' => $errors]);
    }

    public function logout(): RedirectResponse
    {
        $this->webUser->logout();

        return $this->redirectToRoute('/about');
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
