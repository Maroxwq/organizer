<?php declare(strict_types=1);

namespace Org\Repository;

use Arc\Db\Repository;
use Org\Model\Post;
use PDO;

class PostRepository extends Repository
{
    public function __construct(?\PDO $pdo = null)
    {
        if (!$pdo) {
            $pdo = new PDO('sqlite:' . realpath(__DIR__ . '/db.db'));
        }
        parent::__construct($pdo, Post::class);
    }

    /**
     * @return Post[]
     */
    public function findAll(): array
    {
        return $this->findBy([]);
    }

    public function getById(int $id): ?Post
    {
        return $this->findOne($id);
    }

    public function deletePost(int $id): void
    {
        $this->delete($id);
    }
}
