import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ["formContainer"];

    loadForm(event) {
        event.preventDefault();
        const url = event.currentTarget.dataset.url;
    
        fetch(url, {
            headers: {
                "Turbo-Frame": "formContainer"
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.text();
        })
        .then(html => {
            this.formContainerTarget.innerHTML = html;
            console.log(this.formContainerTarget.innerHTML); // Débogage
    
            // Assurez-vous que les ID et événements sont bien configurés
            this.formContainerTarget.querySelector("form").id = "id-" + Math.random().toString(36).substr(2, 9);
            this.setIntoElementEdit();
            this.showRangeValue();
            this.checkAndGenerateQrCode();
            this.addQrCodeFormListeners();
        })
        .catch(error => {
            console.error('Error loading form:', error);
        });
    }
    

    setIntoElementEdit() {
        console.log('setIntoElementEdit');
        const elementEditPane = document.getElementById('elementEditPane');
        const templateEditPane = document.getElementById('templateEditPane');
        const elementEditBtn = document.getElementById('elementEditBtn');
        const templateEditBtn = document.getElementById('templateEditBtn');

        if (elementEditPane && templateEditPane && elementEditBtn && templateEditBtn) {
            elementEditPane.classList.remove('hidden');
            templateEditPane.classList.add('hidden');
            elementEditBtn.classList.add('selected');
            templateEditBtn.classList.remove('selected');
        }
    }

    bindInputChanges(qrCodeElement) {
        const posXInput = document.getElementById("qr_code_posX");
        const posYInput = document.getElementById("qr_code_posY");
        const widthInput = document.getElementById("qr_code_width");
        const heightInput = document.getElementById("qr_code_height");

        if (posXInput && posYInput && widthInput && heightInput) {
            const canvas = document.getElementById("canvas");

            posXInput.addEventListener("input", () => {
                qrCodeElement.style.left = (posXInput.value / 100 * canvas.offsetWidth) + "px";
            });

            posYInput.addEventListener("input", () => {
                qrCodeElement.style.top = (posYInput.value / 100 * canvas.offsetHeight) + "px";
            });

            widthInput.addEventListener("input", () => {
                qrCodeElement.style.width = (widthInput.value / 100 * canvas.offsetWidth) + "px";
            });

            heightInput.addEventListener("input", () => {
                qrCodeElement.style.height = (heightInput.value / 100 * canvas.offsetHeight) + "px";
            });
        }
    }

    showRangeValue() {
        const ranges = this.formContainerTarget.querySelectorAll("input[type=range]");
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

    makeQrCodeDraggable(qrCodeElement) {
        let isDragging = false;
        let offsetX, offsetY;

        qrCodeElement.addEventListener("mousedown", (e) => {
            isDragging = true;
            offsetX = e.clientX - parseInt(window.getComputedStyle(qrCodeElement).left);
            offsetY = e.clientY - parseInt(window.getComputedStyle(qrCodeElement).top);
            this.updateQrCodeFormValues(qrCodeElement);
        });

        document.addEventListener("mousemove", (e) => {
            if (isDragging) {
                const canvas = document.getElementById("canvas");
                let newLeft = e.clientX - offsetX;
                let newTop = e.clientY - offsetY;

                newLeft = Math.max(0, Math.min(newLeft, canvas.offsetWidth - qrCodeElement.offsetWidth));
                newTop = Math.max(0, Math.min(newTop, canvas.offsetHeight - qrCodeElement.offsetHeight));

                qrCodeElement.style.left = newLeft + "px";
                qrCodeElement.style.top = newTop + "px";

                const qrCodePosX = document.getElementById("qr_code_posX");
                const qrCodePosY = document.getElementById("qr_code_posY");

                if (qrCodePosX && qrCodePosY) {
                    qrCodePosX.value = Math.round((newLeft / canvas.offsetWidth) * 100);
                    qrCodePosY.value = Math.round((newTop / canvas.offsetHeight) * 100);
                }
            }
        });

        document.addEventListener("mouseup", () => {
            isDragging = false;
        });
    }

    addQrCodeFormListeners() {
        const qrCodePosX = document.getElementById("qr_code_posX");
        const qrCodePosY = document.getElementById("qr_code_posY");
        const qrCodeWidth = document.getElementById("qr_code_width");
        const qrCodeHeight = document.getElementById("qr_code_height");
        const qrCodeText = document.getElementById("qr_code_text");

        if (qrCodePosX && qrCodePosY && qrCodeWidth && qrCodeHeight && qrCodeText) {
            qrCodePosX.addEventListener("input", () => this.updateSelectedQrCode());
            qrCodePosY.addEventListener("input", () => this.updateSelectedQrCode());
            qrCodeWidth.addEventListener("input", () => this.updateSelectedQrCode());
            qrCodeHeight.addEventListener("input", () => this.updateSelectedQrCode());
            qrCodeText.addEventListener("input", () => this.updateSelectedQrCode());
        }
    }

    updateQrCodeFormValues(qrCodeElement) {
        const canvas = document.getElementById("canvas");
        const qrCodePosX = document.getElementById("qr_code_posX");
        const qrCodePosY = document.getElementById("qr_code_posY");
        const qrCodeWidth = document.getElementById("qr_code_width");
        const qrCodeHeight = document.getElementById("qr_code_height");
        const qrCodeInputAssocie = document.getElementById("qr_code_inputAssocie");
        const qrCodeText = document.getElementById("qr_code_text");

        if (canvas && qrCodePosX && qrCodePosY && qrCodeWidth && qrCodeHeight && qrCodeInputAssocie && qrCodeText) {
            const canvasRect = canvas.getBoundingClientRect();
            const qrCodeRect = qrCodeElement.getBoundingClientRect();

            qrCodePosX.value = Math.round((qrCodeRect.left - canvasRect.left) / canvas.offsetWidth * 100);
            qrCodePosY.value = Math.round((qrCodeRect.top - canvasRect.top) / canvas.offsetHeight * 100);
            qrCodeWidth.value = Math.round((qrCodeElement.offsetWidth / canvas.offsetWidth) * 100);
            qrCodeHeight.value = Math.round((qrCodeElement.offsetHeight / canvas.offsetHeight) * 100);
            qrCodeInputAssocie.value = qrCodeElement.dataset.inputAssocie || "";
            qrCodeText.value = qrCodeElement.innerText || "";
        } else {
            setTimeout(() => {
                this.updateQrCodeFormValues(qrCodeElement);
            });
        }
    }

    updateSelectedQrCode() {
        const selectedQrCode = document.querySelector('.qr-code.selected');
        const canvas = document.getElementById("canvas");
        const qrCodePosX = document.getElementById("qr_code_posX");
        const qrCodePosY = document.getElementById("qr_code_posY");
        const qrCodeWidth = document.getElementById("qr_code_width");
        const qrCodeHeight = document.getElementById("qr_code_height");
        const qrCodeText = document.getElementById("qr_code_text");

        if (selectedQrCode && qrCodePosX && qrCodePosY && qrCodeWidth && qrCodeHeight && qrCodeText) {
            selectedQrCode.style.left = (qrCodePosX.value / 100 * canvas.offsetWidth) + "px";
            selectedQrCode.style.top = (qrCodePosY.value / 100 * canvas.offsetHeight) + "px";
            selectedQrCode.style.width = (qrCodeWidth.value / 100 * canvas.offsetWidth) + "px";
            selectedQrCode.style.height = (qrCodeHeight.value / 100 * canvas.offsetHeight) + "px";
            selectedQrCode.innerText = qrCodeText.value || selectedQrCode.innerText;
        }
    }

    checkAndGenerateQrCode() {
        const form = this.formContainerTarget.querySelector("form");
        if (form && form.name === "qr_code") {
            const qrCodeInput = form.querySelector("#qr_code_text");
            if (qrCodeInput) {
                let qrCodeInputTimeout;
                qrCodeInput.addEventListener("input", () => {
                    clearTimeout(qrCodeInputTimeout);
                    qrCodeInputTimeout = setTimeout(() => {
                        this.generateQrCode();
                    }, 2000);
                });
            }
        }
    }
    generateQrCode() {
        const canvas = document.getElementById("canvas");
        if (canvas) {
            const existingQrCode = canvas.querySelector(".qr-code");
            console.log('existingQrCode', existingQrCode);
            if (existingQrCode) {
                console.log('existingQrCode', existingQrCode);
                existingQrCode.remove();
            }
    
            const text = this.formContainerTarget.querySelector("#qr_code_text").value;
            const textForm = this.formContainerTarget.querySelector("form").id; 
            if (!text) return;
    
            const width = this.formContainerTarget.querySelector("#qr_code_width").value;
            const height = this.formContainerTarget.querySelector("#qr_code_height").value;
    
            fetch(`/generate-qrcode/${encodeURIComponent(text)}`)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.blob();
                })
                .then(blob => {
                    // Création d'un nouvel élément QR Code
                    const qrCodeElement = document.createElement("div");
                    qrCodeElement.classList.add("qr-code");
                    qrCodeElement.style.position = "absolute";
                    qrCodeElement.style.cursor = "move";
    
                    const img = document.createElement("img");
                    img.id = "qr-code-" + textForm; // Assurez-vous que cet ID est unique
                    img.src = URL.createObjectURL(blob);
                    img.alt = "QR Code";
    
                    qrCodeElement.appendChild(img);
                    canvas.appendChild(qrCodeElement);
    
                    this.makeQrCodeDraggable(qrCodeElement);
                })
                .catch(error => {
                    console.error('Error generating QR Code:', error);
                });
        }
    }
}
