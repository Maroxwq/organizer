<?php declare(strict_types=1);

namespace Arc\Db;

interface QueryInterface
{
    public function select(array|string $fields = '*'): self;
    public function from(string $table): self;
    public function where(array $conditions): self;
    public function andWhere(array $conditions): self;
    public function orWhere(array $conditions): self;
    public function limit(int $limit): self;
    public function offset(int $offset): self;
    public function orderBy(array $fields): self;
    public function insert(array $values): int;
    public function update(array $values): int;
    public function all(): array;
    public function one(): ?array;
    public function count(): int;
    public function sql(): string;
}
