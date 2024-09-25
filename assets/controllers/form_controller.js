import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ["formContainer"];

    loadForm(event) {
        event.preventDefault();
        const url = event.currentTarget.dataset.url;

        fetch(url, {
            headers: {
                "Turbo-Frame": "formContainer"  // Cible le bon frame
            }
        })
            .then(response => response.text())
            .then(html => {
                this.formContainerTarget.innerHTML = html;
            })
            .then(() => {
                this.setIntoElementEdit();
            })
            .then(() => {
                this.showRangeValue();
                this.checkAndGenerateQrCode();
            });
    }
    setIntoElementEdit() {
        document.getElementById('elementEditPane').classList.remove('hidden');
        document.getElementById('templateEditPane').classList.add('hidden');
        document.getElementById('elementEditBtn').classList.add('selected');
        document.getElementById('templateEditBtn').classList.remove('selected');
    }

    showRangeValue() {
        const ranges = this.formContainerTarget.querySelectorAll("input[type=range]");
        console.log(ranges);
        ranges.forEach(range => {
            const label = range.previousElementSibling;
            const output = document.createElement("output");
            const div = document.createElement("div");
            div.style.display = "flex";
            div.style.flexDirection = "row";
            div.style.justifyContent = "space-between";
            div.style.alignItems = "center";
            div.appendChild(label);
            div.appendChild(output);

            range.insertAdjacentElement("beforebegin", div);
            output.innerHTML = range.value;
            range.addEventListener("input", () => {
                output.innerHTML = range.value;
            });
        });
    }

    checkAndGenerateQrCode() {
        const form = this.formContainerTarget.querySelector("form");
        console.log(form.name);
        if (form && form.name === "qr_code") {
            const qrCodeInput = form.querySelector("#qr_code_text");
            if (qrCodeInput) {
                qrCodeInput.addEventListener("input", () => this.generateQrCode());
            }
        }
    }

    generateQrCode() {
        const text = this.formContainerTarget.querySelector("#qr_code_text").value;
        console.log(text);
        if (!text) {
            return;
        }
        fetch(`/generate-qrcode/${encodeURIComponent(text)}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(html => {
                console.log(html);
            });
    }
}