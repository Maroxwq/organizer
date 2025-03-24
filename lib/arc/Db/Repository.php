<?php declare(strict_types=1);

namespace Arc\Db;

class Repository
{
    public function __construct(protected \PDO $pdo, private ModelDefinition $modelDefinition) {}

    public function findAll(): array
    {
        $table = $this->modelDefinition->tableName();
        $q = (new Query($this->pdo))
            ->select()
            ->from($table);
        $rows = $q->all();
        $modelClass = $this->modelDefinition->getModelClass();
        $models = [];
        foreach ($rows as $row) {
            $models[] = $modelClass::staticCreateFromArray($row);
        }

        return $models;
    }

    public function findBy(array $where): array
    {
        $table = $this->modelDefinition->tableName();
        $q = (new Query($this->pdo))
            ->select()
            ->from($table)
            ->where($where);
        $rows = $q->all();
        $modelClass = $this->modelDefinition->getModelClass();
        $models = [];
        foreach ($rows as $row) {
            $models[] = $modelClass::staticCreateFromArray($row);
        }

        return $models;
    }

    public function findOne(array|int $where): ?Model
    {
        if (is_int($where)) {
            $where = ['id' => $where];
        }
        $table = $this->modelDefinition->tableName();
        $q = (new Query($this->pdo))
            ->select()
            ->from($table)
            ->where($where)
            ->limit(1);
        $row = $q->one();
        if (!$row) {
            return null;
        }
        $modelClass = $this->modelDefinition->getModelClass();

        return $modelClass::staticCreateFromArray($row);
    }

    public function save(Model $model): bool
    {
        $table = $this->modelDefinition->tableName();
        $attributes = $this->modelDefinition->attributes();
        $data = [];
        foreach ($attributes as $attr) {
            $method = 'get' . ucfirst($attr);
            $data[$attr] = $model->$method();
        }
        if ($model->isNew()) {
            $q = (new Query($this->pdo))->from($table);
            $id = $q->insert($data);
            if ($id) {
                $model->setId((int)$id);

                return true;
            }

            return false;
        } else {
            $q = (new Query($this->pdo))
                ->from($table)
                ->where(['id' => $model->getId()]);
            $affected = $q->update($data);

            return $affected > 0;
        }
    }

    public function delete(int $id): bool
    {
        $table = $this->modelDefinition->tableName();
        $sql = "DELETE FROM " . $table . " WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([$id]);
    }
}
