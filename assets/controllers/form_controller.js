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
            .then(() =>{
                this.setIntoElementEdit();
            })
            .then(() => {
                this.showRangeValue();
            });


    }
    setIntoElementEdit(){
        document.getElementById('elementEditPane').classList.remove('hidden');
        document.getElementById('templateEditPane').classList.add('hidden');
        document.getElementById('elementEditBtn').classList.add('selected');
        document.getElementById('templateEditBtn').classList.remove('selected');
    }

    showRangeValue() {
        const ranges = this.formContainerTarget.querySelectorAll("input[type=range]");
        console.log(ranges);
        ranges.forEach(range => {
            // get range label
            const label = range.previousElementSibling;
            const output = document.createElement("output");
            // créer une div qui contient label et output, en flex row
            const div = document.createElement("div");
            div.style.display = "flex";
            div.style.flexDirection = "row";
            div.style.justifyContent = "space-between";
            div.style.alignItems = "center";
            div.appendChild(label);
            div.appendChild(output);

            range.insertAdjacentElement("beforebegin", div);
            // range.insertAdjacentElement("beforebegin", output);
            output.innerHTML = range.value;
            range.addEventListener("input", () => {
                output.innerHTML = range.value;
            });
        });
    }
}