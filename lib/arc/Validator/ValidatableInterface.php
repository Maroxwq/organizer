<?php declare(strict_types=1);

namespace Arc\Validator;

interface ValidatableInterface
{
    public function validationRules(): array;
    public function addError(string $field, string $message): static;
    public function getErrors(): array;
    public function getError(string $field): ?string;
    public function hasErrors(): bool;
    public function hasError(): bool;
}