<?php
/**
 * @var Org\Model\Note[] $notes
 * @var string|null $message
 * @var Arc\Db\Paginator $paginator
 */
$this->setGlobalVar('title', 'Organizer - Notes');
$notes = $paginator->getItems();
?>
<div class="text-center mb-3 mt-4"><button id="add_note_btn" type="button" class="btn btn-primary btn-lg ajax-modal-form" data-url="<?= $this->url('notes/add') ?>" data-title="Add">Add note</button></div>
<?php if (!empty($message)): ?>
  <div class="alert alert-success" role="alert">
    <?= htmlspecialchars($message) ?>
  </div>
<?php endif; ?>
<div id="notes_container" class="container d-flex flex-wrap" style="justify-content: space-around;">
<?php foreach ($notes as $note) { ?>
    <div class="note w-25 card m-3 shadow rounded myowncard" style="background-color: <?= $note->getColor() ?>;">
        <a href="/notes/<?= $note->getId() ?>" class="text-decoration-none text-dark ajax-modal" data-url="<?= $this->url('notes/viewNote', ['id' => $note->getId()]) ?>">
            <div class="card-body">
                <h1><?= htmlspecialchars($note->getContent()) ?></h1>
                <p class="datechangedstr">Change date: <?= $note->getDateChanged() ?></p>
            </div>
        </a>
        <div class="p-3 d-flex">
            <button type="button" class="btn btn-danger delete-note-btn ajax-action ajax-delete" data-url="<?= $this->url('notes/delete', ['id' => $note->getId()]) ?>"><i class="bi bi-x-square-fill"></i></button>
            <button type="button" data-url="<?= $this->url('notes/edit', ['id' => $note->getId()]) ?>" data-title="Edit" class="btn btn-primary edit-note-btn ajax-modal-form"><i class="bi bi-pencil-square"></i></button>
        </div>
    </div>
<?php } ?>
</div>

<?php if ($paginator->isPaginatable()): ?>
    <nav aria-label="Notes pagination">
        <ul class="pagination justify-content-center">
            <li class="page-item<?= $paginator->getCurrentPage() === 1 ? ' disabled' : '' ?>"><a class="page-link" href="<?= $this->url('notes/index', ['page' => 1]) ?>">First</a></li>
            <li class="page-item<?= !$paginator->hasPrevious() ? ' disabled' : '' ?>"><a class="page-link" href="<?= $this->url('notes/index', ['page' => $paginator->getPreviousPage()]) ?>">&laquo;</a></li>
            <?php for ($i = 1; $i <= $paginator->getPagesTotal(); $i++): ?>
                <li class="page-item<?= $i === $paginator->getCurrentPage() ? ' active' : '' ?>"><a class="page-link" href="<?= $this->url('notes/index', ['page' => $i]) ?>"><?= $i ?></a></li>
            <?php endfor; ?>
            <li class="page-item<?= !$paginator->hasNext() ? ' disabled' : '' ?>"><a class="page-link" href="<?= $this->url('notes/index', ['page' => $paginator->getNextPage()]) ?>">&raquo;</a></li>
            <li class="page-item<?= $paginator->getCurrentPage() === $paginator->getPagesTotal() ? ' disabled' : '' ?>"><a class="page-link" href="<?= $this->url('notes/index', ['page' => $paginator->getPagesTotal()]) ?>">Last</a></li>
        </ul>
    </nav>
<?php endif; ?>

<div class="modal fade" id="modalMain" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body"></div>
    </div>
  </div>
</div>
