<?php declare(strict_types=1);

namespace Arc\Db;

class Repository
{
    public function __construct(
        private \PDO $pdo, 
        private ModelDefinition $modelDefinition
    ) {}

    public function query(): Query
    {
        return (new Query($this->pdo))
            ->from($this->modelDefinition->tableName());
    }

    public function findAll(): array
    {
        return $this->findBy([]);
    }

    public function findBy(array $where): array
    {
        $q = $this->query()->where($where);
        $rows = $q->all();
        $modelClass = $this->modelDefinition->getModelClass();
        $models = [];
        foreach ($rows as $row) {
            $models[] = $modelClass::fromArray($row);
        }

        return $models;
    }

    public function findOne(array|int $where): ?Model
    {
        if (is_int($where)) {
            $where = ['id' => $where];
        }
        $q = $this->query()->where($where)->limit(1);
        $row = $q->one();
        $modelClass = $this->modelDefinition->getModelClass();

        return $row ? $modelClass::fromArray($row) : null;
    }

    public function save(Model $model): bool
    {
        $data = $model->asArray();
        if ($model->isNew()) {
            $q = $this->query();
            $id = $q->insert($data);
            if ($id) {
                $model->setId((int)$id);

                return true;
            }
            return false;
        } else {
            $q = $this->query()->where(['id' => $model->getId()]);
            $affected = $q->update($data);

            return $affected > 0;
        }
    }

    public function delete(int $id): bool
    {
        return $this->query()->where(['id' => $id])->delete() > 0;
    }
}
