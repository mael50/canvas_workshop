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
            this.formContainerTarget.querySelector("form").id = "id-" + Math.random().toString(36).substr(2, 9);

            this.setIntoElementEdit();
            this.showRangeValue();
            this.checkAndGenerateQrCode();
            this.addQrCodeFormListeners();
            this.checkAndHandleImage();
            this.addImageFormListeners();
            this.conserveProportionQrCode();
        })
        .catch(error => {
            console.error('Error loading form:', error);
        });
    }

    conserveProportionQrCode() {
        let widthInput = document.getElementById("qr_code_width");
        let heightInput = document.getElementById("qr_code_height");

        if (widthInput && heightInput) {
            widthInput.addEventListener("input", () => {
                heightInput.value = widthInput.value;
            });

            heightInput.addEventListener("input", () => {
                widthInput.value = heightInput.value;
            });
        }
    }
    

    setIntoElementEdit() {
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

                const currentQrCode = e.target.closest(".qr-code");
                let allQrCode = document.querySelectorAll('.qr-code');
                allQrCode.forEach(qrCode => {
                    qrCode.classList.remove('selected');
                });
                currentQrCode.classList.add('selected');
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

        if (selectedQrCode && qrCodePosX && qrCodePosY && qrCodeWidth && qrCodeHeight) {
            selectedQrCode.style.left = (qrCodePosX.value / 100 * canvas.offsetWidth) + "px";
            selectedQrCode.style.top = (qrCodePosY.value / 100 * canvas.offsetHeight) + "px";
            selectedQrCode.style.width = (qrCodeWidth.value / 100 * canvas.offsetWidth) + "px";
            selectedQrCode.style.height = (qrCodeHeight.value / 100 * canvas.offsetHeight) + "px";

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
            if (existingQrCode) {
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
                    const qrCodeElement = document.createElement("div");
                    qrCodeElement.classList.add("qr-code");
                    qrCodeElement.style.position = "absolute";
                    qrCodeElement.style.cursor = "move";
    
                    const img = document.createElement("img");
                    img.id = "qr-code-" + textForm;
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

    checkAndHandleImage() {
        const form = this.formContainerTarget.querySelector("form");
        if (form && form.name === "image") {
            const imageInput = form.querySelector("#image_src");
            if (imageInput) {
                imageInput.addEventListener("change", (event) => {
                    this.displayImagePreview(event.target);
                });
            }
        }
    }

    displayImagePreview(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = (e) => {
                const img = document.createElement("img");
                img.src = e.target.result;
                img.alt = "Image Preview";
                img.style.position = "absolute";
                img.style.width = "50%"; // Valeurs initiales
                img.style.height = "50%";
                img.style.left = "50px";  // Exemple de position initiale
                img.style.top = "50px";  // Exemple de position initiale
                img.style.cursor = "move";
                img.classList.add("draggable-image");

                const canvas = document.getElementById("canvas");
                canvas.appendChild(img);

                this.makeImageDraggable(img);
            };
            reader.readAsDataURL(input.files[0]);
        }
        

    }

    // Méthode pour rendre l'image draggable
    makeImageDraggable(imageElement) {
        let isDragging = false;
        let offsetX, offsetY;

        imageElement.addEventListener("mousedown", (e) => {
            isDragging = true;
            offsetX = e.clientX - parseInt(window.getComputedStyle(imageElement).left);
            offsetY = e.clientY - parseInt(window.getComputedStyle(imageElement).top);
            this.updateImageFormValues(imageElement);
        });

        document.addEventListener("mousemove", (e) => {
            if (isDragging) {
               this.handleRectOverlapping();
                const canvas = document.getElementById("canvas");
                

                let newLeft = e.clientX - offsetX;
                let newTop = e.clientY - offsetY;

                newLeft = Math.max(0, Math.min(newLeft, canvas.offsetWidth - imageElement.offsetWidth));
                newTop = Math.max(0, Math.min(newTop, canvas.offsetHeight - imageElement.offsetHeight));

                imageElement.style.left = newLeft + "px";
                imageElement.style.top = newTop + "px";

                const imagePosX = document.getElementById("image_posX");
                const imagePosY = document.getElementById("image_posY");

                if (imagePosX && imagePosY) {
                    imagePosX.value = Math.round((newLeft / canvas.offsetWidth) * 100);
                    imagePosY.value = Math.round((newTop / canvas.offsetHeight) * 100);
                }
            }
        });

        document.addEventListener("mouseup", () => {
            isDragging = false;
        });
    }

    addImageFormListeners() {

        const imagePosX = document.getElementById("image_posX");
        const imagePosY = document.getElementById("image_posY");
        const imageWidth = document.getElementById("image_width");
        const imageHeight = document.getElementById("image_height");


        if (imagePosX && imagePosY && imageWidth && imageHeight) {
            imagePosX.addEventListener("input", () => this.updateSelectedImage());
            imagePosY.addEventListener("input", () => this.updateSelectedImage());
            imageWidth.addEventListener("input", () => this.updateSelectedImage());
            imageHeight.addEventListener("input", () => this.updateSelectedImage());
        }

        this.handleRectOverlapping();

    }

    handleRectOverlapping() {
        let element = document.querySelector('.draggable-image');
        if (element) {
            let elementRect = element.getBoundingClientRect();
            let canvas = document.getElementById("canvas");
            let canvasRect = canvas.getBoundingClientRect();

            if (elementRect.right < canvasRect.right) {
            element.style.width = this.value + '%';
            document.getElementById('image_width').removeAttribute('disabled');
            } else {
            document.getElementById('image_width').setAttribute('disabled', 'true');
            }

            if (elementRect.bottom < canvasRect.bottom) {
            element.style.height = this.value + '%';
            document.getElementById('image_height').removeAttribute('disabled');
            } else {
            document.getElementById('image_height').setAttribute('disabled', 'true');
            }
        }
    }

    updateSelectedImage() {
        this.handleRectOverlapping();
        const selectedImage = document.querySelector('.draggable-image');
        const canvas = document.getElementById("canvas");
        const imagePosX = document.getElementById("image_posX");
        const imagePosY = document.getElementById("image_posY");
        const imageWidth = document.getElementById("image_width");
        const imageHeight = document.getElementById("image_height");

        if (selectedImage && imagePosX && imagePosY && imageWidth && imageHeight) {
            selectedImage.style.left = (imagePosX.value / 100 * canvas.offsetWidth) + "px";
            selectedImage.style.top = (imagePosY.value / 100 * canvas.offsetHeight) + "px";
            selectedImage.style.width = (imageWidth.value / 100 * canvas.offsetWidth) + "px";
            selectedImage.style.height = (imageHeight.value / 100 * canvas.offsetHeight) + "px";
        }
    }

    updateImageFormValues(imageElement) {
        const canvas = document.getElementById("canvas");
        const imagePosX = document.getElementById("image_posX");
        const imagePosY = document.getElementById("image_posY");
        const imageWidth = document.getElementById("image_width");
        const imageHeight = document.getElementById("image_height");

        if (canvas && imagePosX && imagePosY && imageWidth && imageHeight) {
            const canvasRect = canvas.getBoundingClientRect();
            const imageRect = imageElement.getBoundingClientRect();

            imagePosX.value = Math.round((imageRect.left - canvasRect.left) / canvas.offsetWidth * 100);
            imagePosY.value = Math.round((imageRect.top - canvasRect.top) / canvas.offsetHeight * 100);
            imageWidth.value = Math.round((imageElement.offsetWidth / canvas.offsetWidth) * 100);
            imageHeight.value = Math.round((imageElement.offsetHeight / canvas.offsetHeight) * 100);
        }
    }
}
