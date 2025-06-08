<?php
/**
 * @var Org\Model\Note[] $notes
 * @var string|null $message
 * @var Arc\Db\Paginator $paginator
 */
$this->setGlobalVar('title', 'Organizer - Notes');
$notes = $paginator->getItems();
?>
<div class="text-center mb-3 mt-4"><button id="add-note-btn" type="button" class="btn btn-primary btn-lg">Add note</button></div>
<?php if (!empty($message)): ?>
  <div class="alert alert-success" role="alert">
    <?= htmlspecialchars($message) ?>
  </div>
<?php endif; ?>
<div id="notes-container" class="container d-flex flex-wrap" style="justify-content: space-around;">
<?php foreach ($notes as $note) { ?>
    <div class="note w-25 card m-3 shadow rounded myowncard" style="background-color: <?= $note->getColor() ?>;">
        <a href="/notes/<?= $note->getId() ?>" class="text-decoration-none text-dark">
            <div class="card-body">
                <h1><?= htmlspecialchars($note->getContent()) ?></h1>
                <p class="datechangedstr">Change date: <?= $note->getDateChanged() ?></p>
            </div>
        </a>
        <div class="p-3 d-flex">
            <button type="button" class="btn btn-danger delete-note-btn" data-url="<?= $this->url('notes/delete', ['id' => $note->getId()]) ?>"><i class="bi bi-x-square-fill"></i></button>
            <button type="button" data-url="<?= $this->url('notes/edit', ['id' => $note->getId()]) ?>" class="btn btn-primary edit-note-btn"><i class="bi bi-pencil-square"></i></button>
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

<div class="modal fade" id="noteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Note</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body"></div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const modalEl = document.getElementById('noteModal');
  const bsModal = new bootstrap.Modal(modalEl);
  const body = modalEl.querySelector('.modal-body');
  async function loadForm(url) {
    const res = await fetch(url);
    const html = await res.text();
    const tmp = document.createElement('div');
    tmp.innerHTML = html;
    const form = tmp.querySelector('form');
    body.innerHTML = '';
    body.appendChild(form);
    bsModal.show();
    bindFormSubmit(form);
  }
  function bindFormSubmit(form) {
    form.addEventListener('submit', async e => {
      e.preventDefault();
      const res = await fetch(form.action, {
        method: 'POST',
        body: new FormData(form)
      });
      const html = await res.text();
      const tmp = document.createElement('div');
      tmp.innerHTML = html;
      const newForm = tmp.querySelector('form');
      if (newForm) {
        body.innerHTML = '';
        body.appendChild(newForm);
        bindFormSubmit(newForm);
      } else {
        bsModal.hide();
        window.location.reload();
      }
    });
  }
  document.getElementById('add-note-btn').addEventListener('click', () => loadForm('<?= $this->url('notes/add') ?>'));
  document.getElementById('notes-container').addEventListener('click', e => {
      const btn = e.target.closest('.edit-note-btn');
      if (!btn) return;
      loadForm(btn.getAttribute('data-url'));
    });
    document.getElementById('notes-container').addEventListener('click', async e => {
    const btn = e.target.closest('.delete-note-btn');
    if (!btn) return;
    if (!confirm('Удалить заметку?')) return;
    await fetch(btn.getAttribute('data-url'), { method: 'POST' });
    const card = btn.closest('.note');
    card?.remove();
  });
});
</script>