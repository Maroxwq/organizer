class AjaxModal {
    constructor(activator, modal) {
        this.activator = activator;
        this.modal = modal;
        this.addListeners();
    }

    addListeners() {
        this.activator.addEventListener('click', async (e) => {
            e.preventDefault();
            const url = this.activator.dataset.url;
            const response = await fetch(url);
            if (response.status !== 200) return;
            const html = await response.text();
            this.showModal(html);
        });
    }

    showModal(content) {
        const body = this.modal._element.querySelector('.modal-body');
        body.innerHTML = content;
        this.modal._element.querySelector('.modal-title').textContent = this.activator.dataset.title || '';
        this.modal.show();
    }
}

class AjaxModalForm extends AjaxModal {
    showModal(content) {
        super.showModal(content);
        this.bindForm();
    }

    bindForm() {
        const form = this.modal._element.querySelector('form');
        if (!form) return;
        form.addEventListener('submit', this.submitForm.bind(this));
    }

    async submitForm(e) {
        e.preventDefault();
        const form = e.target;
        const action = form.action;
        const data = new FormData(form);
        const response = await fetch(action, {
            method: 'POST',
            body: data
        });
        const html = await response.text();
        if (response.status === 422) {
            this.showModal(html);
        } else if (response.status === 200) {
            this.modal.hide();
            window.location.reload();
        }
    }
}

class AjaxDelete {
    constructor(activator) {
        this.activator = activator;
        this.addListeners();
    }

    addListeners() {
        this.activator.addEventListener('click', async (e) => {
            e.preventDefault();
            if (!confirm('Delete this note?')) return;
            const url = this.activator.dataset.url;
            const response = await fetch(url, { method: 'POST' });
            if (response.status === 200) {
                this.activator.closest('.note')?.remove();
            } else {
                alert('Failed to delete.');
            }
        });
    }
}
