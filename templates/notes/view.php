<?php declare(strict_types = 1);
/** @var Org\Model\Note $note */
$this->setGlobalVar('title', 'Organizer - Note');
?>

<div id="note-view" class="note w-50 card m-3 shadow rounded myowncard mx-auto" style="background-color: <?= $note->getColor() ?>;">
    <div class="card-body d-flex flex-column">
        <h1><?= htmlspecialchars($note->getContent()) ?></h1>
        <p>Change date: <?= $note->getDateChanged() ?></p>
        <div class="mt-auto d-flex justify-content-between">
            <button type="button" class="btn btn-danger delete-note-btn" data-url="<?= $this->url('notes/delete', ['id' => $note->getId()]) ?>"><i class="bi bi-x-square-fill"></i></button>
            <button type="button" class="btn btn-primary edit-note-btn" data-url="<?= $this->url('notes/edit', ['id' => $note->getId()]) ?>"><i class="bi bi-pencil-square"></i></button>
        </div>
    </div>
</div>

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
  const viewEl = document.getElementById('note-view');
  viewEl.addEventListener('click', e => {
    const btn = e.target.closest('.edit-note-btn');
    if (btn) loadForm(btn.getAttribute('data-url'));
  });
  viewEl.addEventListener('click', async e => {
    const btn = e.target.closest('.delete-note-btn');
    if (!btn) return;
    e.preventDefault();
    e.stopPropagation();
    if (!confirm('Удалить заметку?')) return;
    await fetch(btn.getAttribute('data-url'), { method: 'POST' });
    window.location.href = '<?= $this->url('notes/index') ?>';
  });
});
</script>
