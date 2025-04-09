<?php declare(strict_types = 1);

namespace Arc\Security;

interface IdentityInterface {
    public function getUserId(): string;
    public function getName(): string;
}
