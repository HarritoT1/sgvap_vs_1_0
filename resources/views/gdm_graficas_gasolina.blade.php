@extends('layout')

@section('content')
    <div class="w-100 my-3 div-main">
        <h1 class="fw-bold my-3" style="font-size: 1.8rem; text-align:justify" id="graficas_barras_gasolina">Gráficas de
            dispersiones de gasolina.
        </h1>

        <div class="w-100 div-secondary px-5 py-5 d-block">
            <h2 class="mb-3 fw-bold" style="font-size: 1.5rem; text-align:justify">Llena los filtros y generá las gráficas:
            </h2>
            <form id="generar_graficas_viatico_gasolina" action="#" method="get"
                enctype="application/x-www-form-urlencoded" autocomplete="off" class="needs-validation p-1" novalidate>
                <div class="row g-3">
                    <div class="col-sm-6" style="max-width: 100%;" id="campo_mes">
                        <label for="mes" class="form-label fw-bold" style="font-size: 1.2rem;">Mes</label>
                        <select name="mes" id="mes" class="form-control form-select"
                            aria-label="Default select example" style="height: 3.5rem;">
                            <option value="" selected>
                                NINGUNO
                            </option>
                            <option value="1">
                                ENERO
                            </option>
                            <option value="2">
                                FEBRERO
                            </option>
                            <option value="3">
                                MARZO
                            </option>
                            <option value="4">
                                ABRIL
                            </option>
                            <option value="5">
                                MAYO
                            </option>
                            <option value="6">
                                JUNIO
                            </option>
                            <option value="7">
                                JULIO
                            </option>
                            <option value="8">
                                AGOSTO
                            </option>
                            <option value="9">
                                SEPTIEMBRE
                            </option>
                            <option value="10">
                                OCTUBRE
                            </option>
                            <option value="11">
                                NOVIEMBRE
                            </option>
                            <option value="12">
                                DICIEMBRE
                            </option>
                        </select>
                        <div class="invalid-feedback">
                            Ingresa un mes válido.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="input_find_id_proyect" class="form-label fw-bold" style="font-size: 1.2rem;">id del
                            proyecto</label>
                        <input type="text" class="form-control" id="input_find_id_proyect" name="project_id"
                            placeholder="" value="" maxlength="80" list="sugerencias_id_proyect"
                            style="height: 3.5rem;">
                        <div class="invalid-feedback">
                            Ingresa un id de proyecto válido.
                        </div>
                        <datalist id="sugerencias_id_proyect">
                        </datalist>
                    </div>

                    <div class="col-sm-6 mx-auto" style="max-width: 100%;" id="campo_placa">
                        <label for="vehicle_id" class="form-label fw-bold" style="font-size: 1.2rem;">Placa del
                            vehículo</label>
                        <select name="vehicle_id" id="vehicle_id" class="form-control form-select"
                            aria-label="Default select example" style="height: 3.5rem;" disabled>
                            <option value="" selected>
                                NINGUNO
                            </option>
                            <option value="ABJ1-W234">
                                ABJ1-W234
                            </option>
                        </select>
                        <div class="invalid-feedback">
                            Ingresa una placa de vehículo válida.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="opt1" class="form-label d-block fw-bold" style="font-size: 1.2rem;">Opciones
                            personalizadas</label>
                        <div class="ps-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="proyects_inactive" id="opt1"
                                    value="true" {{ true ? '' : 'disabled' }}>
                                <label class="form-check-label fw-bold" for="opt2">Incluír proyectos concluídos
                                    actualmente.</label>
                            </div>
                            <!-- Aquí va el feedback para el grupo -->
                            <div class="invalid-feedback">
                                Selecciona una opción válida.
                            </div>
                        </div>
                    </div>

                    <hr class="my-4 mb-2">

                    <button class="d-block mx-auto btn btn-primary btn-lg fw-bold button-custom" type="button"
                        onclick="ask_before_submit_new()" style="background-color: var(--botones-color);">Generar</button>
                </div>
            </form>
        </div>
    </div>

    <br>

    <div class="d-flex gap-2 justify-content-between align-items-stretch px-1 flex-wrap">
        <div class="p-3 d-inline-block rounded-3 do_responsive_div3 mx-auto"
            style="box-shadow: 0px 0px 8px 0px rgba(0,0,0,0.75) inset;">
            <canvas id="myChartProjects_Gasoline" class="d-block mx-auto" data-xValues='["id_3", "id_4", "id_5", "id_9"]'
                data-yValues="[55, 49, 45, 32]" data-title="$nombre"></canvas>
        </div>

        <div class="p-3 d-inline-block rounded-3 do_responsive_div3 mx-auto"
            style="box-shadow: 0px 0px 8px 0px rgba(0,0,0,0.75) inset;">
            <canvas id="myChartVehicles_Gasoline" class="d-block mx-auto"
                data-xValues='["id_1", "id_2", "id_3", "id_4", "id_5", "id_6", "id_7", "id_8"]'
                data-yValues="[55, 49, 44, 64, 55, 49, 44, 24]" data-title="$nombre"></canvas>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('canvas').forEach(canvas => {
                const yValues = JSON.parse(canvas.dataset.yvalues); // convierte la cadena a arreglo
                const xValues = JSON.parse(canvas.dataset.xvalues); // convierte la cadena a arreglo
                const title = canvas.dataset.title;
                generate_graphs_barras_vtc_especifico(canvas.id, xValues, yValues, title);
            });
        });
    </script>
@endsection
