<?php declare(strict_types=1);

namespace Arc\Db;

class DbManager
{
    private ?\PDO $pdo = null;

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
        $modelDefinition = new ModelDefinition($modelClass);
        $repoClassName = $modelDefinition->getRepositoryClass();
    
        return new $repoClassName($this->getConnection(), $modelDefinition);
    }
}
