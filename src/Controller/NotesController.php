<?php declare(strict_types=1);

namespace Org\Controller;

use Arc\Framework\BaseController;
use Arc\Validator\ModelValidator;
use Org\Repository\NoteRepository;
use Org\Model\Note;
use Arc\Http\Request;
use Arc\View\View;

class NotesController extends BaseController
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
        return $this->view->render('notes/index', ['notes' => $notes]);
    }

    public function add(): string
    {
        return $this->handleForm(new Note, 'add');
    }

    public function edit(array $params): string
    {
        $note = $this->repository->getById((int)$params['id']);
        return $this->handleForm($note, 'edit');
    }

    public function delete(array $params): string
    {
        $this->repository->deleteNote((int) $params['id']);
        header('Location: /notes');
        return '';
    }

    public function viewNote(array $params): string
    {
        $id = (int)$params['id'];
        $note = $this->repository->getById($id);

        if ($note === null) {
            throw new \RuntimeException('Note not found for ID: ' . $id);
        }

        return $this->view->render('notes/view', ['note' => $note]);
    }

    private function handleForm(Note $note, string $templateName): string
    {
        $errors = [];
        $post = $this->request->getPost();
        if ($this->request->isPost() && isset($post['content'], $post['color'])) {
            if ($note->load($post) && empty($errors = (new ModelValidator())->validate($note))) {
                $this->repository->save($note);
                header('Location: /notes');
                return '';
            }
        }
    
        return $this->view->render('notes/' . $templateName, ['errors' => $errors, 'note' => $note]);
    }
    
}
