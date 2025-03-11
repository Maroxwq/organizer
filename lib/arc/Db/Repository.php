<?php declare(strict_types=1);

namespace Arc\Db;

abstract class Repository
{
    public function __construct(protected \PDO $pdo, private string $modelClass) {}

    public function findBy(array $where = []): array
    {
        $table = $this->tableName();
        $attributes = $this->attributes();

        $sql = "SELECT * FROM " . $table;
        $params = [];
        $first = true;

        foreach ($where as $column => $value) {
            if (!in_array($column, $attributes) && $column !== 'id') {
                continue;
            }
            if ($first) {
                $sql .= " WHERE " . $column . " = ?";
                $first = false;
            } else {
                $sql .= " AND " . $column . " = ?";
            }
            $params[] = $value;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll();

        $results = [];
        foreach ($rows as $row) {
            $modelClass = $this->modelClass;
            $model = new $modelClass();
            if (method_exists($model, 'fromDbRow')) {
                $model->fromDbRow($row);
            }
            $results[] = $model;
        }
        
        return $results;
    }

    public function findOne(array|int $where): ?Model
    {
        if (is_int($where)) {
            return $this->findBy(['id' => $where])[0] ?? null;
        }
        return $this->findBy($where)[0] ?? null;
    }

    public function save(Model $model): bool
    {
        $table = $this->tableName();
        $attributes = $this->attributes();
        $data = [];
        foreach ($attributes as $attr) {
            $getter = 'get' . ucfirst($attr);
            if (method_exists($model, $getter)) {
                $data[$attr] = $model->$getter();
            }
        }
        if ($model->getId() === null) {
            $columns = "";
            $placeholders = "";
            $params = [];
            $first = true;

            foreach ($data as $column => $value) {
                if ($first) {
                    $columns .= $column;
                    $placeholders .= "?";
                    $first = false;
                } else {
                    $columns .= ", " . $column;
                    $placeholders .= ", ?";
                }

                $params[] = $value;
            }

            $sql = "INSERT INTO " . $table . " (" . $columns . ") VALUES (" . $placeholders . ")";
            $stmt = $this->pdo->prepare($sql);
            $success = $stmt->execute($params);

            if ($success) {
                $id = (int)$this->pdo->lastInsertId();
                if (method_exists($model, 'setId')) {
                    $model->setId($id);
                }
            }

            return $success;
        } else {
            $setClause = "";
            $params = [];
            $first = true;

            foreach ($data as $column => $value) {
                if ($first) {
                    $setClause .= $column . " = ?";
                    $first = false;
                } else {
                    $setClause .= ", " . $column . " = ?";
                }
                $params[] = $value;
            }

            $params[] = $model->getId();
            $sql = "UPDATE " . $table . " SET " . $setClause . " WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);

            return $stmt->execute($params);
        }
    }

    public function delete(int $id): bool
    {
        $table = $this->tableName();
        $sql = "DELETE FROM " . $table . " WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([$id]);
    }

    protected function tableName(): string
    {
        return $this->modelClass::tableName();
    }

    protected function attributes(): array
    {
        return $this->modelClass::attributes();
    }
}
