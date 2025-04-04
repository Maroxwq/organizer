<?php declare(strict_types=1);

namespace Org\Controller;

use Arc\Framework\Controller;
use Arc\Http\RedirectResponse;
use Arc\Http\Response;
use Arc\Validator\ModelValidator;
use Org\Repository\NoteRepository;
use Org\Model\Note;

class NotesController extends Controller
{
    public function index(): string
    {
        $notes = $this->noteRepository()->findAll();

        return $this->render('notes/index', ['notes' => $notes]);
    }

    public function add(): Response|string
    {
        return $this->handleForm(new Note, 'add');
    }

    public function edit(int $id): Response|string
    {
        $note = $this->noteRepository()->findOne($id);

        return $this->handleForm($note, 'edit');
    }

    public function delete(int $id): Response
    {
        $this->noteRepository()->delete($id);

        return new RedirectResponse('/notes');
    }

    public function viewNote(int $id): string
    {
        $note = $this->noteRepository()->findOne($id);
        if ($note === null) {
            throw new \RuntimeException('Note not found for ID: ' . $id);
        }

        return $this->render('notes/view', ['note' => $note]);
    }

    private function handleForm(Note $note, string $templateName): Response|string
    {
        $errors = [];
        if (
            $this->request->isPost() &&
            $note->load($this->request->post()) &&
            empty($errors = (new ModelValidator())->validate($note))
        ) {
            $this->noteRepository()->save($note);

            return new RedirectResponse('/notes');
        }

        return $this->render('notes/' . $templateName, ['errors' => $errors, 'note' => $note]);
    }

    private function noteRepository(): NoteRepository
    {
        /** @var NoteRepository $repo */
        $repo = $this->repository(Note::class);

        return $repo;
    }
}
