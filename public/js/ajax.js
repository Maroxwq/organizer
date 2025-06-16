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
            const html = await response.text();
            this.showModal(html);
        });
    }

    showModal(content) {
        const body = this.modal._element.querySelector('.modal-body');
        const tmp = document.createElement('div');
        tmp.innerHTML = content;
        this.modal._element.querySelector('.modal-title').textContent = this.activator.dataset.title || '';
        const form = tmp.querySelector('form');
        if (form) {
            body.innerHTML = '';
            body.appendChild(form);
        } else {
            body.innerHTML = content;
        }
        this.modal.show();
    }
}

class AjaxModalForm extends AjaxModal {
    addSubmitListener(form) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const res = await fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const html = await res.text();
            const tmp = document.createElement('div');
            tmp.innerHTML = html;
            const newForm = tmp.querySelector('form');
            if (newForm) {
                this.showModal(html);
            } else {
                this.modal.hide();
                window.location.reload();
            }
        }, { once: true });
    }

    showModal(content) {
        super.showModal(content);
        const form = this.modal._element.querySelector('form');
        if (form) this.addSubmitListener(form);
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
            const url = this.activator.dataset.url;
            if (!confirm('Delete this note?')) return;
            const response = await fetch(url, { method: 'POST' });
            if (response.ok) {
                this.activator.closest('.note')?.remove();
            } else {
                alert('Failed to delete.');
            }
        });
    }
}
