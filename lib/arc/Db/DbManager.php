<?php declare(strict_types=1);

namespace Arc\Db;

class DbManager
{
    private ?\PDO $pdo = null;
    private array $repositories = [];

    public function __construct(private array $dbConfig) {}

    public function getConnection(): \PDO
    {
        if ($this->pdo === null) {
            $this->pdo = new \PDO('sqlite:' . $this->dbConfig['db_path']);
        }

        return $this->pdo;
    }

    public function getRepository(string $modelClass): Repository
    {
        if (!isset($this->repositories[$modelClass])) {
            $modelDefinition = new ModelDefinition($modelClass);
            $repoClassName = $modelDefinition->getRepositoryClass();
            $this->repositories[$modelClass] = new $repoClassName($this->getConnection(), $modelDefinition);
        }

        return $this->repositories[$modelClass];
    }
}
