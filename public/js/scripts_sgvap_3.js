function asig_listener_change_vehicle_foto_prev() {
    document.querySelectorAll('input[type="file"]').forEach((input, index) => {
        input.addEventListener('change', function (event) {
        console.log("Evento change generado.");
        const file = event.target.files[0]; //
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById(`prev_foto_${index + 1}`).src = e.target.result;
            };
            reader.readAsDataURL(file);
        }

        else {
            document.getElementById(`prev_foto_${index + 1}`).src = valoresOriginales[`ruta_evidencia_${index + 1}`];
        }
    });
    });
}

function save_values_of_inputs_with_files() {
    const form = document.getElementById("actualizar_version_2");
    const inputs = form.querySelectorAll("input:not([type='file']), textarea, select");
    const imgs = form.querySelectorAll("img.img_file");

    valoresOriginales = {};
    inputs.forEach((input, index) => {
        if (!(input.type === 'radio') && !(input.type === 'checkbox')) valoresOriginales[input.name] = input.value;
        if (input.type === 'radio' && input.checked === true) valoresOriginales[input.name] = input.value;
        if (input.type === 'checkbox') valoresOriginales[input.value] = input.checked;
    });

    imgs.forEach((img, index) => {
        valoresOriginales[`ruta_evidencia_${index + 1}`] = img.src;
    });

    console.log(valoresOriginales);
}

function ask_before_submit_with_files() {
    if (confirm("¿Está seguro de guardar los cambios?")) {
        const form = document.getElementById("actualizar_version_2");
        const inputs = form.querySelectorAll("input:not([type='file']), textarea, select");
        const imgs = form.querySelectorAll("img.img_file");

        let valoresOriginales2 ={}

        const huboCambios = Array.from(inputs).some(
            (input) => {
                if (!(input.type === 'radio') && !(input.type === 'checkbox')) valoresOriginales2[input.name] = input.value;
                if (input.type === 'radio' && input.checked === true) valoresOriginales2[input.name] = input.value;
                if (input.type === 'checkbox') valoresOriginales2[input.value] = input.checked;

                if (!(input.type === 'radio') && !(input.type === 'checkbox')) return valoresOriginales[input.name] !== input.value;
                if (input.type === 'radio' && input.checked === true) return valoresOriginales[input.name] !== input.value;
                if (input.type === 'checkbox') return valoresOriginales[input.value] !== input.checked;
            }
        );

        const huboCambiossrc = Array.from(imgs).some(
            (img, index) => {
                valoresOriginales2[`ruta_evidencia_${index + 1}`] = img.src;
                return valoresOriginales[`ruta_evidencia_${index + 1}`] !== img.src;
            }
        );

        console.log(valoresOriginales2);

        console.log(huboCambios);

        console.log(huboCambiossrc);

        if ((!huboCambios) && (!huboCambiossrc)) {
            alert("No realizaste ningún cambio.");
            window.location.reload();
            return;
        }

        form.requestSubmit();
    }
}