<?php
/**
 * @var Org\Model\Note[] $notes
 * @var string|null $message
 * @var Arc\Db\Paginator $paginator
 */
$this->setGlobalVar('title', 'Organizer - Notes');
$notes = $paginator->getItems();
?>
<div class="text-center">
    <a href="<?= $this->url('notes/add')?>" class="btn btn-primary btn-lg mb-3 mt-4">Add note</a>
</div>
<?php if (!empty($message)): ?>
  <div class="alert alert-success" role="alert">
    <?= htmlspecialchars($message) ?>
  </div>
<?php endif; ?>
<div class="container d-flex flex-wrap" style="justify-content: space-around;">
<?php foreach ($notes as $note) { ?>
    <div class="note w-25 card m-3 shadow rounded myowncard" style="background-color: <?= $note->getColor() ?>;">
        <a href="/notes/<?= $note->getId() ?>" class="text-decoration-none text-dark">
            <div class="card-body">
                <h1><?= htmlspecialchars($note->getContent()) ?></h1>
                <p class="datechangedstr">Change date: <?= $note->getDateChanged() ?></p>
                <br>
                <div class="d-flex justify-content-between">
                    <a href="<?= $this->url('notes/delete', ['id' => $note->getId()]) ?>" class="btn btn-danger"><i class="bi bi-x-square-fill"></i></a>
                    <a href="<?= $this->url('notes/edit', ['id' => $note->getId()]) ?>" class="btn btn-primary"><i class="bi bi-pencil-square"></i></a>
                </div>
            </div>
        </a>
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