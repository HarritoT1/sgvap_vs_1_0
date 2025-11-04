@extends('layout')

@section('content')
    <div class="w-100 my-3 div-main">
        <h1 class="fw-bold my-3" style="font-size: 1.8rem; text-align:justify" id="form_corte_dia">Captura los datos previos
            para generar el
            formulario de corte:
        </h1>
        <form id="crear_corte_dia" action="" method="post" enctype="application/x-www-form-urlencoded" autocomplete="off"
            class="needs-validation p-1" novalidate>
            @csrf

            <div class="row g-3">
                <div class="col-sm-6">
                    <label for="input_find_rfc" class="form-label fw-bold">RFC</label>
                    <input type="text" class="form-control" id="input_find_rfc" name="employee_id" placeholder=""
                        value="" required maxlength="50" list="sugerencias_rfc">
                    <div class="invalid-feedback">
                        Ingresa un RFC válido.
                    </div>
                    <datalist id="sugerencias_rfc">
                    </datalist>
                </div>

                <div class="col-sm-6">
                    <label for="fecha_dispersion_dia" class="form-label fw-bold">Fecha de corte</label>
                    <input type="date" class="form-control sm-form-control" id="fecha_dispersion_dia"
                        name="fecha_dispersion_dia" value="" required>
                    <div class="invalid-feedback">
                        Ingresa una fecha válida.
                    </div>
                </div>

                <hr class="my-4 mb-2">

                <button class="d-block mx-auto btn btn-primary btn-lg fw-bold button-custom" type="button"
                    onclick="validar_form_generator()" style="background-color: var(--botones-color);" id="btn_generar_formulario">Generar formulario de
                    corte</button>

                <div class="alert alert-danger mt-3 text-justify d-none" role="alert" id="errors_part_1">
                    <h6>Por favor corrige los errores debajo:</h6>
                    <ul>
                    </ul>
                </div>
        </form>

        <div class="loader d-none" id="loaderCircle"></div>

        <div class="w-100 div-secondary px-5 py-5 d-none" id="segunda-parte-formulario"> <!-- Cambiar a d-none -->
            <h2 class="mb-3 fw-bold" style="font-size: 1.5rem;" id="h2_2da_parte"></h2>
            <div class="row g-3">
                <div class="col-sm-6">
                    <label for="desayuno" class="form-label fw-bold">Desayuno</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)"
                            id="desayuno" name="desayuno" placeholder="0.000" step="any" value="{{ old('desayuno') }}"
                            form="crear_corte_dia">
                        <div class="invalid-feedback">
                            Ingresa un monto válido.
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <label for="comida" class="form-label fw-bold">Comida</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)"
                            id="comida" name="comida" placeholder="0.000" step="any" value="{{ old('comida') }}"
                            form="crear_corte_dia">
                        <div class="invalid-feedback">
                            Ingresa un monto válido.
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <label for="cena" class="form-label fw-bold">Cena</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)"
                            id="cena" name="cena" placeholder="0.000" step="any" value="{{ old('cena') }}"
                            form="crear_corte_dia">
                        <div class="invalid-feedback">
                            Ingresa un monto válido.
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <label for="traslado_local" class="form-label fw-bold">Traslado local</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)"
                            id="traslado_local" name="traslado_local" placeholder="0.000" step="any"
                            value="{{ old('traslado_local') }}" form="crear_corte_dia">
                        <div class="invalid-feedback">
                            Ingresa un monto válido.
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <label for="traslado_externo" class="form-label fw-bold">Traslado externo</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)"
                            id="traslado_externo" name="traslado_externo" placeholder="0.000" step="any"
                            value="{{ old('traslado_externo') }}" form="crear_corte_dia">
                        <div class="invalid-feedback">
                            Ingresa un monto válido.
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <label for="comision_bancaria" class="form-label fw-bold">Comisión bancaria</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)"
                            id="comision_bancaria" name="comision_bancaria" placeholder="0.000" step="any"
                            value="{{ old('comision_bancaria') }}" form="crear_corte_dia">
                        <div class="invalid-feedback">
                            Ingresa un monto válido.
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <label for="input_find_id_proyect" class="form-label fw-bold">Id del proyecto</label>
                    <input type="text" class="form-control" id="input_find_id_proyect" name="project_id"
                        placeholder="" value="" required maxlength="80" list="sugerencias_id_proyect"
                        form="crear_corte_dia">
                    <div class="invalid-feedback">
                        Ingresa un id de proyecto válido.
                    </div>
                    <datalist id="sugerencias_id_proyect">
                    </datalist>
                </div>

                <div class="col-12 d-flex flex-row justify-content-evenly alig-items-center">
                    <div style="width: 30%">
                        <hr class="w-100" style="border-style: solid; border-width: 3px;">
                    </div>
                    <div style="width: 33%; display: flex; align-items: center; justify-content: center;">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="ajuste_retiro">
                            <label class="form-check-label fw-bold text-center" for="ajuste_retiro"
                                style="font-size: 0.8rem;">
                                <em>$ Ajuste por retiro</em>
                            </label>
                        </div>
                    </div>
                    <div style="width: 30%">
                        <hr class="w-100" style="border-style: solid; border-width: 3px;">
                    </div>
                </div>

                <div class="col-sm-6 d-none" id="monto_extra_ecore_div">
                    <label for="monto_extra_ecore" class="form-label fw-bold">Monto del ajuste por retiro</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)"
                            id="monto_extra_ecore" name="monto_extra_ecore" placeholder="0.000" step="any"
                            min="0" value="" form="crear_corte_dia">
                        <div class="invalid-feedback">
                            Ingresa un monto válido.
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 d-none" id="campo_descontar_div">
                    <label for="campo_descontar" class="form-label fw-bold">Campo de ajuste por retiro</label>
                    <select name="campo_descontar" id="campo_descontar" class="form-control form-select"
                        aria-label="Default select example" form="crear_corte_dia">
                        <option value="desayuno" selected>
                            DESAYUNO
                        </option>
                        <option value="comida">
                            COMIDA
                        </option>
                        <option value="cena">
                            CENA
                        </option>
                        <option value="traslado_local">
                            TRASLADO LOCAL
                        </option>
                        <option value="traslado_externo">
                            TRASLADO EXTERNO
                        </option>
                        <option value="comision_bancaria">
                            COMISIÓN BANCARIA
                        </option>
                    </select>
                    <div class="invalid-feedback">
                        Ingresa un campo válido.
                    </div>
                </div>

                <div class="col-sm-6 mx-auto d-none" id="fecha_descontar_div">
                    <label for="fecha_descontar" class="form-label fw-bold">Fecha de ajuste por retiro</label>
                    <input type="date" class="form-control sm-form-control" id="fecha_descontar"
                        name="fecha_descontar" value="" form="crear_corte_dia">
                    <div class="invalid-feedback">
                        Ingresa una fecha válida.
                    </div>
                </div>

                <input type="hidden" id="id_extra_ecore_debt">

                <hr class="my-4 mb-2">

                <button class="d-block mx-auto btn btn-primary btn-lg fw-bold button-custom" type="button"
                    onclick="ask_before_submit_new()" form="crear_corte_dia"
                    style="background-color: var(--botones-color);">Registrar corte del
                    día</button>

                <hr class="my-2">
            </div>
        </div>

        <h2 class="fw-bold mt-4 mb-1" style="font-size: 1.8rem; text-align:justify">Límite de presupuesto de viáticos:
        </h2>

        <div class="container my-4 d-none" id="contenedor_barra_presupuesto_viaticos">
            <div class="label-row">
                <div><strong>Barra segmentada</strong> — límite: $<span id="limitDisplay"></span></div>
                <div id="percentTotal" style="text-align: right"></div>
            </div>

            <div class="bar-wrap" id="barWrap">
                <div id="bar" class="bar" aria-hidden="false" role="progressbar" aria-valuemin="0"
                    aria-valuemax="0" aria-valuenow="0"></div>
            </div>

            <div id="overflowMsg" class="overflow" style="display:none"></div>

            <div class="info info d-flex justify-content-evenly" id="legend"></div>
        </div>

        <hr class="my-4">

        <h2 class="fw-bold mt-4 mb-1" style="font-size: 1.8rem; text-align:justify">Límite de fecha de entrega:</h2>

        <div class="container my-4 d-none" id="contenedor_barra_fecha_limite">
            <div class="label-row">
                <div><strong>Barra de progreso</strong> — fecha límite: <span id="limitDisplay1"></span></div>
                <div id="percentTotal1" style="text-align: right"></div>
            </div>

            <div class="bar-wrap" id="barWrap1">
                <div id="bar1" class="bar" aria-hidden="false" role="progressbar" aria-valuemin="0"
                    aria-valuemax="0" aria-valuenow="0"></div>
            </div>

            <div id="overflowMsg1" class="overflow" style="display:none"></div>
        </div>

        <hr class="my-4">

        <p class="text-center fw-bold" style="font-size: 1.2rem; color: var(--empresa-color);">¡Nota!: En la barra de
            presupuesto de viáticos no se considera IVA y Sí Vale!</p>

    </div>
@endsection
