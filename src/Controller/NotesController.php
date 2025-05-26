<?php declare(strict_types=1);

namespace Org\Controller;

use Arc\Framework\Controller;
use Arc\Http\Response;
use Org\Repository\NoteRepository;
use Org\Model\Note;
use Arc\Db\Paginator;

class NotesController extends Controller
{
    public function index(): string
    {
        $userId = $this->webUser->getIdentity()->getUserId();
        $page = (int) $this->request->query('page', 1);
        $perPage = 6;
        $query = $this->noteRepository()->query()->where(['userId' => $userId]);
        $paginator = new Paginator($query, Note::class, $page, $perPage);

        return $this->render('notes/index', [
            'paginator' => $paginator,
            'message' => $this->session()->getFlash('success') ?: null,
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
        $note = $this->requireNote($id);

        return $this->handleForm($note, 'edit');
    }

    public function delete(int $id): Response
    {
        $this->requireNote($id);
        $this->noteRepository()->delete($id);

        return $this->redirectToRoute('notes/index');
    }

    public function viewNote(int $id): string
    {
        $note = $this->requireNote($id);

        return $this->render('notes/view', ['note' => $note]);
    }

    private function handleForm(Note $note, string $templateName): Response|string
    {
        if (
            $this->request->isPost() &&
            $note->load($this->request->post()) &&
            $note->isValid()
        ) {
            $this->noteRepository()->save($note);
            $this->session()->setFlash('success', 'Note is successfully saved!');

            return $this->redirectToRoute('notes/index');
        }

        return $this->render('notes/form', ['note' => $note]);
    }

    private function noteRepository(): NoteRepository
    {
        /** @var NoteRepository $repo */
        $repo = $this->repository(Note::class);

        return $repo;
    }

    private function requireNote(int $id): Note
    {
        $note = $this->noteRepository()->findOne($id);
        if ($note === null) {
            throw new \RuntimeException('Note not found for ID: ' . $id);
        }

        return $note;
    }
}
