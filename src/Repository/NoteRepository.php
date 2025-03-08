<?php declare(strict_types=1);

namespace Org\Repository;

use Arc\Db\Repository;
use Org\Model\Note;
use PDO;

class NoteRepository extends Repository
{
    public function __construct()
    {
        $pdo = new PDO('sqlite:' . realpath(__DIR__ . '/db.db'));
        parent::__construct($pdo, Note::class);
    }

    public function findAll(): array
    {
        return $this->findBy([]);
    }

    public function deleteNote(int $id): bool
    {
        return $this->delete($id);
    }
}
