@extends('layout')

@section('content')
    <div class="w-100 my-3 div-main">
        <h1 class="fw-bold my-3" style="font-size: 1.8rem; text-align:justify">Llena el formulario para obtener el resultado
            de diferentes dispersiones de gasolina:
        </h1>

        <div class="w-100 div-secondary px-5 py-4 d-block">
            <h2 class="mb-3 fw-bold" style="font-size: 1.5rem; text-align:justify">Datos de la dispersión:
            </h2>
            <form id="consultar_disp_gasolina_filtro" action="#" method="get" enctype="application/x-www-form-urlencoded"
                autocomplete="off" class="needs-validation p-1" novalidate>
                <div class="row g-3">
                    <div class="col-sm-6" style="max-width: 100%;" id="campo_mes">
                        <label for="mes" class="form-label fw-bold" style="font-size: 1.2rem;">Mes de
                            dispersión</label>
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
                            aria-label="Default select example" style="height: 3.5rem;">
                            <option value="">
                                NINGUNO
                            </option>
                            @if (!empty($vehicles))
                                @foreach ($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}">
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

                    <hr class="my-4 mb-2">

                    <button class="d-block mx-auto btn btn-primary btn-lg fw-bold button-custom" type="button"
                        onclick="get_results_and_show_them_like_links('/gasolina_disp_consulta_filtro', 'gasolina')"
                        style="background-color: var(--botones-color);">Consultar</button>

                    <div class="alert alert-danger mt-3 text-justify d-none" role="alert" id="errors_part_1">
                        <h6>Por favor corrige los errores debajo:</h6>
                        <ul>
                        </ul>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <br>

    <div class="w-100 div-secondary px-1 py-5 d-block" id="div_resultados" style="position: relative; height: 30rem;">
        <h2 class="mb-3 fw-bold ms-4" style="font-size: 1.5rem; text-align:justify">Resultados de la consulta:
        </h2>

        <!--<div id="div_mensaje" class="alert alert-info d-none" role="alert">
                </div>-->

        <ul class="flex-column vineta d-none"
            style="text-align:justify; overflow-y: auto; overflow-x: hidden; height: 22rem; padding-right: 2rem;"
            id="lista_resultados"></ul>

        <div class="loader d-none my-5" id="loaderCircle"></div>
    </div>

    <br>
    <br>
@endsection
