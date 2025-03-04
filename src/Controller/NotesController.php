<?php declare(strict_types=1);

namespace Org\Controller;

use Arc\Framework\Controller;
use Arc\Validator\ModelValidator;
use Org\Repository\NoteRepository;
use Org\Model\Note;
use Arc\Http\Request;
use Arc\View\View;

class NotesController extends Controller
{
    private NoteRepository $repository;

    public function __construct(Request $request, View $view)
    {
        parent::__construct($request, $view);
        $this->repository = new NoteRepository();
        $this->view->setLayout('layout');
    }

    public function index(): string
    {
        $notes = $this->repository->findAll();
        return $this->render('notes/index', ['notes' => $notes]);
    }

    public function add(): string
    {
        return $this->handleForm(new Note, 'add');
    }

    public function edit(int $id): string
    {
        return $this->handleForm($this->repository->getById($id), 'edit');
    }

    public function delete(int $id): string
    {
        $this->repository->deleteNote($id);
        header('Location: /notes');
        return '';
    }

    public function viewNote(int $id): string
    {
        $note = $this->repository->getById($id);

        if ($note === null) {
            throw new \RuntimeException('Note not found for ID: ' . $id);
        }

        return $this->render('notes/view', ['note' => $note]);
    }

    private function handleForm(Note $note, string $templateName): string
    {
        $errors = [];
        if ($this->request->isPost() &&
            $note->load($this->request->post()) &&
            empty($errors = (new ModelValidator())->validate($note))
        ) {
            $this->repository->save($note);
            header('Location: /notes');

            return '';
        }

        return $this->render('notes/' . $templateName, ['errors' => $errors, 'note' => $note]);
    }
}
