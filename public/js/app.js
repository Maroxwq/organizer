document.addEventListener('DOMContentLoaded', () => {
    const modalEl = document.getElementById('modalMain');
    const bsModal = new bootstrap.Modal(modalEl);

    document.querySelectorAll('.ajax-modal').forEach(activator => {
        new AjaxModal(activator, bsModal);
    });

    document.querySelectorAll('.ajax-modal-form').forEach(activator => {
        new AjaxModalForm(activator, bsModal);
    });

    document.querySelectorAll('.ajax-delete').forEach(activator => {
        new AjaxDelete(activator);
    });
});