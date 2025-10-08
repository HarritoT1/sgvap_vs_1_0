@extends('layout')

@section('content')
    <div class="w-100 my-3 div-main">
        <h1 class="fw-bold my-3" style="font-size: 2rem; text-align:justify">Detalles de la dispersión de hospedaje:</h1>
        <div class="w-100 div-secondary">

            <h2 class="mb-3 fw-bold" style="font-size: 1.5rem;">Consulta y/o actualiza la información de la dispersión de
                hospedaje:</h2>
            <form id="actualizar" action="#" method="post" enctype="application/x-www-form-urlencoded" autocomplete="off"
                class="needs-validation p-1" novalidate>
                <div class="row g-3">

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
                        <label for="rfc_hospedaje" class="form-label fw-bold">RFC del hospedaje</label>
                        <input type="text" class="form-control" id="rfc_hospedaje" name="rfc_hospedaje" placeholder=""
                            value="" required maxlength="50" disabled>
                        <div class="invalid-feedback">
                            Ingresa un id de proyecto válido.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="razon_social" class="form-label fw-bold">Razón social</label>
                        <input type="text" class="form-control" id="razon_social" name="razon_social" placeholder=""
                            value="" required maxlength="250" disabled>
                        <div class="invalid-feedback">
                            Ingresa un id de proyecto válido.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="numero_noches" class="form-label fw-bold">Número de noches</label>
                        <div class="input-group">
                            <span class="input-group-text">🌙</span>
                            <input type="number" class="form-control" id="numero_noches" name="numero_noches"
                                min="1" placeholder="" step="1" value="" required disabled> 
                            <div class="invalid-feedback">
                                Ingresa un número de noches válido.
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="costo_x_noche" class="form-label fw-bold">Costo por noche</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)"
                                id="costo_x_noche" name="costo_x_noche" placeholder="0.000" step="0.0000001" min="0"
                                value="" required disabled>
                            <div class="invalid-feedback">
                                Ingresa un monto válido.
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="numero_personas" class="form-label fw-bold">Número de personas hospedadas</label>
                        <div class="input-group">
                            <span class="input-group-text">👤</span>
                            <input type="number" class="form-control" id="numero_personas" name="numero_personas"
                                min="1" placeholder="" step="1" value="" required disabled>
                            <div class="invalid-feedback">
                                Ingresa un número de personas hospedadas válido.
                            </div>
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
                                id="base_imponible" name="base_imponible" placeholder="0.000" step="0.000001"
                                min="0" value="" required readonly>
                            <div class="invalid-feedback">
                                Ingresa una base imponible válida.
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="iva_hospedaje" class="form-label fw-bold w-100">IVA de hospedaje <span
                                class="position-relative" id="msgIVA" style="cursor: pointer;">ⓘ
                                <div class="msgFloat">
                                    El IVA de hospedaje se calcula como: Base imponible * 0.16
                                </div>
                            </span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)"
                                id="iva_hospedaje" name="iva_hospedaje" placeholder="0.000" step="0.000001"
                                min="0" value="" required readonly>
                            <div class="invalid-feedback">
                                Ingresa un IVA de hospedaje válido.
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mx-auto">
                        <label for="importe_total" class="form-label fw-bold" id="label_hospedaje_importe_total">Importe total</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)"
                                id="importe_total" name="importe_total" placeholder="0.000" step="0.000001"
                                min="0" value="" required disabled>
                            <div class="invalid-feedback">
                                Ingresa un importe total válido.
                            </div>
                        </div>
                    </div>

                    <hr class="my-4 mb-2">

                    <div class="d-flex flex-row justify-content-end align-items-stretch gap-3" style="height: 60px">
                        <div style="height: 100%;" class="px-2 d-flex flex-row align-items-stretch gap-3">
                            <button style="height: 100%; width:4rem; padding: 0px; !important" type="button"
                                class="d-none button-custom btn rounded-3 m-0" id="cancel"
                                onclick="cancel_edit_mode()">
                                <img src="{{ asset('img/cancel.png') }}" alt="cancelar"
                                    style="height: 100%; width: 4rem;">
                            </button>
                            <button style="height: 100%; width:4rem; padding: 0px; !important" type="button"
                                class="button-custom btn rounded-3 m-0" id="edit"
                                onclick="enable_inpus_edit_mode()">
                                <img src="{{ asset('img/lapiz.png') }}" alt="editar"
                                    style="height: 100%; width: 4rem;">
                            </button>
                            <button style="height: 100%; width:4rem; padding: 0px; !important" type="button"
                                class="button-custom btn rounded-3 m-0" disabled id="save"
                                onclick="ask_before_submit()">
                                <img src="{{ asset('img/guardar.png') }}" alt="guardar"
                                    style="height: 100%; width: 4rem;">
                            </button>
                        </div>
                    </div>

                    <hr class="my-4 mb-2">
                </div>
            </form>
        </div>
    </div>
@endsection
