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
            if (is_string($column)) {
                $orders[] = $column . " " . $direction;
            } else {
                $orders[] = $direction;
            }
        }
        $this->orderBy = implode(', ', $orders);
        
        return $this;
    }

    public function insert(array $values): int
    {
        $columnsArr = [];
        $placeholdersArr = [];
        $params = [];
        foreach ($values as $column => $value) {
            $columnsArr[] = $column;
            $placeholdersArr[] = "?";
            $params[] = $value;
        }
        $columns = implode(', ', $columnsArr);
        $placeholders = implode(', ', $placeholdersArr);
        $sql = "INSERT INTO " . $this->from . " (" . $columns . ") VALUES (" . $placeholders . ")";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        
        return (int) $this->pdo->lastInsertId();
    }

    public function update(array $values): int
    {
        $setArr = [];
        $params = [];
        foreach ($values as $column => $value) {
            $setArr[] = $column . " = ?";
            $params[] = $value;
        }
        $set = implode(', ', $setArr);
        $sql = "UPDATE " . $this->from . " SET " . $set;
        $wherePart = $this->buildWherePart();
        if ($wherePart !== '') {
            $sql .= $wherePart;
        }
        if ($this->limit !== null) {
            $sql .= " LIMIT " . $this->limit;
        }
        foreach ($this->params as $p) {
            $params[] = $p;
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        
        return $stmt->rowCount();
    }

    public function delete(): int
    {
        $sql = "DELETE FROM " . $this->from . $this->buildWherePart();
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
        $sql = "SELECT COUNT(*) FROM " . $this->from . $this->buildWherePart();
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->params);

        return (int) $stmt->fetchColumn();
    }

    private function buildSelectQuery(): string
    {
        $sql = "SELECT " . $this->select . " FROM " . $this->from;
        $sql .= $this->buildWherePart();
        $sql .= $this->buildOrderByPart();
        $sql .= $this->buildLimitPart();
        $sql .= $this->buildOffsetPart();
        
        return $sql;
    }

    private function buildWherePart(): string
    {
        if (count($this->conditions) > 0) {
            return " WHERE " . implode(" AND ", $this->conditions);
        }
        
        return '';
    }

    private function buildOrderByPart(): string
    {
        return $this->orderBy !== null ? " ORDER BY " . $this->orderBy : '';
    }

    private function buildLimitPart(): string
    {
        return $this->limit !== null ? " LIMIT " . $this->limit : '';
    }

    private function buildOffsetPart(): string
    {
        return $this->offset !== null ? " OFFSET " . $this->offset : '';
    }
}
