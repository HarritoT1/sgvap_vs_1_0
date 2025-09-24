@extends('layout')

@section('content')
    <div class="w-100 my-3 div-main">
        <h1 class="fw-bold my-3" style="font-size: 1.8rem; text-align:justify">Captura los datos previos para generar el
            formulario de corte:
        </h1>
        <form id="crear_corte_dia" action="#" method="post" enctype="application/x-www-form-urlencoded" autocomplete="off"
            class="needs-validation p-1" novalidate>
            <div class="row g-3">
                <div class="col-sm-6">
                    <label for="input_find_rfc" class="form-label fw-bold">RFC</label>
                    <input type="text" class="form-control" id="input_find_rfc" name="id" placeholder=""
                        value="" required maxlength="50" list="sugerencias_rfc">
                    <div class="invalid-feedback">
                        Ingresa un RFC válido.
                    </div>
                    <datalist id="sugerencias_rfc">
                    </datalist>
                </div>

                <div class="col-sm-6">
                    <label for="fecha_dispersion_dia" class="form-label fw-bold">Fecha de corte</label>
                    <input type="date" class="form-control sm-form-control" id="fecha_dispersion_dia" name="fecha_dispersion_dia"
                        value="" required>
                    <div class="invalid-feedback">
                        Ingresa una fecha válida.
                    </div>
                </div>

                <hr class="my-4 mb-2">

                <button class="d-block mx-auto btn btn-primary btn-lg fw-bold button-custom" type="submit"
                    style="background-color: var(--botones-color);">Generar formulario de corte</button>
        </form>

        <div class="w-100 div-secondary px-5">
            <h2 class="mb-3 fw-bold" style="font-size: 1.5rem;">Llena los datos del formulario para el corte de $nombre del
                día $fecha:</h2>
            <div class="row g-3">
                <div class="col-sm-6">
                    <label for="desayuno" class="form-label fw-bold">Desayuno</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)"
                            id="desayuno" name="desayuno" placeholder="0.000" step="0.00000001" value="" form="crear_corte_dia">
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
                            id="comida" name="comida" placeholder="0.000" step="0.00000001" value="" form="crear_corte_dia">
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
                            id="cena" name="cena" placeholder="0.000" step="0.00000001" value="" form="crear_corte_dia">
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
                            id="traslado_local" name="traslado_local" placeholder="0.000" step="0.00000001" value="" form="crear_corte_dia">
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
                            id="traslado_externo" name="traslado_externo" placeholder="0.000" step="0.00000001" value="" form="crear_corte_dia">
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
                            id="comision_bancaria" name="comision_bancaria" placeholder="0.000" step="0.00000001" value="" form="crear_corte_dia">
                        <div class="invalid-feedback">
                            Ingresa un monto válido.
                        </div>
                    </div>
                </div>

                <div class="col">
                    <label for="input_find_id_proyect" class="form-label fw-bold">id del proyecto</label>
                    <input type="text" class="form-control" id="input_find_id_proyect" name="id_p" placeholder=""
                        value="" required maxlength="80" list="sugerencias_id_proyect">
                    <div class="invalid-feedback">
                        Ingresa un id de proyecto válido.
                    </div>
                    <datalist id="sugerencias_id_proyect">
                    </datalist>
                </div>
            </div>
        </div>
    </div>
@endsection
