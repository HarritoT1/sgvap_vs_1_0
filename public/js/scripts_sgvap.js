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

function show_part_extra_ecore(e) {
    const monto_input = document.getElementById('monto_extra_ecore');
    const campo_input = document.getElementById('campo_descontar');
    const fecha_input = document.getElementById('fecha_descontar');

    const cont_monto = document.getElementById('monto_extra_ecore_div');
    const cont_campo = document.getElementById('campo_descontar_div');
    const cont_fecha = document.getElementById('fecha_descontar_div');

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
}

async function ask_values_of_proyect_progress_bar() {
    const input_id_proyect = document.getElementById('input_find_id_proyect').value;

    if (input_id_proyect.length < 5) {
        return;
    }

    console.log(`Generando valores de la barra de progreso del proyecto con id: ${input_id_proyect}...`)

    /*const response = await fetch(`/proyectprogressbargenerator?q=${input_id_proyect}`);

    const data = await response.json();*/

    if (/*data.generacion_progress_bar ||*/ true) {
        /*const monto_alimentos = data.totales_viaticos_table_daily.total_alimentos;
        const monto_traslados = data.totales_viaticos_table_daily.total_traslados;
        const monto_comision = data.totales_viaticos_table_daily.total_comision;
        const monto_gasolina = data.totales_viaticos_table_gasoline.total_comision;
        const monto_caseta = data.totales_viaticos_table_tag.total_comision;
        const monto_hospedaje = data.totales_viaticos_lodging_daily.total_comision;*/

        const limit = 260000; // límite requerido
        // --- EJEMPLO: modifica estos valores como necesites ---
        //const values = [50000, 70000, 20000, 30000]; // suma=170000 (< limit)
        const values = [90000, 90000, 90000, 90000]; // ejemplo > limit
        // ----------------------------------------------------

        const colors = ['seg-0', 'seg-1', 'seg-2', 'seg-3'];
        const labels = ['Segmento A', 'Segmento B', 'Segmento C', 'Segmento D'];

        const bar = document.getElementById('bar');
        const legend = document.getElementById('legend');
        const overflowMsg = document.getElementById('overflowMsg');
        const percentTotal = document.getElementById('percentTotal');
        const limitDisplay = document.getElementById('limitDisplay');
        limitDisplay.textContent = limit.toLocaleString('es-ES');

        // cálculos (digit-by-digit mental rigor aplicado: usamos aritmética JS, con redondeo a 2 decimales)
        const sumValues = values.reduce((a, b) => a + b, 0);
        const rawPercents = values.map(v => (v / limit) * 100); // porcentaje relativo al límite
        const percentsRounded = rawPercents.map(p => Math.round(p * 100) / 100); // 2 decimales

        // función para crear un chip en leyenda
        function createChip(text) {
            const d = document.createElement('div');
            d.className = 'chip';
            d.textContent = text;
            return d;
        }

        // Limpia barra y leyenda
        bar.innerHTML = '';
        legend.innerHTML = '';

        // Si suma > límite: indicamos overflow y opcionalmente escalamos para que la barra no pase 100% visual
        const isOverflow = sumValues > limit;

        // Si hay overflow, calculamos factor de escala para ajustar visualmente pero mantener datos reales en leyenda:
        const scaleFactor = isOverflow ? (limit / sumValues) : 1;

        // Construcción de segmentos
        values.forEach((val, i) => {
            const seg = document.createElement('div');
            seg.className = `segment ${colors[i]}`;
            const adjustedPercent = Math.round(((val / limit) * scaleFactor) * 10000) / 100; // 2 decimales visuales
            seg.style.flex = `0 0 ${adjustedPercent}%`;
            // texto: mostramos porcentaje relativo al límite real y valor bruto
            const pctText = (Math.round(((val / limit) * 100) * 100) / 100).toLocaleString('es-ES') + '%';
            seg.textContent = pctText;
            seg.title = `${labels[i]} — ${val.toLocaleString('es-ES')} / ${limit.toLocaleString('es-ES')} (${pctText})`;
            bar.appendChild(seg);

            // leyenda: valor real + porcentaje sobre límite
            const chip = createChip(`${labels[i]}: ${val.toLocaleString('es-ES')} (${pctText})`);
            chip.style.borderLeft = `6px solid ${getComputedStyle(document.documentElement).getPropertyValue('--bg')}`;
            // indicador de color en leyenda (pequeño cuadrado)
            const colorMark = document.createElement('span');
            colorMark.style.display = 'inline-block';
            colorMark.style.width = '12px';
            colorMark.style.height = '12px';
            colorMark.style.marginRight = '8px';
            colorMark.style.verticalAlign = 'middle';
            // Copiamos el color desde la regla CSS de la clase del segmento
            const segEl = document.createElement('div');
            segEl.className = colors[i];
            segEl.style.display = 'none';
            document.body.appendChild(segEl);
            const bg = getComputedStyle(segEl).backgroundColor;
            document.body.removeChild(segEl);
            colorMark.style.background = bg;
            chip.prepend(colorMark);
            legend.appendChild(chip);
        });

        // Espacio restante si sum < limit
        if (!isOverflow) {
            const remaining = limit - sumValues;
            const remainingPercent = Math.round((remaining / limit) * 10000) / 100; // 2 decimales
            const remDiv = document.createElement('div');
            remDiv.className = 'remaining';
            remDiv.style.flex = `0 0 ${remainingPercent}%`;
            remDiv.title = `Restante: ${remaining.toLocaleString('es-ES')} (${remainingPercent}%)`;
            // opcional: mostrar texto pequeño cuando haya espacio suficiente
            if (remainingPercent >= 8) {
                remDiv.textContent = `${remainingPercent}%`;
                remDiv.style.color = '#333';
                remDiv.style.fontWeight = '700';
                remDiv.style.fontSize = '12px';
                remDiv.style.display = 'flex';
                remDiv.style.alignItems = 'center';
                remDiv.style.justifyContent = 'center';
            }
            bar.appendChild(remDiv);

            // Añadir chip de restante
            const chipRem = createChip(`Restante: ${remaining.toLocaleString('es-ES')} (${remainingPercent}%)`);
            legend.appendChild(chipRem);
        } else {
            // Mostrar mensaje de overflow con el monto excedente
            const excedente = sumValues - limit;
            overflowMsg.style.display = 'block';
            overflowMsg.textContent = `Desbordamiento: la suma de segmentos excede el límite en ${excedente.toLocaleString('es-ES')}. La barra se muestra escalada para visualización.`;
            // Estilizamos la barra con borde de advertencia
            const wrap = document.getElementById('barWrap');
            wrap.style.border = 'var(--overflow-border)';
        }

        // Actualizamos atributos ARIA y el porcentaje total mostrado
        document.getElementById('bar').setAttribute('aria-valuenow', Math.min(sumValues, limit));
        const totalPct = Math.round((Math.min(sumValues, limit) / limit) * 10000) / 100;
        percentTotal.textContent = `${totalPct}% usado (${sumValues.toLocaleString('es-ES')}/${limit.toLocaleString('es-ES')})`;
    }
}

