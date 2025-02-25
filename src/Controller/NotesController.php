<?php declare(strict_types=1);

namespace Org\Controller;

use Arc\Framework\BaseController;
use Arc\Validator\ModelValidator;
use Org\Repository\NoteRepository;
use Org\Model\Note;

class NotesController extends BaseController
{
    private NoteRepository $repository;

    public function __construct()
    {
        parent::__construct();
        $this->repository = new NoteRepository();
        $this->view()->setLayout('layout');
    }

    public function index(): string
    {
        var_dump($_GET);
        $notes = $this->repository->findAll();

        return $this->view()->render('notes/index', ['notes' => $notes]);
    }

    public function add(): string
    {
        return $this->handleForm(new Note, 'add');
    }

    public function edit(array $params): string
    {
        return $this->handleForm($this->repository->getById((int) $params['id']), 'edit');
    }

    public function delete(): string
    {
        $id = $_POST['id'];
        $this->repository->deleteNote((int)$id);
        header('Location: /notes');
        return '';
    }

    public function viewNote(array $params): string
    {
        $id = (int) $params['id'];
        $repository = new NoteRepository();
        $note = $repository->getById($id);

        if ($note === null) {
            throw new \RuntimeException('Note not found for ID: ' . $id);
        }

        return $this->view->render('notes/view', ['note' => $note]);
    }

    private function handleForm(Note $note, string $templateName): string
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
            $note->load($_POST) &&
            empty($errors = (new ModelValidator())->validate($note))
        ) {
            $this->repository->save($note);
            header('Location: /notes');

            return '';
        }

        return $this->view()->render('notes/' . $templateName, ['errors' => $errors, 'note' => $note]);
    }
}
