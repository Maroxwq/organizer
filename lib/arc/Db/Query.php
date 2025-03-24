<?php declare(strict_types=1);

namespace Arc\Db;

class Query implements QueryInterface
{
    protected string $select = '*';
    protected string $from = '';
    protected array $conditions = [];
    protected array $params = [];
    protected ?int $limit = null;
    protected ?int $offset = null;
    protected ?string $orderBy = null;
    protected \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function select(array|string $fields = '*'): self
    {
        if (is_array($fields)) {
            $str = '';
            $first = true;
            foreach ($fields as $field) {
                if (!$first) {
                    $str .= ', ';
                }
                $str .= $field;
                $first = false;
            }
            $this->select = $str;
        } else {
            $this->select = $fields;
        }
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
        foreach ($conditions as $column => $value) {
            $this->conditions[] = $column . " = ?";
            $this->params[] = $value;
        }

        return $this;
    }

    public function andWhere(array $conditions): self
    {
        foreach ($conditions as $column => $value) {
            $this->conditions[] = $column . " = ?";
            $this->params[] = $value;
        }

        return $this;
    }

    public function orWhere(array $conditions): self
    {
        $or = '';
        $first = true;
        foreach ($conditions as $column => $value) {
            if (!$first) {
                $or .= " OR ";
            }
            $or .= $column . " = ?";
            $this->params[] = $value;
            $first = false;
        }
        if ($or !== '') {
            $this->conditions[] = '(' . $or . ')';
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
        $str = '';
        $first = true;
        foreach ($fields as $field) {
            if (!$first) {
                $str .= ', ';
            }
            $str .= $field;
            $first = false;
        }
        $this->orderBy = $str;

        return $this;
    }

    public function insert(array $values): int
    {
        $columns = '';
        $placeholders = '';
        $params = [];
        $first = true;
        foreach ($values as $column => $value) {
            if (!$first) {
                $columns .= ", ";
                $placeholders .= ", ";
            }
            $columns .= $column;
            $placeholders .= "?";
            $params[] = $value;
            $first = false;
        }
        $sql = "INSERT INTO " . $this->from . " (" . $columns . ") VALUES (" . $placeholders . ")";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return (int)$this->pdo->lastInsertId();
    }

    public function update(array $values): int
    {
        $set = '';
        $params = [];
        $first = true;
        foreach ($values as $column => $value) {
            if (!$first) {
                $set .= ", ";
            }
            $set .= $column . " = ?";
            $params[] = $value;
            $first = false;
        }
        $sql = "UPDATE " . $this->from . " SET " . $set;
        if (count($this->conditions) > 0) {
            $whereClause = "";
            $firstCond = true;
            foreach ($this->conditions as $cond) {
                if (!$firstCond) {
                    $whereClause .= " AND ";
                }
                $whereClause .= $cond;
                $firstCond = false;
            }
            $sql .= " WHERE " . $whereClause;
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

    public function all(): array
    {
        $sql = $this->buildSelect();
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->params);

        return $stmt->fetchAll();
    }

    public function one(): ?array
    {
        $this->limit = 1;
        $sql = $this->buildSelect();
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->params);
        $row = $stmt->fetch();

        return $row ? $row : null;
    }

    public function count(): int
    {
        $sql = "SELECT COUNT(*) FROM " . $this->from;
        if (count($this->conditions) > 0) {
            $whereClause = "";
            $firstCond = true;
            foreach ($this->conditions as $cond) {
                if (!$firstCond) {
                    $whereClause .= " AND ";
                }
                $whereClause .= $cond;
                $firstCond = false;
            }
            $sql .= " WHERE " . $whereClause;
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->params);

        return (int)$stmt->fetchColumn();
    }

    public function sql(): string
    {
        return $this->buildSelect();
    }

    protected function buildSelect(): string
    {
        $sql = "SELECT " . $this->select . " FROM " . $this->from;
        if (count($this->conditions) > 0) {
            $whereClause = "";
            $firstCond = true;
            foreach ($this->conditions as $cond) {
                if (!$firstCond) {
                    $whereClause .= " AND ";
                }
                $whereClause .= $cond;
                $firstCond = false;
            }
            $sql .= " WHERE " . $whereClause;
        }
        if ($this->orderBy !== null) {
            $sql .= " ORDER BY " . $this->orderBy;
        }
        if ($this->limit !== null) {
            $sql .= " LIMIT " . $this->limit;
        }
        if ($this->offset !== null) {
            $sql .= " OFFSET " . $this->offset;
        }

        return $sql;
    }
}
