@extends('layout')

@section('content')
    <div class="w-100 my-3 div-main">
        <h1 class="fw-bold my-3" style="font-size: 2rem; text-align:justify">Detalles de la dispersión de caseta:</h1>
        <div class="w-100 div-secondary">

            <h2 class="mb-3 fw-bold" style="font-size: 1.5rem;">Consulta y/o actualiza la información de la dispersión de
                caseta:</h2>
            <form id="actualizar" action="#" method="post" enctype="application/x-www-form-urlencoded" autocomplete="off"
                class="needs-validation p-1" novalidate>
                <div class="row g-3">

                    <div class="col-sm-6">
                        <label for="fecha_dispersion" class="form-label fw-bold">Fecha de la dispersión</label>
                        <input type="date" class="form-control sm-form-control" id="fecha_dispersion"
                            name="fecha_dispersion" value="" required>
                        <div class="invalid-feedback">
                            Ingresa una fecha válida.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="input_find_id_proyect" class="form-label fw-bold">id del proyecto</label>
                        <input type="text" class="form-control" id="input_find_id_proyect" name="project_id"
                            placeholder="" value="" required maxlength="80" list="sugerencias_id_proyect">
                        <div class="invalid-feedback">
                            Ingresa un id de proyecto válido.
                        </div>
                        <datalist id="sugerencias_id_proyect">
                        </datalist>
                    </div>

                    <div class="col-sm-6">
                        <label for="vehicle_id" class="form-label fw-bold">Placa del vehículo</label>
                        <select name="vehicle_id" id="vehicle_id" class="form-control form-select"
                            aria-label="Default select example" required>
                            <option value="ABJ3-S23D" selected>
                                ABJ3-S23D
                            </option>
                            <option value="ABJ3-S23E">
                                ABJ3-S23E
                            </option>
                        </select>
                        <div class="invalid-feedback">
                            Ingresa una placa de vehículo válida.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="nombre_caseta" class="form-label fw-bold">Nombre de la caseta</label>
                        <input type="text" class="form-control" id="nombre_caseta" name="nombre_caseta" placeholder=""
                            value="" required maxlength="100">
                        <div class="invalid-feedback">
                            Ingresa un id de proyecto válido.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="base_imponible" class="form-label fw-bold w-100">Base imponible <span
                                class="position-relative" id="msgBASE" style="cursor: pointer;">ⓘ
                                <div class="msgFloat">
                                    La base imponible se calcula como: Importe total / 1.16
                                </div>
                            </span></label>

                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)"
                                id="base_imponible" name="base_imponible" placeholder="0.000" step="0.000001" min="0"
                                value="" required readonly>
                            <div class="invalid-feedback">
                                Ingresa una base imponible válida.
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="iva_acumulado" class="form-label fw-bold w-100">IVA acumulado <span
                                class="position-relative" id="msgIVA" style="cursor: pointer;">ⓘ
                                <div class="msgFloat">
                                    El IVA acumulado se calcula como: Base imponible * 0.16
                                </div>
                            </span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)"
                                id="iva_acumulado" name="iva_acumulado" placeholder="0.000" step="0.000001" min="0"
                                value="" required readonly>
                            <div class="invalid-feedback">
                                Ingresa un IVA acumulado válido.
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mx-auto">
                        <label for="importe_total" class="form-label fw-bold">Importe total</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)"
                                id="importe_total" name="importe_total" placeholder="0.000" step="0.000001"
                                min="0" value="" required>
                            <div class="invalid-feedback">
                                Ingresa un importe total válido.
                            </div>
                        </div>
                    </div>

                    <hr class="my-4 mb-2">

                    <button class="d-block mx-auto btn btn-primary btn-lg fw-bold button-custom" type="button"
                        onclick="ask_before_submit_new()" style="background-color: var(--botones-color);">Registrar
                        dispersión</button>

                    <hr class="my-4 mb-2">
                </div>

                <div class="col-sm-6">
                    <label for="fecha_dispersion" class="form-label fw-bold">Fecha de la dispersión</label>
                    <input type="date" class="form-control sm-form-control" id="fecha_dispersion"
                        name="fecha_dispersion" value="" required disabled>
                    <div class="invalid-feedback">
                        Ingresa una fecha válida.
                    </div>
                </div>

                <div class="col-sm-6">
                    <label for="input_find_id_proyect" class="form-label fw-bold">id del proyecto</label>
                    <input type="text" class="form-control" id="input_find_id_proyect" name="project_id"
                        placeholder="" value="" required maxlength="80" list="sugerencias_id_proyect" disabled>
                    <div class="invalid-feedback">
                        Ingresa un id de proyecto válido.
                    </div>
                    <datalist id="sugerencias_id_proyect">
                    </datalist>
                </div>

                <div class="col-sm-6">
                    <label for="vehicle_id" class="form-label fw-bold">Placa del vehículo</label>
                    <select name="vehicle_id" id="vehicle_id" class="form-control form-select"
                        aria-label="Default select example" required disabled>
                        <option value="ABJ3-S23D" selected>
                            ABJ3-S23D
                        </option>
                        <option value="ABJ3-S23E">
                            ABJ3-S23E
                        </option>
                    </select>
                    <div class="invalid-feedback">
                        Ingresa una placa de vehículo válida.
                    </div>
                </div>

                <div class="col-sm-6">
                    <label for="costo_lt" class="form-label fw-bold">Costo del lt. de gasolina</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)"
                            id="costo_lt" name="costo_lt" placeholder="0.0000" step="0.0001" min="0"
                            value="" required disabled>
                        <div class="invalid-feedback">
                            Ingresa un costo de gasolina válido.
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <label for="cant_litros" class="form-label fw-bold">Cantidad de lts. de gasolina</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)"
                            id="cant_litros" name="cant_litros" placeholder="0.0000" step="0.0001" min="0"
                            value="" required disabled>
                        <div class="invalid-feedback">
                            Ingresa una cantidad de lts. de gasolina válida.
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <label for="monto_dispersado" class="form-label fw-bold">Monto dispersado</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)"
                            id="monto_dispersado" name="monto_dispersado" placeholder="0.000" step="0.000001"
                            min="0" value="" required disabled>
                        <div class="invalid-feedback">
                            Ingresa un monto dispersado válido.
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <label for="base_imponible" class="form-label fw-bold w-100">Base imponible <span
                            class="position-relative" id="msgBASE" style="cursor: pointer;">ⓘ
                            <div class="msgFloat">
                                La base imponible se calcula como: Monto dispersado / 1.16
                            </div>
                        </span></label>

                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)"
                            id="base_imponible" name="base_imponible" placeholder="0.000" step="0.000001"
                            min="0" value="" required readonly>
                        <div class="invalid-feedback">
                            Ingresa una base imponible válida.
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <label for="iva_acumulado" class="form-label fw-bold w-100">IVA acumulado <span
                            class="position-relative" id="msgIVA" style="cursor: pointer;">ⓘ
                            <div class="msgFloat">
                                El IVA acumulado se calcula como: Base imponible * 0.16
                            </div>
                        </span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)"
                            id="iva_acumulado" name="iva_acumulado" placeholder="0.000" step="0.000001" min="0"
                            value="" required readonly>
                        <div class="invalid-feedback">
                            Ingresa un IVA acumulado válido.
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 mx-auto">
                    <label for="importe_total" class="form-label fw-bold">Importe total</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)"
                            id="importe_total" name="importe_total" placeholder="0.000" step="0.000001" min="0"
                            value="" required readonly>
                        <div class="invalid-feedback">
                            Ingresa un importe total válido.
                        </div>
                    </div>
                </div>

                <hr class="my-4 mb-2">

                <div class="d-flex flex-row justify-content-end align-items-stretch gap-3" style="height: 60px">
                    <div style="height: 100%;" class="px-2 d-flex flex-row align-items-stretch gap-3">
                        <button style="height: 100%; width:4rem; padding: 0px; !important" type="button"
                            class="d-none button-custom btn rounded-3 m-0" id="cancel" onclick="cancel_edit_mode()">
                            <img src="{{ asset('img/cancel.png') }}" alt="cancelar" style="height: 100%; width: 4rem;">
                        </button>
                        <button style="height: 100%; width:4rem; padding: 0px; !important" type="button"
                            class="button-custom btn rounded-3 m-0" id="edit" onclick="enable_inpus_edit_mode()">
                            <img src="{{ asset('img/lapiz.png') }}" alt="editar" style="height: 100%; width: 4rem;">
                        </button>
                        <button style="height: 100%; width:4rem; padding: 0px; !important" type="button"
                            class="button-custom btn rounded-3 m-0" disabled id="save"
                            onclick="ask_before_submit()">
                            <img src="{{ asset('img/guardar.png') }}" alt="guardar" style="height: 100%; width: 4rem;">
                        </button>
                    </div>
                </div>

                <hr class="my-4 mb-2">
            </form>
        </div>
    </div>
@endsection
