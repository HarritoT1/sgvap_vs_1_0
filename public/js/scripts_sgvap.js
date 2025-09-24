let valoresOriginales = {};

function asig_listeners_of_submit_forms() {
    'use strict'

    const forms = document.querySelectorAll('.needs-validation')

    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false)
    })
}

function enable_inpus_edit_mode() {
    document.querySelectorAll('.form-control, .form-check-input').forEach(input => {
        input.removeAttribute('disabled');
    });

    document.getElementById('save').removeAttribute('disabled');
    document.getElementById('edit').setAttribute('disabled', 'true');

    if (document.getElementById('cancel')) {
        document.getElementById('cancel').classList.remove('d-none');
    }
}

function save_values_of_inputs() {
    const form = document.getElementById("actualizar");
    const inputs = form.querySelectorAll("input, textarea, select");

    valoresOriginales = {};
    inputs.forEach(input => {
        if (!(input.type === 'radio')) valoresOriginales[input.name] = input.value;
        if (input.type === 'radio' && input.checked === true) valoresOriginales[input.name] = input.value;
    });

    console.log(valoresOriginales);
}

function ask_before_submit() {
    if (confirm("¿Está seguro de guardar los cambios del proyecto?")) {
        const form = document.getElementById("actualizar");
        const inputs = form.querySelectorAll("input, textarea, select");

        const huboCambios = Array.from(inputs).some(
            (input) => {
                if (!(input.type === 'radio')) return valoresOriginales[input.name] !== input.value;
                if (input.type === 'radio' && input.checked === true) return valoresOriginales[input.name] !== input.value;
            }
        );

        if (!huboCambios) {
            alert("No realizaste ningún cambio.");
            window.location.reload();
            return;
        }

        form.requestSubmit();
    }
}

function cancel_edit_mode() {
    if (confirm("¿Está seguro de cancelar los cambios del proyecto?")) {
        window.location.reload();
    }
}

function asig_listener_autocomplete_rfc() {
    document.getElementById('input_find_rfc').addEventListener('input', function () {
        const query = this.value;
        const sugerencias = document.getElementById('sugerencias_rfc');

        if (query.length < 2) {
            sugerencias.innerHTML = '';
            return;
        }

        console.log("buscando rfc de empleados...");

        fetch(`/empleados/buscar-rfc?q=${query}`)
            .then(res => res.json())
            .then(data => {
                sugerencias.innerHTML = '';
                data.forEach(emp => {
                    const option = document.createElement('option');
                    option.value = emp.id + " - " + emp.nombre; // ejemplo: id - nombre
                    sugerencias.appendChild(option);
                });
            });
    });
}

function asig_listener_autocomplete_id_proyect() {
    document.getElementById('input_find_id_proyect').addEventListener('input', function () {
        const query = this.value;
        const sugerencias = document.getElementById('sugerencias_id_proyect');

        if (query.length < 2) {
            sugerencias.innerHTML = '';
            return;
        }

        console.log("buscando id de proyectos...")

        fetch(`/projects/buscar-id?q=${query}`)
            .then(res => res.json())
            .then(data => {
                sugerencias.innerHTML = '';
                data.forEach(proyect => {
                    const option = document.createElement('option');
                    option.value = proyect.id + " - " + proyect.nombre; // ejemplo: id - nombre
                    sugerencias.appendChild(option);
                });
            });
    });
}
