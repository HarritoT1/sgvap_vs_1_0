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
    if (confirm("¿Está seguro de guardar los cambios?")) {
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

function ask_before_submit_new() {
    if (confirm("¿Está seguro de esta operación?")) {
        const form = document.querySelector("form");
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

        fetch(`/empleados/buscar-rfc?q=${query}`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            }
        })
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

        fetch(`/projects/buscar-id?q=${query}`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            }
        })
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
    const contenedor_barra_presupuesto_viaticos = document.getElementById('contenedor_barra_presupuesto_viaticos');
    const contenedor_barra_fecha_limite = document.getElementById('contenedor_barra_fecha_limite');

    if (input_id_proyect.length < 5) {
        if (!(contenedor_barra_presupuesto_viaticos.classList.contains("d-none"))) contenedor_barra_presupuesto_viaticos.classList.add('d-none');
        if (!(contenedor_barra_fecha_limite.classList.contains("d-none"))) contenedor_barra_fecha_limite.classList.add('d-none');
        return;
    }

    if (contenedor_barra_presupuesto_viaticos.classList.contains("d-none")) contenedor_barra_presupuesto_viaticos.classList.remove('d-none');
    if (contenedor_barra_fecha_limite.classList.contains("d-none")) contenedor_barra_fecha_limite.classList.remove('d-none');

    console.log(`Generando valores de las barras de progreso del proyecto con id: ${input_id_proyect}...`)

    try {
        /*const response = await fetch(`/proyectprogressbargenerator?q=${input_id_proyect}`, {
            method: 'GET', 
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            }
        });
    
        const data = await response.json();*/
        const data = {
            generacion_progress_bar: true,
            project: {
                fecha_creacion: "2025-09-01T22:35:12.000000Z",
                fecha_limite: "2025-12-22",
                nombre: "Proyecto de prueba"
            }
        };

        if (/*data.generacion_progress_bar ||*/ true) {
            /* 1RA BARRA DE PROGRESO. */

            /*const monto_alimentos = data.totales_viaticos_table_daily.total_alimentos;
            const monto_traslados = data.totales_viaticos_table_daily.total_traslados;
            const monto_comision = data.totales_viaticos_table_daily.total_comision;
            const monto_gasolina = data.totales_viaticos_table_gasoline.total_comision;
            const monto_caseta = data.totales_viaticos_table_tag.total_comision;
            const monto_hospedaje = data.totales_viaticos_lodging_daily.total_comision;
            const limit = data.project.estimado_viaticos;
            const values = [monto_alimentos, monto_traslados, monto_comision, monto_gasolina, monto_caseta, monto_hospedaje];*/

            const limit = 260000; // límite requerido.
            // --- EJEMPLO: modifica estos valores como necesites ---
            //const values = [50000, 70000, 20000, 30000]; // suma=170000 (< limit).
            const values = [20000, 90000, 20000, 90000, 90000, 90000]; // ejemplo > limit.
            // ----------------------------------------------------

            const colors = ['seg-0', 'seg-1', 'seg-2', 'seg-3', 'seg-4', 'seg-5'];
            const labels = ['Alimentos', 'Traslados', 'Comisión', 'Gasolina', 'Casetas', 'Hospedajes'];

            const bar = document.getElementById('bar');
            const legend = document.getElementById('legend');
            const overflowMsg = document.getElementById('overflowMsg');
            const percentTotal = document.getElementById('percentTotal');
            const limitDisplay = document.getElementById('limitDisplay');
            limitDisplay.textContent = limit.toLocaleString('es-MX');

            // cálculos (digit-by-digit mental rigor aplicado: usamos aritmética JS, con redondeo a 2 decimales).
            const sumValues = values.reduce((a, b) => a + b, 0);
            const rawPercents = values.map(v => (v / limit) * 100); // porcentaje relativo al límite.
            const percentsRounded = rawPercents.map(p => Math.round(p * 100) / 100); // 2 decimales.

            // función para crear un chip en leyenda
            function createChip(text) {
                const d = document.createElement('div');
                d.className = 'chip';
                d.textContent = text;
                return d;
            }

            // Limpia barra y leyenda.
            bar.innerHTML = '';
            legend.innerHTML = '';

            // Si suma > límite: indicamos overflow y opcionalmente escalamos para que la barra no pase 100% visual.
            const isOverflow = sumValues > limit;

            // Si hay overflow, calculamos factor de escala para ajustar visualmente pero mantener datos reales en leyenda:
            const scaleFactor = isOverflow ? (limit / sumValues) : 1;

            // Construcción de segmentos.
            values.forEach((val, i) => {
                const seg = document.createElement('div');
                seg.className = `segment ${colors[i]}`;
                const adjustedPercent = Math.round(((val / limit) * scaleFactor) * 10000) / 100; // 2 decimales visuales.
                seg.style.flex = `0 0 ${adjustedPercent}%`;
                // texto: mostramos porcentaje relativo al límite real y valor bruto.
                const pctText = percentsRounded[i].toLocaleString('es-MX') + '%';
                seg.textContent = pctText;
                seg.title = `${labels[i]} — ${val.toLocaleString('es-MX')} / ${limit.toLocaleString('es-MX')} (${pctText})`;
                bar.appendChild(seg);

                // leyenda: valor real + porcentaje sobre límite.
                const chip = createChip(`${labels[i]}: $${val.toLocaleString('es-MX')} (${pctText})`);
                chip.style.borderLeft = `6px solid ${getComputedStyle(document.documentElement).getPropertyValue('--bg')}`;
                // indicador de color en leyenda (pequeño cuadrado).
                const colorMark = document.createElement('span');
                colorMark.style.display = 'inline-block';
                colorMark.style.width = '12px';
                colorMark.style.height = '12px';
                colorMark.style.marginRight = '8px';
                colorMark.style.verticalAlign = 'middle';
                // Copiamos el color desde la regla CSS de la clase del segmento.
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

            // Espacio restante si sum < limit.
            if (!isOverflow) {
                const remaining = limit - sumValues;
                const remainingPercent = Math.round((remaining / limit) * 10000) / 100; // 2 decimales.
                const remDiv = document.createElement('div');
                remDiv.className = 'remaining';
                remDiv.style.flex = `0 0 ${remainingPercent}%`;
                remDiv.title = `Restante: ${remaining.toLocaleString('es-MX')} (${remainingPercent.toLocaleString('es-MX')}%)`;
                // opcional: mostrar texto pequeño cuando haya espacio suficiente.
                if (remainingPercent >= 5) {
                    remDiv.textContent = `${remainingPercent.toLocaleString('es-MX')}%`;
                    remDiv.style.color = '#333';
                    remDiv.style.fontWeight = '700';
                    remDiv.style.fontSize = '1.2rem';
                    remDiv.style.display = 'flex';
                    remDiv.style.alignItems = 'center';
                    remDiv.style.justifyContent = 'center';
                }
                bar.appendChild(remDiv);

                // Añadir chip de restante
                const chipRem = createChip(`Restante: $${remaining.toLocaleString('es-MX')} (${remainingPercent.toLocaleString('es-MX')}%)`);

                // indicador de color en leyenda (pequeño cuadrado).
                const colorMark = document.createElement('span');
                colorMark.style.display = 'inline-block';
                colorMark.style.width = '12px';
                colorMark.style.height = '12px';
                colorMark.style.marginRight = '8px';
                colorMark.style.verticalAlign = 'middle';
                colorMark.style.background = '#cfd6db';
                chipRem.prepend(colorMark);
                legend.appendChild(chipRem);
            } else {
                // Mostrar mensaje de overflow con el monto excedente.
                const excedente = sumValues - limit;
                overflowMsg.style.display = 'block';
                overflowMsg.textContent = `Desbordamiento: la suma de segmentos excede el límite en $${excedente.toLocaleString('es-MX')}. La barra se muestra escalada para visualización.`;
                // Estilizamos la barra con borde de advertencia.
                const wrap = document.getElementById('barWrap');
                wrap.style.border = 'var(--overflow-border)';
            }

            // Actualizamos atributos ARIA y el porcentaje total mostrado.
            document.getElementById('bar').setAttribute('aria-valuenow', sumValues);
            document.getElementById('bar').setAttribute('aria-valuemax', limit);
            const totalPct = Math.round((sumValues / limit) * 10000) / 100;
            percentTotal.textContent = `${totalPct}% usado ($${sumValues.toLocaleString('es-MX')} / $${limit.toLocaleString('es-MX')})`;

            /* 2DA BARRA DE PROGRESO. */
            const fecha_limite = new Date(data.project.fecha_limite.split("T")[0] + "T00:00:00");
            const fecha_creacion = new Date(data.project.fecha_creacion.split("T")[0] + "T00:00:00");
            const fecha_actual = new Date();
            const diffDias_enteros = Math.floor((fecha_actual - fecha_creacion) / (1000 * 60 * 60 * 24));

            const limit1 = Math.floor((fecha_limite - fecha_creacion) / (1000 * 60 * 60 * 24));
            const values1 = [diffDias_enteros];

            const porcentaje = (diffDias_enteros / limit1) * 100;

            const colors1 = ['seg-6'];
            const labels1 = ['Días usados'];

            const bar1 = document.getElementById('bar1');
            const overflowMsg1 = document.getElementById('overflowMsg1');
            const percentTotal1 = document.getElementById('percentTotal1');
            const limitDisplay1 = document.getElementById('limitDisplay1');
            limitDisplay1.textContent = fecha_limite.toLocaleDateString();

            const porcentajeRounded1 = Math.round(porcentaje * 100) / 100;

            bar1.innerHTML = '';

            const isOverflow1 = diffDias_enteros > limit1;

            const scaleFactor1 = isOverflow1 ? (limit1 / diffDias_enteros) : 1;

            values1.forEach((val, i) => {
                const seg = document.createElement('div');
                seg.className = `segment ${colors1[i]}`;
                const adjustedPercent = Math.round(((val / limit1) * scaleFactor1) * 10000) / 100;
                seg.style.flex = `0 0 ${adjustedPercent}%`;
                const pctText = porcentajeRounded1.toLocaleString('es-MX') + '%';
                seg.textContent = pctText;
                seg.title = `${labels1[i]} — ${val.toLocaleString('es-MX')} días / ${limit1.toLocaleString('es-MX')} días (${pctText})`;
                bar1.appendChild(seg);
            });

            if (!isOverflow1) {
                const remaining = limit1 - diffDias_enteros;
                const remainingPercent = Math.round((remaining / limit1) * 10000) / 100;
                const remDiv = document.createElement('div');
                remDiv.className = 'remaining';
                remDiv.style.flex = `0 0 ${remainingPercent}%`;
                remDiv.title = `Días restantes: ${remaining.toLocaleString('es-MX')} (${remainingPercent.toLocaleString('es-MX')}%)`;

                if (remainingPercent >= 5) {
                    remDiv.textContent = `${remainingPercent.toLocaleString('es-MX')}%`;
                    remDiv.style.color = '#333';
                    remDiv.style.fontWeight = '700';
                    remDiv.style.fontSize = '1.2rem';
                    remDiv.style.display = 'flex';
                    remDiv.style.alignItems = 'center';
                    remDiv.style.justifyContent = 'center';
                }
                bar1.appendChild(remDiv);
            } else {
                const excedente = diffDias_enteros - limit1;
                overflowMsg1.style.display = 'block';
                overflowMsg1.textContent = `Desbordamiento: la fecha actual excede en ${excedente.toLocaleString('es-MX')} días a la fecha límite del proyecto. La barra se muestra escalada para visualización.`;
                const wrap = document.getElementById('barWrap1');
                wrap.style.border = 'var(--overflow-border)';
            }

            document.getElementById('bar1').setAttribute('aria-valuenow', diffDias_enteros);
            document.getElementById('bar1').setAttribute('aria-valuemax', limit1);
            const totalPct1 = Math.round((diffDias_enteros / limit1) * 10000) / 100;
            percentTotal1.textContent = `${totalPct1}% usado (${diffDias_enteros.toLocaleString('es-MX')} días / ${limit1.toLocaleString('es-MX')} días)`;
        }
    } catch (error) {
        console.error("Error en el fetch:", error);
        alert("Hubo un problema al obtener los datos del proyecto. Intenta de nuevo.");
    }
}

async function show_all_personnel(e, anio_query, id_query) {
    const check_show = document.getElementById('tables_of_all_personnel');

    if (e.target.checked) {
        check_show.innerHTML = '';
        console.log("Cargando tablas de cada el empleado...");

        try {
            /*const response = await fetch(`/allpersonneltables?anio=${anio_query}&id=${id_query}`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                }
            });

            const data = await response.json();*/

            // Lógica de presentación: renderizar cada tabla por separado.
            // data is an array of objects, each object represents an row in the table monthly_expense_cuts.
            // some objects have the same employee_id, so we need to group them by employee_id.

            let currentEmployeeId = null;
            let currentTable = null;
            let hr = document.createElement('hr');
            hr.className = 'my-4 mb-2';

            datas.forEach(record => {
                if (record.employee_id !== currentEmployeeId) {
                    console.log("Nuevo empleado detectado, creando nueva tabla para id:", record.employee_id);
                    // New employee detected, create a new table.
                    if (currentTable) {
                        // Append the previous table to the container.
                        check_show.appendChild(currentTable);
                        check_show.appendChild(hr.cloneNode()); // add a horizontal line between tables.
                        currentTable = null;
                    }

                    // Create a new table for the new employee.
                    currentEmployeeId = record.employee_id;
                    currentTable = document.createElement('div');
                    currentTable.className = 'table-responsive small my-4';
                    currentTable.innerHTML = `<h2 class="fw-bold my-3" style="font-size: 2rem; text-align:justify">Corte anual ${record.anio} del empleado ${record.nombre}: </h2>
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr class="text-center">
                                <th scope="col" style="font-size: 1.3rem;">Mes</th>
                                <th scope="col" style="font-size: 1.3rem;">Año específico</th>
                                <th scope="col" style="font-size: 1.3rem;">Total alimentos</th>
                                <th scope="col" style="font-size: 1.3rem;">Total traslados locales</th>
                                <th scope="col" style="font-size: 1.3rem;">Total traslados externos</th>
                                <th scope="col" style="font-size: 1.3rem;">Total comisión bancaria</th>
                                <th scope="col" style="font-size: 1.3rem;">Total comisión Sí Vale</th>
                                <th scope="col" style="font-size: 1.3rem;">Total de IVA</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center" style="font-size: 1.2rem;">
                                <td>${record.mes}</td>
                                <td>${record.anio}</td>
                                <td>$ ${record.total_alimentos_mes.toLocaleString('es-MX')}</td>
                                <td>$ ${record.total_traslado_local_mes.toLocaleString('es-MX')}</td>
                                <td>$ ${record.total_traslado_externo_mes.toLocaleString('es-MX')}</td>
                                <td>$ ${record.total_comision_bancaria_mes.toLocaleString('es-MX')}</td>
                                <td>$ ${record.total_comision_sivale_mes.toLocaleString('es-MX')}</td>
                                <td>$ ${record.total_iva_mes.toLocaleString('es-MX')}</td>
                            </tr>
                        </tbody>
                    </table>
                    `;
                } else {
                    // Same employee, append a new row to the current table.
                    console.log("Mismo empleado, agregando fila a la tabla actual para id:", record.employee_id);
                    const tbody = currentTable.querySelector('tbody');
                    const newRow = document.createElement('tr');
                    newRow.className = 'text-center';
                    newRow.style.fontSize = '1.2rem';
                    newRow.innerHTML = `
                        <td>${record.mes}</td>
                        <td>${record.anio}</td>
                        <td>$ ${record.total_alimentos_mes.toLocaleString('es-MX')}</td>
                        <td>$ ${record.total_traslado_local_mes.toLocaleString('es-MX')}</td>
                        <td>$ ${record.total_traslado_externo_mes.toLocaleString('es-MX')}</td>
                        <td>$ ${record.total_comision_bancaria_mes.toLocaleString('es-MX')}</td>
                        <td>$ ${record.total_comision_sivale_mes.toLocaleString('es-MX')}</td>
                        <td>$ ${record.total_iva_mes.toLocaleString('es-MX')}</td>
                    `;
                    tbody.appendChild(newRow);
                }
            });

            if (currentTable) {
                // Append the previous table to the container.
                check_show.appendChild(currentTable);
                check_show.appendChild(hr.cloneNode()); // add a horizontal line between tables.
                currentTable = null;
            }

        } catch (error) {
            console.error("Error en el fetch:", error);
            alert("Hubo un problema al cargar las tablas de empleados. Intenta de nuevo.");
        }

        check_show.classList.remove('d-none');

    } else {
        check_show.classList.add('d-none');
        check_show.innerHTML = '';
    }
}

const datas = [
    {
        employee_id: 1,
        nombre: "Juan Pérez",
        anio: 2024,
        mes: "Enero",
        total_alimentos_mes: 1500.50,
        total_traslado_local_mes: 300.75,
        total_traslado_externo_mes: 120.00,
        total_comision_bancaria_mes: 50.25,
        total_comision_sivale_mes: 30.00,
        total_iva_mes: 240.10
    },
    {
        employee_id: 1,
        nombre: "Juan Pérez",
        anio: 2024,
        mes: "Febrero",
        total_alimentos_mes: 1600.00,
        total_traslado_local_mes: 320.00,
        total_traslado_externo_mes: 110.00,
        total_comision_bancaria_mes: 55.00,
        total_comision_sivale_mes: 35.00,
        total_iva_mes: 250.00
    },
    {
        employee_id: 2,
        nombre: "María López",
        anio: 2024,
        mes: "Enero",
        total_alimentos_mes: 1400.00,
        total_traslado_local_mes: 280.00,
        total_traslado_externo_mes: 100.00,
        total_comision_bancaria_mes: 45.00,
        total_comision_sivale_mes: 25.00,
        total_iva_mes: 230.00
    },
    {
        employee_id: 2,
        nombre: "María López",
        anio: 2024,
        mes: "Febrero",
        total_alimentos_mes: 1450.00,
        total_traslado_local_mes: 290.00,
        total_traslado_externo_mes: 105.00,
        total_comision_bancaria_mes: 48.00,
        total_comision_sivale_mes: 28.00,
        total_iva_mes: 235.00
    },
    {
        employee_id: 3,
        nombre: "Panchito Gómez",
        anio: 2024,
        mes: "Enero",
        total_alimentos_mes: 1400.00,
        total_traslado_local_mes: 280.00,
        total_traslado_externo_mes: 100.00,
        total_comision_bancaria_mes: 45.00,
        total_comision_sivale_mes: 25.00,
        total_iva_mes: 230.00
    }
];

// Luego puedes usar este array `datas` directamente en tu función para probar la lógica de renderizado.

function set_required_input_find_id_proyect() {
    document.getElementById('input_find_id_proyect').addEventListener('input', function () {
        const query = this.value;

        if (query.length < 4) {
            document.getElementById('input_find_rfc').value = "";
            document.getElementById('input_find_rfc').disabled = true;
            document.getElementById('input_find_id_proyect').required = false;
            return;
        }

        console.log("Habilitando input de RFC...");
        document.getElementById('input_find_rfc').disabled = false;
    });

    document.getElementById('input_find_rfc').addEventListener('input', function () {
        document.getElementById('input_find_id_proyect').required = true;
    });
}

function set_required_input_vehicle_id() {
    document.getElementById('input_find_id_proyect').addEventListener('input', function () {
        const query = this.value;

        if (query.length < 4) {
            document.getElementById('vehicle_id').value = "";
            document.getElementById('vehicle_id').disabled = true;
            document.getElementById('input_find_id_proyect').required = false;
            return;
        }

        console.log("Habilitando select de vehicle_id...");
        document.getElementById('vehicle_id').disabled = false;
    });

    document.getElementById('vehicle_id').addEventListener('change', function () {
        document.getElementById('input_find_id_proyect').required = true;
    });
}

function generate_graphs_barras(id_canvas, yValues, title) {
    var barColors = ["#ff0000", "#0000ff", "#008000", "#ff00ff"];
    var xValues = ["Alimentos", "Tras. Locales", "Tras. Externos", "Comisión Bancaria"];
    const yValuesNum = yValues.map(Number); // [55, 49, 44, 24]

    new Chart(id_canvas, {
        type: "bar",
        data: {
            labels: xValues,
            datasets: [{
                backgroundColor: barColors,
                data: yValuesNum
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // para que respete el tamaño del canvas.
            legend: { display: false },
            title: {
                display: true,
                text: title,
                fontSize: 20,
                fontStyle: 'bold',
                fontColor: "gray"
            },
            tooltips: {
                callbacks: {
                    label: function (tooltipItem, data) {
                        var dataset = data.datasets[tooltipItem.datasetIndex];
                        var value = dataset.data[tooltipItem.index];
                        var label = data.labels[tooltipItem.index]; // <-- aquí está tu xValue.
                        return ' ' + label + ': $ ' + Number(value).toLocaleString('es-MX');
                    }
                }
            },
            scales: {
                xAxes: [{
                    ticks: {
                        fontSize: 12 // Tamaño de las etiquetas del eje X.
                    }
                }],
                yAxes: [{
                    ticks: {
                        callback: function (value) {
                            return '$ ' + value.toLocaleString('es-MX'); // agrega símbolo $ y separador de miles
                        }
                    }
                }]
            }
        }
    });
}

function generate_graphs_barras_vtc_especifico(id_canvas, xValues, yValues, title) {
    var cantXvalues = xValues.length;
    document.getElementById(id_canvas).style.width = (cantXvalues * 60) + 'px !important';
    //necesito generar n colores distintos.
    var barColors = [];
    for (var i = 0; i < cantXvalues; i++) {
        var color = '#' + Math.floor(Math.random() * 16777215).toString(16).padStart(6, "0");
        barColors.push(color);
    }
    const yValuesNum = yValues.map(Number); // [55, 49, 44, 24]

    new Chart(id_canvas, {
        type: "bar",
        data: {
            labels: xValues,
            datasets: [{
                backgroundColor: barColors,
                data: yValuesNum,
                barThickness: 60 // ancho fijo mínimo de cada barra en píxeles.
            }]
        },
        options: {
            responsive: false,
            maintainAspectRatio: false, // para que respete el tamaño del canvas.
            legend: { display: false },
            title: {
                display: true,
                text: title,
                fontSize: 20,
                fontStyle: 'bold',
                fontColor: "gray"
            },
            tooltips: {
                callbacks: {
                    label: function (tooltipItem, data) {
                        var dataset = data.datasets[tooltipItem.datasetIndex];
                        var value = dataset.data[tooltipItem.index];
                        var label = data.labels[tooltipItem.index]; // <-- aquí está tu xValue.
                        return ' ' + label + ': $ ' + Number(value).toLocaleString('es-MX');
                    }
                }
            },
            scales: {
                xAxes: [{
                    ticks: {
                        fontSize: 12 // Tamaño de las etiquetas del eje X.
                    }
                }],
                yAxes: [{
                    ticks: {
                        callback: function (value) {
                            return '$ ' + value.toLocaleString('es-MX'); // agrega símbolo $ y separador de miles
                        }
                    }
                }]
            }
        }
    });
}

function generate_graphs_pastel(id_canvas, xValues, yValues, title) {
    var cantXvalues = xValues.length;
    //necesito generar n colores distintos.
    var pieColors = [];
    for (var i = 0; i < cantXvalues; i++) {
        var color = '#' + Math.floor(Math.random() * 16777215).toString(16).padStart(6, "0");
        pieColors.push(color);
    }
    const yValuesNum = yValues.map(Number); // [55, 49, 44, 24]

    new Chart(id_canvas, {
        type: "pie",
        data: {
            labels: xValues,
            datasets: [{
                backgroundColor: pieColors,
                data: yValuesNum
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // para que respete el tamaño del canvas.
            title: {
                display: true,
                text: title,
                fontSize: 20,
                fontStyle: 'bold',
                fontColor: "gray"
            },
            tooltips: {
                callbacks: {
                    label: function (tooltipItem, data) {
                        var dataset = data.datasets[tooltipItem.datasetIndex];
                        var value = dataset.data[tooltipItem.index];
                        var label = data.labels[tooltipItem.index]; // <-- aquí está tu xValue.
                        return ' ' + label + ': $ ' + Number(value).toLocaleString('es-MX');
                    }
                }
            }
        }
    });
}

function asig_listener_autocomputed_inputs() {
    const base_imponible = document.getElementById('base_imponible');
    const iva_acumulado = document.getElementById('iva_acumulado');
    const importe_total = document.getElementById('importe_total');

    document.getElementById('monto_dispersado').addEventListener('input', function () {
        importe_total.value = this.value ? parseFloat(this.value) : 0;
        base_imponible.value = (importe_total.value / 1.16).toFixed(2);
        iva_acumulado.value = (importe_total.value - parseFloat(base_imponible.value)).toFixed(2);
    });
}

function asig_listener_on_change() {
    document.getElementById('xls_gasoline').addEventListener('change', function (event) {
        const file = event.target.files[0]; // Accede al primer archivo seleccionado.
        if (file) {
            document.getElementById('button_analizar_excel').disabled = false;
            document.getElementById('button_analizar_excel').style.backgroundColor = "var(--botones-color)";
        }
        else {
            document.getElementById('button_analizar_excel').disabled = true;
            document.getElementById('button_analizar_excel').style.backgroundColor = "rgb(161, 160, 160)";
        }
    });
}

function analizar_xls(expectedHeadersParam) {
    if (confirm("¿Estás seguro de que deseas analizar el archivo Excel seleccionado?")) {
        console.log("Analizando archivo Excel...");
        processExcelFile();
    }

    else window.location.reload();

    function processExcelFile() {
        const input = document.getElementById('xls_gasoline');
        const file = input.files[0];

        if (!file) return;

        const reader = new FileReader();
        reader.onload = function (event) {
            const data = new Uint8Array(event.target.result);
            const workbook = XLSX.read(data, { type: 'array' });

            // Suponiendo que quieres la primera hoja.
            const sheetName = workbook.SheetNames[0];
            const worksheet = workbook.Sheets[sheetName];

            // Convierte la hoja a JSON usando la primera fila como headers.
            const jsonData = XLSX.utils.sheet_to_json(worksheet, { header: 1 });

            // jsonData[0] = headers.
            const headers = jsonData[0].map(h => h.trim());
            const rows = jsonData.slice(1);

            console.log("Headers extraídos:", headers);

            // Validar que los headers coincidan exactamente.
            const expectedHeaders = expectedHeadersParam;

            console.log("Headers esperados:", expectedHeaders);

            console.log(JSON.stringify(headers));
            console.log(JSON.stringify(expectedHeaders));

            const validHeaders = JSON.stringify(headers) === JSON.stringify(expectedHeaders);

            if (!validHeaders) {
                alert("Los headers no coinciden con lo esperado o alguna otra característica mencionada no esta satisfecha.");
                window.location.reload();
                return;
            }

            // Convertir filas a objetos.
            const objects = rows.map(row => {
                let obj = {};
                headers.forEach((h, i) => {
                    if (typeof row[i] === 'string' && h === 'fecha_dispersion') obj[h] = row[i].replaceAll('"', '').trim();
                    if (typeof row[i] === 'number') obj[h] = Number(row[i].toFixed(3));
                    else obj[h] = row[i] !== undefined ? row[i] : null;
                });
                return obj;
            });

            console.log("Objetos generados:", objects);

            // Mandar al backend.
            fetch('/gdm_gasolina_auto_alta_xls', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(objects)
            }).then(res => res.json())
                .then(object => {
                    console.log("Respuesta del backend:", object);
                    if (object.success) {
                        alert("Archivo procesado correctamente. Se han registrado los datos.");
                        window.location.reload();
                    } else {
                        alert("Hubo un problema al procesar el archivo. Intenta de nuevo.");
                        window.location.reload();
                    }
                })
                .catch(err => console.error("Error enviando datos:", err));
        };

        reader.readAsArrayBuffer(file);
    }
}

async function get_results_and_show_them_like_links(endpoint) {
    const list = document.getElementById('lista_resultados');
    if (!list.classList.contains('d-none')) list.classList.add('d-none');
    list.innerHTML = ''; // Limpiar resultados previos.
    const form = document.querySelector("form");
    const inputs = form.querySelectorAll("input, select");
    const data = {};

    inputs.forEach(input => {
        data[input.name] = input.value;
    });

    try {

        if (form.checkValidity()) {

            form.classList.add('was-validated');

            const response = await fetch(endpoint, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();
            console.log("Respuesta del backend:", result);

            if (response.ok) {
                //Aquí procesas result que es un array de objetos.
                result.forEach(item => {
                    const li = document.createElement('li');
                    li.className = 'mb-2';
                    const a = document.createElement('a');
                    a.className = 'fw-bold';
                    a.target = "_self";
                    a.style.fontSize = "1.3rem";
                    a.style.textDecoration = "none";
                    a.style.textAlign = "justify";
                    a.style.color = "var(--empresa-color)";
                    a.textContent = `Dispersión de gasolina del ${item.fecha_dispersion} para proyecto ${item.project_name} al vehículo con placa ${item.vehicle_id}.`;
                    a.href = `/gdm_gasolina_disp_consulta_act/${item.id}`;
                    li.appendChild(a);
                    list.appendChild(li);
                });

                list.classList.remove('d-none');
            }

            else {
                throw new Error(response.message || 'Error en la respuesta del servidor');
            }
        }

    } catch (error) {
        console.error("Error en el fetch:", error);
        alert("Hubo un problema al obtener los datos. Intenta de nuevo.");
    }
}