import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ["formContainer"];

    connect() {
        // Initialisation des événements de drag/drop
        this.setupDragAndDrop();
    }

    setupDragAndDrop() {
        const elements = document.querySelectorAll('#elements .element');
        const canvas = document.getElementById('canvas');

        elements.forEach((element) => {
            element.addEventListener('dragstart', (event) => {
                event.dataTransfer.setData('type', element.getAttribute('data-type'));
            });
        });

        elements.forEach((element) => {
            element.addEventListener('click', (event) => {
                const type = element.getAttribute('data-type');
                // set hidden input value to type
                const hiddenInput = document.getElementById('element_type');
                hiddenInput.value = type;
            });
        });

        canvas.addEventListener('dragover', (event) => {
            event.preventDefault();
        });

        canvas.addEventListener('drop', (event) => {
            event.preventDefault();
            const type = event.dataTransfer.getData('type');
            this.loadForm(type);
        });
    }

    loadForm(type) {
        const url = `/form/${type}`;  // Route qui retourne le formulaire en fonction du type
        fetch(url)
            .then(response => response.text())
            .then(html => {
                this.formContainerTarget.innerHTML = html;
            });
    }
}