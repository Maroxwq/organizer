<?php declare(strict_types=1);

namespace Org\Controller;

use Arc\Framework\Controller;
use Arc\Http\RedirectResponse;
use Arc\Http\Response;
use Arc\Validator\ModelValidator;
use Arc\Validator\PasswordValidator;
use Org\Model\User;
use Arc\Db\Repository;

class AuthController extends Controller
{
    public function before(): bool|Response
    {
        $this->view->setLayout('auth_layout');

        return parent::before();
    }

    public function login()
    {
        $errors = [];
        $email = '';
        if ($this->request->isPost()) {
            $email = trim($this->request->post('email'));
            $password = trim($this->request->post('password'));
            $user = $this->findUserByEmail($email);
            if (!$user) {
                $errors[] = "User not found";
            } elseif (!$user->checkPassword($password)) {
                $errors[] = "Incorrect password";
            } else {
                $this->webUser->login($user);

                return new RedirectResponse('/about');
            }
        }

        return $this->render('auth/login', ['errors' => $errors, 'email'  => $email]);
    }

    public function register()
    {
        $errors = [];
        $email = '';
        if ($this->request->isPost()) {
            $email = trim($this->request->post('email'));
            $password = trim($this->request->post('password'));
            $user = (new User())->setEmail($email)->setName($email);
            $errors = (new ModelValidator())->validate($user);
            if ($this->findUserByEmail($email)) {
                $errors['email'][] = "Email already exists";
            }
            $passwordValidator = new PasswordValidator();
            $passwordValidationResult = $passwordValidator->validate($password, ['minLength' => 6]);
            if ($passwordValidationResult !== true) {
                $errors['password'] = (array)$passwordValidationResult;
            }
            if (!empty($errors)) {
                return $this->render('auth/register', ['errors' => $errors, 'email' => $email]);
            }
            $user->setPasswordPlain($password);
            $this->getUserRepo()->save($user);
            $this->webUser->login($user);

            return new RedirectResponse('/about');
        }

        return $this->render('auth/register', ['errors' => $errors, 'email' => $email,]);
    }

    public function logout(): RedirectResponse
    {
        $this->webUser->logout();

        return new RedirectResponse('/about');
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
