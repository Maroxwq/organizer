<?php declare(strict_types=1);

namespace Org\Controller;

use Org\Core\BaseController;
use Org\Core\Validator\ModelValidator;
use Org\Core\View;
use Org\Repository\NoteRepository;

class NotesController extends BaseController
{
    private NoteRepository $repository;

    public function __construct()
    {
        parent::__construct();
        $this->repository = new NoteRepository();
        $this->view()->setLayout('layout');
    }

    public function index()
    {
        $notes = $this->repository->findAll();

        return $this->view()->render('notes/index', ['notes' => $notes]);
    }

    public function add()
    {
        return $this->view()->render('notes/add');
    }

    public function save()
    {
        $content = $_POST['content'];
        $color = $_POST['color'];

        $note = new \Org\Model\Note(htmlspecialchars($content), htmlspecialchars($color));
        $validator = new ModelValidator();
        $errors = $validator->validate($note);
        if (!empty($errors)) {
            return $this->view()->render('notes/add', ['errors' => $errors, 'content' => $content, 'color' => $color]);
        }
        $repository = new \Org\Repository\NoteRepository();
        $repository->addNew($note);
        header('Location: /notes');
    }

    public function edit()
    {
        $id = $_POST['id'];
        $note = $this->repository->getById((int)$id);
    
        return $this->view()->render('notes/edit', ['note' => $note]);
    }

    public function update()
    {
        $id = $_POST['id'];
        $content = $_POST['content'];
        $color = $_POST['color'];

        $note = $this->repository->getById((int)$id);
        $note->changeContent(htmlspecialchars($content));
        $note->changeColor(htmlspecialchars($color));
        $validator = new ModelValidator();
        $errors = $validator->validate($note);
        if (!empty($errors)) {
            return $this->view()->render('notes/edit', ['errors' => $errors, 'note' => $note]);
        }
        $this->repository->updateNote($note);
        header('Location: /notes');
    }

    public function delete()
    {
        $id = $_POST['id'];
        $this->repository->deleteNote((int)$id);
        header('Location: /notes');
    }

    public function viewNote(array $params)
    {
        print_r($params);
        $id = (int) $params['id'];
        $repository = new NoteRepository();
        $note = $repository->getById($id);

        if ($note === null) {
            throw new \RuntimeException('Note not found for ID: ' . $id);
        }

        return $this->view()->render('notes/view', ['note' => $note]);
    }
}
