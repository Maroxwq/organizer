<?php declare(strict_types=1);

namespace Org\Repository;

use Org\Model\Post;
use PDO;

class PostRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('sqlite:' . realpath(__DIR__ . '/db.db'));
    }

    /**
     * @return Post[]
     */
    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM posts ORDER BY createdAt DESC');
        $rows = $stmt->fetchAll();
        $posts = [];
        foreach ($rows as $row) {
            $post = new Post('', '');
            $post->fromDbRow($row);
            $posts[] = $post;
        }
        return $posts;
    }

    public function addNew(Post $post): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO posts (title, content, createdAt, updatedAt) VALUES (:title, :content, :createdAt, :updatedAt)');
        $stmt->execute([':title' => $post->getTitle(), ':content' => $post->getContent(), ':createdAt' => $post->getCreatedAt(), ':updatedAt' => $post->getUpdatedAt()]);
    }

    public function updatePost(Post $post): void
    {
        $stmt = $this->pdo->prepare('UPDATE posts SET title = :title, content = :content, updatedAt = :updatedAt WHERE id = :id');
        $stmt->execute([':title' => $post->getTitle(), ':content' => $post->getContent(), ':updatedAt' => $post->getUpdatedAt(), ':id' => $post->getId()]);
    }

    public function save(Post $post): void
    {
        if ($post->getId() === null) {
            $this->addNew($post);
        } else {
            $this->updatePost($post);
        }
    }

    public function deletePost(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM posts WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }

    public function getById(int $id): ?Post
    {
        $stmt = $this->pdo->prepare('SELECT * FROM posts WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        if ($row === false) {
            return null;
        }
        $post = new Post('', '');
        $post->fromDbRow($row);
        return $post;
    }
}
