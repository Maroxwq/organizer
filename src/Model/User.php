<?php declare(strict_types=1);

namespace Org\Model;

use Arc\Db\Model;
use Arc\Security\IdentityInterface;

class User extends Model implements IdentityInterface
{
    private string $email = "";
    private string $name = "";
    private string $passwordHash = "";
    private string $passwordPlain = "";

    public static function tableName(): string
    {
        return 'users';
    }

    public static function attributes(): array
    {
        return ['email', 'name', 'passwordHash'];
    }

    public function validationRules(): array
    {
        return [
            ['email' => ['required' => true]],
            ['email' => ['string' => ['minLength' => 10, 'maxLength' => 50]]],
            ['passwordPlain' => ['password' => ['minLength' => 6]]],
        ];
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getName(): string
    {
        return $this->name ?: $this->email;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setPasswordPlain(string $password): self
    {
        $this->passwordPlain = $password;
        $this->passwordHash = sha1($password);

        return $this;
    }

    public function setPasswordHash(string $hash): self
    {
        $this->passwordHash = $hash;

        return $this;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    public function getPasswordPlain(): string
    {
        return $this->passwordPlain;
    }

    public function checkPassword(string $password): bool
    {
        return $this->passwordHash === sha1($password);
    }

    public function getUserId(): string
    {
        return (string) parent::getId();
    }
}
