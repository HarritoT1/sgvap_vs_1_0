@extends('layout')

@section('content')
    <div class="w-100 my-3 div-main">
        <h1 class="fw-bold my-3" style="font-size: 1.8rem; text-align:justify" id="graficas_barras_gasolina">Gráficas de
            dispersiones de caseta.
        </h1>

        <div class="w-100 div-secondary px-5 py-5 d-block">
            <h2 class="mb-3 fw-bold" style="font-size: 1.5rem; text-align:justify">Llena los filtros y generá las gráficas:
            </h2>
            <form id="generar_graficas_viatico_caseta" action="{{ route('dispersiones.graficas_caseta') }}" method="get"
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
                        <label for="input_find_id_proyect" class="form-label fw-bold" style="font-size: 1.2rem;">id del
                            proyecto</label>
                        <input type="text" class="form-control" id="input_find_id_proyect" name="project_id"
                            placeholder="" value="{{ old('project_id') }}" maxlength="80" list="sugerencias_id_proyect"
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
                            <option value="">
                                NINGUNO
                            </option>
                            @if (!empty($vehicles))
                                @foreach ($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}"
                                        {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                                        {{ $vehicle->id }} → {{ $vehicle->marca }} {{ $vehicle->nombre_modelo }}
                                        {{ $vehicle->color }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        <div class="invalid-feedback">
                            Ingresa una placa de vehículo válida.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label d-block fw-bold" style="font-size: 1.2rem;">Opciones
                            personalizadas</label>
                        <div class="ps-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="proyects_inactive" id="opt1"
                                    value="true" {{ $disabledCheck ? 'disabled' : '' }} style="text-align: justify;">
                                <label class="form-check-label fw-bold" for="opt1" style="text-align: justify">Incluír
                                    proyectos concluídos
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
                        onclick="ask_before_submit_new('generar_graficas_viatico_caseta')"
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
                </div>
            </form>
        </div>
    </div>

    <br>

    @php
        $data_projects_Array_yValues = $caseta_por_proyecto
            ->pluck('total_invertido_caseta')
            ->map(fn($value) => (float) $value)
            ->toArray();
        $data_vehicles_Array_yValues = $caseta_por_vehiculo
            ->pluck('total_invertido_caseta')
            ->map(fn($value) => (float) $value)
            ->toArray();

        $data_projects_Array_xValues = $caseta_por_proyecto->pluck('project_name')->toArray();
        $data_vehicles_Array_xValues = $caseta_por_vehiculo->pluck('vehicle_id')->toArray();
    @endphp

    <div class="d-flex gap-2 justify-content-between align-items-stretch px-1 flex-wrap">
        <div class="p-3 d-inline-block rounded-3 do_responsive_div3 mx-auto"
            style="box-shadow: 0px 0px 8px 0px rgba(0,0,0,0.75) inset;">
            @if ($caseta_por_proyecto->isNotEmpty())
                <canvas id="myChartProjects_Tag" class="d-block mx-auto" data-yValues='@json($data_projects_Array_yValues)'
                    data-xValues='@json($data_projects_Array_xValues)' data-title="{{ $data_title_canva_projects }}">
                </canvas>
            @else
                <p class="fs-5 fw-bold text-secondary text-center">{{ $data_title_canva_projects }}</p>
                <div class="alert alert-warning" role="alert" style="text-align: center;">
                    No hay datos suficientes para generar está gráfica ¯\_(ツ)_/¯.
                    <br>
                    <br>
                    ¡Rellena los filtros!
                </div>
            @endif
        </div>

        <div class="p-3 d-inline-block rounded-3 do_responsive_div3 mx-auto"
            style="box-shadow: 0px 0px 8px 0px rgba(0,0,0,0.75) inset;">
            @if ($caseta_por_vehiculo->isNotEmpty())
                <canvas id="myChartVehicles_Tag" class="d-block mx-auto" data-yValues='@json($data_vehicles_Array_yValues)'
                    data-xValues='@json($data_vehicles_Array_xValues)' data-title="{{ $data_title_canva_vehicles }}">
                </canvas>
            @else
                <p class="fs-5 fw-bold text-secondary text-center">{{ $data_title_canva_vehicles }}</p>
                <div class="alert alert-warning" role="alert" style="text-align: center;">
                    No hay datos suficientes para generar está gráfica ¯\_(ツ)_/¯.
                    <br>
                    <br>
                    ¡Rellena los filtros!
                </div>
            @endif
        </div>
    </div>

    <br><br>

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
