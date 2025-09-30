@extends('layout')

@section('content')
    <div class="w-100 my-3 div-main">
        <h1 class="fw-bold my-3" style="font-size: 1.8rem; text-align:justify" id="graficas_barras">Gráficas de barras
            completando proyectos |
            empleados.
        </h1>

        <div class="w-100 div-secondary px-5 py-5 d-block">
            <h2 class="mb-3 fw-bold" style="font-size: 1.5rem; text-align:justify">Llena los filtros y generá las gráficas:
            </h2>
            <form id="generar_graficas_viaticos_barras" action="#" method="get"
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
                        <label for="input_find_id_proyect" class="form-label fw-bold" style="font-size: 1.2rem;">Id del
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

                    <div class="col-sm-6 mx-auto">
                        <label for="input_find_rfc" class="form-label fw-bold" style="font-size: 1.2rem;">RFC</label>
                        <input type="text" class="form-control" id="input_find_rfc" name="employee_id" placeholder=""
                            value="" maxlength="50" list="sugerencias_rfc" style="height: 3.5rem;" disabled>
                        <div class="invalid-feedback">
                            Ingresa un RFC válido.
                        </div>
                        <datalist id="sugerencias_rfc">
                        </datalist>
                    </div>

                    <hr class="my-4 mb-2">

                    <button class="d-block mx-auto btn btn-primary btn-lg fw-bold button-custom" type="button"
                        onclick="ask_before_submit_new()" style="background-color: var(--botones-color);">Generar</button>
            </form>
        </div>
    </div>

    <br>

    <div class="d-flex gap-2 justify-content-between align-items-stretch px-1 flex-wrap">
        <div class="p-3 d-inline-block rounded-3 do_responsive_div"
            style="box-shadow: 0px 0px 8px 0px rgba(0,0,0,0.75) inset;">
            <canvas id="myChart0" style="height: 22rem;" class="d-block w-90 mx-auto" data-yValues="[55, 49, 44, 24]"
                data-title="Proyecto con id: id"></canvas>
                <br>
                <hr class="my-4">
                <br>
            <canvas id="myChart1" style="height: 22rem;" class="d-block w-90 mx-auto" data-yValues="[55, 49, 44, 24]"
                data-title="Proyecto con id: id"></canvas>
                <br>
                <hr class="my-4">
                <br>
            <canvas id="myChart2" style="height: 22rem;" class="d-block w-90 mx-auto" data-yValues="[55, 49, 44, 24]"
                data-title="Proyecto con id: id"></canvas>
                <br>
                <hr class="my-4">
                <br>
            <canvas id="myChart3" style="height: 22rem;" class="d-block w-90 mx-auto" data-yValues="[55, 49, 44, 24]"
                data-title="Proyecto con id: id"></canvas>
                <br>
                <hr class="my-4">
                <br>
        </div>

        <div class="p-3 d-inline-block rounded-3 do_responsive_div"
            style="box-shadow: 0px 0px 8px 0px rgba(0,0,0,0.75) inset;">
            <canvas id="myChart4" style="height: 22rem;" class="d-block w-90 mx-auto" data-yValues="[55, 49, 44, 24]"
                data-title="Empleado con RFC: RFC"></canvas>
                <br>
                <hr class="my-4">
                <br>
            <canvas id="myChart5" style="height: 22rem;" class="d-block w-90 mx-auto" data-yValues="[55, 49, 44, 24]"
                data-title="Empleado con RFC: RFC"></canvas>
                <br>
                <hr class="my-4">
                <br>
            <canvas id="myChart6" style="height: 22rem;" class="d-block w-90 mx-auto" data-yValues="[55, 49, 44, 24]"
                data-title="Empleado con RFC: RFC"></canvas>
                <br>
                <hr class="my-4">
                <br>
            <canvas id="myChart7" style="height: 22rem;" class="d-block w-90 mx-auto" data-yValues="[55, 49, 44, 24]"
                data-title="Empleado con RFC: RFC"></canvas>
                <br>
                <hr class="my-8">
                <br>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('canvas').forEach(canvas => {
                const yValues = JSON.parse(canvas.dataset.yvalues); // convierte la cadena a arreglo
                const title = canvas.dataset.title;
                generate_graphs_barras(canvas.id, yValues, title);
            });
        });
    </script>
@endsection
