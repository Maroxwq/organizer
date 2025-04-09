<?php declare(strict_types=1);

namespace Org\Controller;

use Arc\Framework\Controller;
use Arc\Http\RedirectResponse;
use Arc\Http\Response;
use Arc\Validator\ModelValidator;
use Org\Model\User;

class AuthController extends Controller {
    public function before(): bool|Response
    {
        $this->view->setLayout(null);

        return parent::before();
    }

    public function login()
    {
        if ($this->request->isPost()) {
            $email = trim($this->request->post('email'));
            $password = trim($this->request->post('password'));
            $userData = $this->repository(User::class)->query()->where(['email' => $email])->one();
            $user = $userData ? User::fromArray($userData) : null;

            if (!$user) {
                $this->view->session()->setFlash('error', "User not found");
            } elseif (!$user->checkPassword($password)) {
                $this->view->session()->setFlash('error', "Incorrect password");
            } else {
                $this->webUser->login($user);

                return new RedirectResponse('/about');
            }
        }

        return $this->render('auth/login');
    }

    public function register()
    {
        if ($this->request->isPost()) {
            $email    = trim($this->request->post('email'));
            $password = trim($this->request->post('password'));
            $user   = (new User())->setEmail($email)->setName($email);
            $errors = (new ModelValidator())->validate($user);

            if ($this->repository(User::class)->query()->where(['email' => $email])->one()) {
                $errors['email'][] = "Email already exists";
            }
            if (empty($password)) {
                $errors['password'][] = "Password is required";
            } elseif (strlen($password) < 6) {
                $errors['password'][] = "Password must be at least 6 characters";
            }
            if (empty($errors)) {
                $user->setPasswordHash($password);
                $this->repository(User::class)->save($user);
                $this->webUser->login($user);

                return new RedirectResponse('/about');
            }

            $allErrors = [];
            foreach ($errors as $fieldErrors) {
                foreach ($fieldErrors as $error) {
                    $allErrors[] = $error;
                }
            }
            $this->view->session()->setFlash('error', implode(" | ", $allErrors));
        }

        return $this->render('auth/register');
    }

    public function logout(): RedirectResponse
    {
        $this->webUser->logout();

        return new RedirectResponse('/about');
    }
}
