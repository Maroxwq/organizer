document.addEventListener('DOMContentLoaded', () => {
  const modalEl = document.getElementById('noteModal');
  const bsModal = new bootstrap.Modal(modalEl);
  const bodyEl = modalEl.querySelector('.modal-body');
  const addBtn = document.getElementById('add_note_btn');
  const notesCont = document.getElementById('notes_container');

  function showFormInModal(formEl) {
    bodyEl.innerHTML = '';
    bodyEl.appendChild(formEl);
    bsModal.show();
  }

  async function loadForm(url) {
    const res = await fetch(url);
    const html = await res.text();
    const tmp = document.createElement('div');
    tmp.innerHTML = html;
    const form = tmp.querySelector('form');
    if (!form) {
      console.error('Form not found', url);
      return;
    }
    showFormInModal(form);
    bindFormSubmit(form);
  }

  function bindFormSubmit(form) {
    form.addEventListener('submit', async e => {
      e.preventDefault();
      const res = await fetch(form.action, {
        method: 'POST',
        body: new FormData(form),
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      });
      if (res.status === 200) {
        bsModal.hide();
        window.location.reload();
      } else if (res.status === 422) {
        const html = await res.text();
        const tmp = document.createElement('div');
        tmp.innerHTML = html;
        const newForm = tmp.querySelector('form');
        showFormInModal(newForm);
        bindFormSubmit(newForm);
      } else {
        console.error('Unexpected status', res.status);
      }
    }, { once: true });
  }

  addBtn.addEventListener('click', () => loadForm(addBtn.dataset.url));
  notesCont.addEventListener('click', e => {
    const btn = e.target.closest('.edit-note-btn');
    if (btn) {
      e.preventDefault();
      loadForm(btn.dataset.url);
    }
  });
  notesCont.addEventListener('click', async e => {
    const btn = e.target.closest('.delete-note-btn');
    if (!btn) return;
    e.preventDefault();
    if (!confirm('Delete note?')) return;
    const res = await fetch(btn.dataset.url, { method: 'POST' });
    if (res.ok) {
      btn.closest('.note')?.remove();
    } else {
      alert('Delete failed');
    }
  });
});
