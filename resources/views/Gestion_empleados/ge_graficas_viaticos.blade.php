@extends('layout')

@section('content')
    <div class="w-100 my-3 div-main">
        <h1 class="fw-bold my-3" style="font-size: 1.8rem; text-align:justify" id="graficas_barras">Gráficas de barras
            contemplando proyectos |
            empleados.
        </h1>

        <div class="w-100 div-secondary px-5 py-5 d-block">
            <h2 class="mb-3 fw-bold" style="font-size: 1.5rem; text-align:justify">Llena los filtros y generá las gráficas:
            </h2>
            <form id="generar_graficas_viaticos_barras" action="{{ route('empleados.graficas_viaticos') }}" method="get"
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
                        onclick="ask_before_submit_new('generar_graficas_viaticos_barras')"
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

    <div class="d-flex gap-2 justify-content-between align-items-stretch px-1 flex-wrap">
        <div class="p-3 d-inline-block rounded-3 do_responsive_div"
            style="box-shadow: 0px 0px 8px 0px rgba(0,0,0,0.75) inset;">
            @if (isset($viaticos_por_proyecto))
                {{-- Aquí si EXISTEN datos --}}
                @if ($viaticos_por_proyecto->isNotEmpty())
                    @foreach ($viaticos_por_proyecto as $proyecto)
                        <canvas id="1myChart{{ $loop->index }}"
                            data-yValues='{{ json_encode([
                                (float) $proyecto->total_alimentos,
                                (float) $proyecto->total_traslado_local,
                                (float) $proyecto->total_traslado_externo,
                                (float) $proyecto->total_comision_bancaria,
                            ]) }}'
                            data-title="Proyecto: {{ $proyecto->nombre }}">
                        </canvas>
                        <br>
                        <hr class="my-4">
                        <br>
                    @endforeach
                @else
                    <div class="alert alert-warning" role="alert" style="text-align: center;">
                        No hay datos suficientes para generar alguna gráfica ¯\_(ツ)_/¯.
                        <br>
                        <br>
                        ¡Rellena los filtros!
                    </div>
                @endif
            @else
                {{-- Aquí la variable aún no está definida --}}
                <div class="alert alert-primary" role="alert" style="text-align: center;">
                    Llena los filtros para generar las gráficas (ツ).
                    <br>
                    <br>
                    ¡Gracias!
                </div>
            @endif
        </div>

        <div class="p-3 d-inline-block rounded-3 do_responsive_div"
            style="box-shadow: 0px 0px 8px 0px rgba(0,0,0,0.75) inset;">
            @if (isset($viaticos_por_empleado))
                {{-- Aquí si EXISTEN datos --}}
                @if ($viaticos_por_empleado->isNotEmpty())
                    @foreach ($viaticos_por_empleado as $employee)
                        <canvas id="2myChart{{ $loop->index }}"
                            data-yValues='{{ json_encode([
                                (float) $employee->total_alimentos,
                                (float) $employee->total_traslado_local,
                                (float) $employee->total_traslado_externo,
                                (float) $employee->total_comision_bancaria,
                            ]) }}'
                            data-title="Empleado: {{ $employee->nombre }}">
                        </canvas>
                        <br>
                        <hr class="my-4">
                        <br>
                    @endforeach
                @else
                    <div class="alert alert-warning" role="alert" style="text-align: center;">
                        No hay datos suficientes para generar alguna gráfica ¯\_(ツ)_/¯.
                        <br>
                        <br>
                        ¡Rellena los filtros!
                    </div>
                @endif
            @else
                {{-- Aquí la variable aún no está definida --}}
                <div class="alert alert-primary" role="alert" style="text-align: center;">
                    Llena los filtros para generar las gráficas (ツ).
                    <br>
                    <br>
                    ¡Gracias!
                </div>
            @endif
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
