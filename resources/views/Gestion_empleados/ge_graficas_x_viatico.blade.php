@extends('layout')

@section('content')
    <div class="w-100 my-3 div-main">
        <h1 class="fw-bold my-3" style="font-size: 1.8rem; text-align:justify" id="graficas_pastel">Gráficas de pastel por cada
            viático existente.</h1>

        <div class="w-100 div-secondary px-5 py-5 d-block">
            <h2 class="mb-3 fw-bold" style="font-size: 1.5rem; text-align:justify">Llena los filtros y generá las gráficas:
            </h2>
            <form id="generar_graficas_viaticos_pastel" action="{{ route('empleados.graficas_x_viatico') }}" method="get"
                enctype="application/x-www-form-urlencoded" autocomplete="off" class="needs-validation p-1" novalidate>
                @csrf

                <div class="row g-3">
                    <div class="col-sm-6" style="max-width: 100%;" id="campo_mes">
                        <label for="mes" class="form-label fw-bold" style="font-size: 1.2rem;">Mes</label>
                        <select name="mes" id="mes" class="form-control form-select"
                            aria-label="Default select example" style="height: 3.5rem;">
                            <option value="" @if (old('mes') == '') selected @endif>
                                NINGUNO
                            </option>
                            <option value="1" @if (old('mes') == '1') selected @endif>
                                ENERO
                            </option>
                            <option value="2" @if (old('mes') == '2') selected @endif>
                                FEBRERO
                            </option>
                            <option value="3" @if (old('mes') == '3') selected @endif>
                                MARZO
                            </option>
                            <option value="4" @if (old('mes') == '4') selected @endif>
                                ABRIL
                            </option>
                            <option value="5" @if (old('mes') == '5') selected @endif>
                                MAYO
                            </option>
                            <option value="6" @if (old('mes') == '6') selected @endif>
                                JUNIO
                            </option>
                            <option value="7" @if (old('mes') == '7') selected @endif>
                                JULIO
                            </option>
                            <option value="8" @if (old('mes') == '8') selected @endif>
                                AGOSTO
                            </option>
                            <option value="9" @if (old('mes') == '9') selected @endif>
                                SEPTIEMBRE
                            </option>
                            <option value="10" @if (old('mes') == '10') selected @endif>
                                OCTUBRE
                            </option>
                            <option value="11" @if (old('mes') == '11') selected @endif>
                                NOVIEMBRE
                            </option>
                            <option value="12" @if (old('mes') == '12') selected @endif>
                                DICIEMBRE
                            </option>
                        </select>
                        <div class="invalid-feedback">
                            Ingresa un mes válido.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="opt1" class="form-label d-block fw-bold" style="font-size: 1.2rem;">Opciones
                            personalizadas</label>
                        <div class="ps-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="personnel_inactive" id="opt1"
                                    value="true">
                                <label class="form-check-label fw-bold" for="opt1">Incluír empleados o personal inactivo
                                    actualmente.</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="proyects_inactive" id="opt2"
                                    value="true">
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
                        onclick="ask_before_submit_new('generar_graficas_viaticos_pastel')"
                        style="background-color: var(--botones-color);">Generar</button>

                    @if ($errors->any())
                        <div class="alert alert-danger mt-3 text-justify" role="alert">
                            <h6>Por favor corrige los errores debajo:</h6>
                            <ul style="text-align: justify;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
            </form>
        </div>
    </div>

    <br>

    @php

        $data_alimentos_Array_yValues = $data_alimentos
            ->pluck('total_alimento')
            ->map(fn($value) => (float) $value)
            ->toArray();
        $data_tras_local_Array_yValues = $data_tras_local
            ->pluck('total_traslados_local')
            ->map(fn($value) => (float) $value)
            ->toArray();
        $data_tras_externo_Array_yValues = $data_tras_externo
            ->pluck('total_traslados_externo')
            ->map(fn($value) => (float) $value)
            ->toArray();
        $data_com_bancaria_Array_yValues = $data_com_bancaria
            ->pluck('total_comision_bancaria')
            ->map(fn($value) => (float) $value)
            ->toArray();

        $data_gasolina_Array_yValues = $data_gasolina
            ->pluck('total_gasolina')
            ->map(fn($value) => (float) $value)
            ->toArray();
        $data_caseta_Array_yValues = $data_caseta
            ->pluck('total_caseta')
            ->map(fn($value) => (float) $value)
            ->toArray();
        $data_hospedaje_Array_yValues = $data_hospedaje
            ->pluck('total_hospedaje')
            ->map(fn($value) => (float) $value)
            ->toArray();

        $data_alimentos_Array_xValues = $data_alimentos->pluck('nombre')->toArray();
        $data_tras_local_Array_xValues = $data_tras_local->pluck('nombre')->toArray();
        $data_tras_externo_Array_xValues = $data_tras_externo->pluck('nombre')->toArray();
        $data_com_bancaria_Array_xValues = $data_com_bancaria->pluck('nombre')->toArray();
        $data_gasolina_Array_xValues = $data_gasolina->pluck('nombre')->toArray();
        $data_caseta_Array_xValues = $data_caseta->pluck('nombre')->toArray();
        $data_hospedaje_Array_xValues = $data_hospedaje->pluck('nombre')->toArray();

    @endphp

    <div class="d-flex gap-2 justify-content-between align-items-stretch px-2 flex-wrap">
        <div class="p-3 d-inline-block rounded-3 do_responsive_div2" style="box-shadow: 0px 7px 11px 0px rgba(0,0,0,0.75);">
            <canvas id="myChartAlimento" data-yValues='@json($data_alimentos_Array_yValues)'
                data-xValues='@json($data_alimentos_Array_xValues)' data-title="Viático Alimentos:">
            </canvas>
        </div>

        <div class="p-3 d-inline-block rounded-3 do_responsive_div2" style="box-shadow: 0px 7px 11px 0px rgba(0,0,0,0.75);">
            <canvas id="myChartTrasLocal" data-yValues='@json($data_tras_local_Array_yValues)'
                data-xValues='@json($data_tras_local_Array_xValues)' data-title="Viático Traslados Locales:">
            </canvas>
        </div>

        <div class="p-3 d-inline-block rounded-3 do_responsive_div2" style="box-shadow: 0px 7px 11px 0px rgba(0,0,0,0.75);">
            <canvas id="myChartTrasExterno" data-yValues='@json($data_tras_externo_Array_yValues)'
                data-xValues='@json($data_tras_externo_Array_xValues)' data-title="Viático Traslados Externos:">
            </canvas>
        </div>

        <div class="p-3 d-inline-block rounded-3 do_responsive_div2" style="box-shadow: 0px 7px 11px 0px rgba(0,0,0,0.75);">
            <canvas id="myChartComBancaria" data-yValues='@json($data_com_bancaria_Array_yValues)'
                data-xValues='@json($data_com_bancaria_Array_xValues)' data-title="Viático Comisión Bancaria:">
            </canvas>
        </div>

        <div class="p-3 d-inline-block rounded-3 do_responsive_div2" style="box-shadow: 0px 7px 11px 0px rgba(0,0,0,0.75);">
            <canvas id="myChartGasolina" data-yValues='@json($data_gasolina_Array_yValues)'
                data-xValues='@json($data_gasolina_Array_xValues)' data-title="Viático Gasolina:">
            </canvas>
        </div>

        <div class="p-3 d-inline-block rounded-3 do_responsive_div2"
            style="box-shadow: 0px 7px 11px 0px rgba(0,0,0,0.75);">
            <canvas id="myChartCaseta" data-yValues='@json($data_caseta_Array_yValues)'
                data-xValues='@json($data_caseta_Array_xValues)' data-title="Viático Caseta:">
            </canvas>
        </div>

        <div class="p-3 d-inline-block rounded-3 do_responsive_div2"
            style="box-shadow: 0px 7px 11px 0px rgba(0,0,0,0.75);">
            <canvas id="myChartHospedaje" data-yValues='@json($data_hospedaje_Array_yValues)'
                data-xValues='@json($data_hospedaje_Array_xValues)' data-title="Viático Hospedaje:">
            </canvas>
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
