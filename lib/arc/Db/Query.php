<?php declare(strict_types=1);

namespace Arc\Db;

class Query
{
    private string $select = '*';
    private string $from = '';
    private array $conditions = [];
    private array $params = [];
    private ?int $limit = null;
    private ?int $offset = null;
    private ?string $orderBy = null;

    public function __construct(private \PDO $pdo) {}

    public function select(array|string $fields = '*'): self
    {
        $this->select = is_array($fields) ? implode(', ', $fields) : $fields;

        return $this;
    }

    public function from(string $table): self
    {
        $this->from = $table;

        return $this;
    }

    public function where(array $conditions): self
    {
        $this->conditions = [];
        $this->params = [];

        return $this->andWhere($conditions);
    }

    public function andWhere(array $conditions): self
    {
        foreach ($conditions as $column => $value) {
            $this->conditions[] = $column . " = ?";
            $this->params[] = $value;
        }

        return $this;
    }

    public function limit(int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    public function offset(int $offset): self
    {
        $this->offset = $offset;

        return $this;
    }

    public function orderBy(array $fields): self
    {
        $orders = [];
        foreach ($fields as $column => $direction) {
            if (is_int($column)) {
                $column = $direction;
                $direction = 'ASC';
            }
            $orders[] = $column . ' ' . $direction;
        }
        $this->orderBy = implode(', ', $orders);

        return $this;
    }

    public function insert(array $values): int
    {
        if (empty($values)) {
            throw new \InvalidArgumentException("Values array cannot be empty");
        }

        $columns = implode(', ', array_keys($values));
        $placeholders = implode(', ', array_fill(0, count($values), '?'));
        $params = array_values($values);
        $sql = sprintf('INSERT INTO %s (%s) VALUES (%s)', $this->from, $columns, $placeholders);
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $lastId = $this->pdo->lastInsertId();
        if (!$lastId) {
            throw new \RuntimeException('Could not get lastInsertId after insert');
        }

        return (int) $lastId;
    }

    public function update(array $values): int
    {
        $setArr = array_map(fn($col) => $col . " = ?", array_keys($values));
        $params = array_values($values);
        $set = implode(', ', $setArr);
        $sql = sprintf('UPDATE %s SET %s', $this->from, $set);
        $sql .= $this->buildWhere();
        $sql .= $this->buildLimit();
        $params = array_merge($params, array_values($this->params));
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->rowCount();
    }

    public function delete(): int
    {
        $sql = "DELETE FROM " . $this->from . $this->buildWhere();
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->params);

        return $stmt->rowCount();
    }

    public function all(): array
    {
        $sql = $this->buildSelectQuery();
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->params);

        return $stmt->fetchAll();
    }

    public function one(): ?array
    {
        $this->limit = 1;
        $sql = $this->buildSelectQuery();
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->params);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function count(): int
    {
        $sql = "SELECT COUNT(*) FROM " . $this->from . $this->buildWhere();
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->params);

        return (int) $stmt->fetchColumn();
    }

    private function buildSelectQuery(): string
    {
        $sql = "SELECT " . $this->select . " FROM " . $this->from;
        $sql .= $this->buildWhere();
        $sql .= $this->buildOrderBy();
        $sql .= $this->buildLimit();
        $sql .= $this->buildOffset();

        return $sql;
    }

    private function buildWhere(): string
    {
        return count($this->conditions) > 0 ? " WHERE " . implode(" AND ", $this->conditions) : '';
    }

    private function buildOrderBy(): string
    {
        return $this->orderBy !== null ? " ORDER BY " . $this->orderBy : '';
    }

    private function buildLimit(): string
    {
        return $this->limit !== null ? " LIMIT " . $this->limit : '';
    }

    private function buildOffset(): string
    {
        return $this->offset !== null ? " OFFSET " . $this->offset : '';
    }
}
