<?php declare(strict_types=1);

namespace Org\Repository;

use Arc\Db\Repository;
use Org\Model\Post;
use PDO;

class PostRepository extends Repository
{
    public function __construct()
    {
        $pdo = new PDO('sqlite:' . realpath(__DIR__ . '/db.db'));
        parent::__construct($pdo, Post::class);
    }

    public function findAll(): array
    {
        return $this->findBy([]);
    }

    public function deletePost(int $id): bool
    {
        return $this->delete($id);
    }
}
