<?php declare(strict_types=1);

namespace Arc\Db;

use PDO;

abstract class Repository
{
    public function __construct(protected PDO $pdo, private string $modelClass) {}

    public function findBy(int|array $where = []): array
    {
        if (is_int($where)) {
            $where = ['id' => $where];
        }
        
        $table = $this->modelClass::tableName();
        $sql = "SELECT * FROM " . $table;
        
        if (!empty($where)) {
            $conditions = "";
            foreach ($where as $key => $value) {
                if ($conditions !== "") {
                    $conditions .= " AND ";
                }
                $conditions .= $key . " = :" . $key;
            }
            $sql .= " WHERE " . $conditions;
        }
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($where);
        $rows = $stmt->fetchAll();
        $models = [];
        
        foreach ($rows as $row) {
            $model = new $this->modelClass();
            $model->fromDbRow($row);
            $models[] = $model;
        }
        return $models;
    }

    public function findOne(int|array $where): ?Model
    {
        $results = $this->findBy($where);
        return count($results) > 0 ? $results[0] : null;
    }

    public function getById(int $id): ?Model
    {
        return $this->findOne($id);
    }

    public function save(Model $model): bool
    {
        $table = get_class($model)::tableName();
        $attributes = get_class($model)::attributes();
        
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
            foreach ($data as $key => $value) {
                if ($columns !== "") {
                    $columns .= ", ";
                    $placeholders .= ", ";
                }
                $columns .= $key;
                $placeholders .= ":" . $key;
            }
            $sql = "INSERT INTO " . $table . " (" . $columns . ") VALUES (" . $placeholders . ")";
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute($data);
            if ($result) {
                $model->setId((int)$this->pdo->lastInsertId());
            }
            return $result;
        } else {
            $setString = "";
            foreach ($data as $key => $value) {
                if ($setString !== "") {
                    $setString .= ", ";
                }
                $setString .= $key . " = :" . $key;
            }
            $sql = "UPDATE " . $table . " SET " . $setString . " WHERE id = :id";
            $data['id'] = $model->getId();
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($data);
        }
    }

    public function delete(int $id): bool
    {
        $table = $this->modelClass::tableName();
        $sql = "DELETE FROM " . $table . " WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
