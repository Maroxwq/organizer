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
        $rows = $this->query()->where($where)->all();
        $models = [];
        foreach ($rows as $row) {
            $models[] = $this->modelDefinition->createModelFromArray($row);
        }

        return $models;
    }

    public function findOne(array|int $where): ?Model
    {
        if (is_int($where)) {
            $where = ['id' => $where];
        }
        $row = $this->query()->where($where)->limit(1)->one();

        return $row ? $this->modelDefinition->createModelFromArray($row) : null;
    }

    public function save(Model $model): bool
    {
        $data = $model->asArray();
        if ($model->isNew()) {
            $id = $this->query()->insert($data);
            if ($id) {
                $model->setId((int)$id);

                return true;
            }

            return false;
        }

        return $this->query()->where(['id' => $model->getId()])->update($data) > 0;
    }

    public function delete(int $id): bool
    {
        return $this->query()->where(['id' => $id])->delete() > 0;
    }
}
