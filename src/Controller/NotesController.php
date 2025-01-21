<?php declare(strict_types=1);

namespace Org\Controller;

use Org\Core\BaseController;
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
        $errors = [];

        if (strlen($content) > 256) {
            $errors[] = 'контент слишком длинный';
        }

        if (strlen($color) > 50) {
            $errors[] = 'цвет слишком длинный';
        } elseif (!preg_match('/^#[A-Fa-f0-9]{1,6}$/', $color)) {
            $errors[] = 'цвет должен выглядеть так #000000';
        }

        if (!empty($errors)) {
            return $this->view()->render('notes/add', ['errors' => $errors, 'content' => htmlspecialchars($content), 'color' => htmlspecialchars($color)]);
        }

        $repository = new \Org\Repository\NoteRepository();
        $note = new \Org\Model\Note(htmlspecialchars($content), htmlspecialchars($color));
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
        $errors = [];

        if (strlen($content) > 256) {
            $errors[] = 'контент слишком длинный';
        }

        if (strlen($color) > 50) {
            $errors[] = 'цвет слишком длинный';
        } elseif (!preg_match('/^#[A-Fa-f0-9]{1,6}$/', $color)) {
            $errors[] = "цвет должен выглядеть так: #000000";
        }
        
        if (!empty($errors)) {
            $note = $this->repository->getById((int)$id);
            return $this->view()->render('notes/edit', ['errors' => $errors,'note' => $note]);
        }

        $note = $this->repository->getById((int)$id);
        $note->changeContent(htmlspecialchars($content));
        $note->changeColor(htmlspecialchars($color));
        $this->repository->updateNote($note);
        header('Location: /notes');
    }

    public function delete()
    {
        $id = $_POST['id'];
        $this->repository->deleteNote((int)$id);
        header('Location: /notes');
    }
}
