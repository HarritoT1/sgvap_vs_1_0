@extends('layout')

@section('content')
    <div class="w-100 my-3 div-main">
        <h1 class="fw-bold my-3" style="font-size: 1.8rem; text-align:justify" id="graficas_pastel">Gráficas de pastel por cada viático existente.</h1>

        <div class="w-100 div-secondary px-5 py-5 d-block">
            <h2 class="mb-3 fw-bold" style="font-size: 1.5rem; text-align:justify">Llena los filtros y generá las gráficas:
            </h2>
            <form id="generar_graficas_viaticos_pastel" action="#" method="get"
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
                        <label for="opt1" class="form-label d-block fw-bold" style="font-size: 1.2rem;">Opciones personalizadas</label>
                        <div class="ps-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="personnel_inactive" id="opt1" value="true">
                                <label class="form-check-label fw-bold" for="opt1">Incluír empleados o personal inactivo actualmente.</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="proyects_inactive" id="opt2" value="true">
                                <label class="form-check-label fw-bold" for="opt2">Incluír proyectos concluídos actualmente.</label>
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
            </form>
        </div>
    </div>

    <br>

    <div class="d-flex gap-2 justify-content-between align-items-stretch px-2 flex-wrap">
        <div class="p-3 d-inline-block rounded-3 do_responsive_div2"
            style="box-shadow: 0px 7px 11px 0px rgba(0,0,0,0.75);">
            <canvas id="myChart0" data-yValues="[55, 49, 44, 24]" data-xValues='["Juan Manuel", "Pedro", "Luis", "Carlos"]'
                data-title="Viático Alimentos:"></canvas>
        </div>

        <div class="p-3 d-inline-block rounded-3 do_responsive_div2"
            style="box-shadow: 0px 7px 11px 0px rgba(0,0,0,0.75);">
            <canvas id="myChart1" data-yValues="[55, 49, 44, 24]" data-xValues='["Juan Manuel", "Pedro", "Luis", "Carlos"]'
                data-title="Viático Traslados Locales:"></canvas>
        </div>

        <div class="p-3 d-inline-block rounded-3 do_responsive_div2"
            style="box-shadow: 0px 7px 11px 0px rgba(0,0,0,0.75);">
            <canvas id="myChart2" data-yValues="[55, 49, 44, 24]" data-xValues='["Juan Manuel", "Pedro", "Luis", "Carlos"]'
                data-title="Viático Traslados Externos:"></canvas>
        </div>

        <div class="p-3 d-inline-block rounded-3 do_responsive_div2"
            style="box-shadow: 0px 7px 11px 0px rgba(0,0,0,0.75);">
            <canvas id="myChart3" data-yValues="[55, 49, 44, 24]" data-xValues='["Juan Manuel", "Pedro", "Luis", "Carlos"]'
                data-title="Viático Comisión Bancaria:"></canvas>
        </div>

        <div class="p-3 d-inline-block rounded-3 do_responsive_div2"
            style="box-shadow: 0px 7px 11px 0px rgba(0,0,0,0.75);">
            <canvas id="myChart4" data-yValues="[55, 49, 44, 24]" data-xValues='["Juan Manuel", "Pedro", "Luis", "Carlos"]'
                data-title="Viático Gasolina:"></canvas>
        </div>

        <div class="p-3 d-inline-block rounded-3 do_responsive_div2"
            style="box-shadow: 0px 7px 11px 0px rgba(0,0,0,0.75);">
            <canvas id="myChart5" data-yValues="[55, 49, 44, 24]" data-xValues='["Juan Manuel", "Pedro", "Luis", "Carlos"]'
                data-title="Viático Caseta:"></canvas>
        </div>

        <div class="p-3 d-inline-block rounded-3 do_responsive_div2"
            style="box-shadow: 0px 7px 11px 0px rgba(0,0,0,0.75);"> 
            <canvas id="myChart6"  data-yValues="[55, 49, 44, 24]" data-xValues='["Juan Manuel", "Pedro", "Luis", "Carlos"]'
                data-title="Viático Hospedaje:"></canvas>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('canvas').forEach(canvas => {
                const yValues = JSON.parse(canvas.dataset.yvalues); // convierte la cadena a arreglo.
                const title = canvas.dataset.title;
                const xValues = JSON.parse(canvas.dataset.xvalues); // convierte la cadena a arreglo.
                generate_graphs_pastel(canvas.id, xValues, yValues, title);
            });
        });
    </script>
@endsection
