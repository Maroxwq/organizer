<?php declare(strict_types=1);

namespace Arc\Security;

use Arc\Db\Repository;
use Arc\Http\Session;
use Arc\Security\IdentityInterface;

class WebUser {
    public function __construct(private Session $session, private Repository $userRepository) {}

    public function isAuthenticated(): bool
    {
        return $this->session->has('user_id');
    }

    public function getIdentity(): ?IdentityInterface
    {
        if ($this->isAuthenticated()) {
            return $this->userRepository->findOne((int) $this->session->get('user_id'));
        }

        return null;
    }

    public function login(IdentityInterface $identity): bool
    {
        $this->session->set('user_id', $identity->getUserId());

        return true;
    }

    public function logout(): bool
    {
        $this->session->delete('user_id');

        return true;
    }
}
