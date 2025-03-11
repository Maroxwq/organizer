<?php declare(strict_types=1);

namespace Org\Repository;

use Arc\Db\Repository;
use Org\Model\Note;
use PDO;

class NoteRepository extends Repository
{
    public function __construct(?\PDO $pdo = null)
    {
        if (!$pdo) {
            $pdo = new PDO('sqlite:' . realpath(__DIR__ . '/db.db'));
        }
        parent::__construct($pdo, Note::class);
    }

    /**
     * @return Note[]
     */
    public function findAll(): array
    {
        return $this->findBy([]);
    }

    public function getById(int $id): ?Note
    {
        return $this->findOne($id);
    }

    public function deleteNote(int $id): void
    {
        $this->delete($id);
    }
}
