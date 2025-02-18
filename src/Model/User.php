<?php declare(strict_types=1);

namespace Org\Model;

class User
{
    private int $id;
    private string $firstName;
    private string $lastName;
    private int $age;

    public function __construct(string $firstName, string $lastName, int $age)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->age = $age;
    }

    public function validationRules(): array
    {
        return [
            ['firstName' => ['required' => true]],
            ['firstName' => ['string' => ['maxLength' => 100, 'minLength' => 3]]],
            ['lastName' => ['string' => ['maxLength' => 100, 'minLength' => 3]]],
            ['age' => ['int' => ['max' => 100, 'min' => 12]]],
        ];
    }

    public function load(): void
    {
        
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getAge(): int
    {
        return $this->age;
    }
}
