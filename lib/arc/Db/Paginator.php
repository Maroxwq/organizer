<?php declare(strict_types=1);

namespace Arc\Db;

class Paginator
{
    private int $totalItems;
    private int $totalPages;

    public function __construct(private Query $query, private string $modelClass, private int $page, private int $perPage)
    {
        $this->totalItems = $query->count();
        $this->totalPages = (int) ceil($this->totalItems / $this->perPage);
        $this->page = max(1, min($this->page, $this->totalPages));
    }

    public function getCurrentPage(): int
    {
        return $this->page;
    }

    public function getPagesTotal(): int
    {
        return $this->totalPages;
    }

    public function hasPrevious(): bool
    {
        return $this->page > 1;
    }

    public function hasNext(): bool
    {
        return $this->page < $this->totalPages;
    }

    public function getPreviousPage(): int
    {
        return $this->page - 1;
    }

    public function getNextPage(): int
    {
        return $this->page + 1;
    }

    public function getItems(): array
    {
        return array_map([$this->modelClass, 'fromArray'], $this->query->limit($this->perPage)->offset(($this->page - 1) * $this->perPage)->all());
    }

    public function isPaginatable(): bool
    {
        return $this->totalPages > 1;
    }
}
