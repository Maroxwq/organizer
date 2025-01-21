<?php declare(strict_types=1);

namespace Org\Repository;

use Org\Model\Note;
use PDO;

class NoteRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('sqlite:' . realpath(__DIR__ . '/db.db'));
    }

    /**
     * @return Note[]
     */
    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM notes');
        $rows = $stmt->fetchAll();
        $notes = [];
        foreach ($rows as $row) {
            $note = new Note('', '');
            $note->fromDbRow($row);
            $notes[] = $note;
        }

        return $notes;
    }

    public function addNew(Note $note): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO notes (content, dateChanged, color) VALUES (:content, :dateChanged, :color)');
        $stmt->execute([':content' => $note->getContent(), ':dateChanged' => $note->getDateChanged(), ':color' => $note->getColor()]);
    }

    public function updateNote(Note $note): void
    {
        $stmt = $this->pdo->prepare('UPDATE notes SET content = :content, dateChanged = :dateChanged, color = :color WHERE id = :id');
        $stmt->execute([':content' => $note->getContent(), ':dateChanged' => $note->getDateChanged(), ':color' => $note->getColor(), ':id' => $note->getId()]);
    }

    public function deleteNote(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM notes WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }

    public function getById(int $id): Note|null
    {
        $stmt = $this->pdo->query('SELECT * FROM notes WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        if ($row === false) {
            return null;
        }
        $note = new Note('', '');
        $note->fromDbRow($row);

        return $note;
    }
}
