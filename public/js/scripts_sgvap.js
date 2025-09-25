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

async function validar_form_generator() {
    // 1. Obtener valores del formulario.
    const rfc = document.getElementById('input_find_rfc').value.trim();
    const fecha = document.getElementById('fecha_dispersion_dia').value;

    // Validación básica antes del fetch.
    if (!rfc || !fecha) {
        alert("Por favor ingresa RFC y fecha de corte.");
        return;
    }

    try {
        // 2. Hacer la petición al controlador.
        const response = await fetch('/validar_form_generator', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content // si aplica...
            },
            body: JSON.stringify({ employee_id: rfc, fecha_dispersion_dia: fecha })
        });

        // 3. Si Laravel devolvió redirect con errores → no habrá JSON → deja que la recarga suceda...
        const contentType = response.headers.get("content-type") || "";
        if (!contentType.includes("application/json")) {
            return; // aquí no forzamos reload, Laravel ya maneja la bolsa de errores...
        }

        // 4. Parsear el JSON válido.
        const data = await response.json();

        if (data.generacion_formulario) {
            // Mostrar segunda parte del formulario.
            const segundaParte = document.getElementById('segunda-parte-formulario');
            if (segundaParte) {
                segundaParte.classList.remove('d-none');
            }

            // Si viene deuda extra, precargarla.
            if (data.extra_ecore_debt) {
                console.log("Deuda extra recibida:", data.extra_ecore_debt);

                // Obtener input basado en el campo a descontar.
                const fieldId = data.extra_ecore_debt.campo_descontar;
                const inputPreloadedValue = document.getElementById(fieldId);

                document.getElementById("id_e").value = data.extra_ecore.id;

                if (inputPreloadedValue) {
                    inputPreloadedValue.value = data.extra_ecore_debt.monto_extra_ecore * -1;
                    inputPreloadedValue.disabled = true; // Bloquea el input para que no se modifique.
                } else {
                    console.warn(`No se encontró el input con id = "${fieldId}"`);
                }
            }
        }
    } catch (error) {
        console.error("Error en el fetch:", error);
        alert("Hubo un problema al generar el corte. Intenta de nuevo.");
    }
}

function show_part_extra_ecore() {
    const monto_input = document.getElementById('monto_extra_ecore');
    const campo_input = document.getElementById('campo_descontar');
    const fecha_input = document.getElementById('fecha_descontar');

    const cont_monto = document.getElementById('monto_extra_ecore_div');
    const cont_campo = document.getElementById('campo_descontar_div');
    const cont_fecha = document.getElementById('fecha_descontar_div');

    document.getElementById('ajuste_retiro').addEventListener('change', (e) => {
        if (e.target.checked) {
            cont_monto.classList.remove('d-none');
            cont_campo.classList.remove('d-none');
            cont_fecha.classList.remove('d-none');

            monto_input.required = true;
            campo_input.required = true;
            fecha_input.required = true;
        } else {
            cont_monto.classList.add('d-none');
            cont_campo.classList.add('d-none');
            cont_fecha.classList.add('d-none');

            monto_input.required = false;
            campo_input.required = false;
            fecha_input.required = false;

            monto_input.value = "";
            campo_input.value = "";
            fecha_input.value = "";
        }
    });
}