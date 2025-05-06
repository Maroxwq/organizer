<?php declare(strict_types=1);

namespace Org\Controller;

use Arc\Framework\Controller;
use Arc\Http\Response;
use Org\Repository\NoteRepository;
use Org\Model\Note;

class NotesController extends Controller
{
    public function index(): string
    {
        $userId = $this->webUser->getIdentity()->getUserId();
        $notes  = $this->repository(Note::class)->findBy(['userId' => $userId]);

        return $this->render('notes/index', [
            'notes' => $notes,
            'message' => $this->view->session()->getFlash('success') ?: null,
        ]);
    }

    public function add(): Response|string
    {
        $note = new Note();
        $note->setUserId((int) $this->webUser->getIdentity()->getUserId());

        return $this->handleForm($note, 'add');
    }

    public function edit(int $id): Response|string
    {
        $note = $this->noteRepository()->findOne($id);

        return $this->handleForm($note, 'edit');
    }

    public function delete(int $id): Response
    {
        $this->noteRepository()->delete($id);

        return $this->redirectToRoute('/notes');
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
            $note->isValid()
        ) {
            $this->noteRepository()->save($note);
            $this->view->session()->setFlash('success', 'Note is successfully saved!');

            return $this->redirect('/notes');
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
