@extends('layout')

@section('content')
    <div class="w-100 my-3 div-main">
        <h1 class="fw-bold my-3" style="font-size: 2rem; text-align:justify">Captura los datos para generar el corte mensual
            del empleado: $nombre</h1>
        <div class="w-100 div-secondary">

            <h2 class="mb-3 fw-bold" style="font-size: 1.5rem;">Datos del corte mensual:</h2>
            <form id="generar_corte_mensual" action="#" method="post" enctype="application/x-www-form-urlencoded"
                autocomplete="off" class="needs-validation p-1" novalidate>
                <div class="row g-3">
                    <div class="col-sm-6" style="max-width: 100%;" id="campo_mes">
                        <label for="mes_read" class="form-label fw-bold" style="font-size: 1.2rem;">Mes</label>
                        <select name="mes_read" id="mes_read" class="form-control form-select rounded-3"
                            aria-label="Default select example" required style="height: 3.5rem;" disabled>
                            <option value="1" selected>
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
                        <input type="hidden" name="mes" value="1" required>
                        <div class="invalid-feedback">
                            Ingresa un mes válido.
                        </div>
                    </div>

                    <div class="col-sm-6" style="max-width: 100%;">
                        <label for="anio" class="form-label fw-bold" style="font-size: 1.2rem;">Año</label>
                        <input type="number" class="form-control rounded-3" id="anio" name="anio" placeholder="2025"
                            step="1" min="2000" value="" required style="height: 3.5rem;" readonly>
                        <div class="invalid-feedback">
                            Ingresa una año válido.
                        </div>
                    </div>
                    
                    <div class="col-sm-6" style="max-width: 100%;">
                        <label for="input_find_rfc" class="form-label fw-bold" style="font-size: 1.2rem;">RFC</label>
                        <input type="text" class="form-control rounded-3" id="input_find_rfc" name="employee_id"
                            placeholder="" value="" required maxlength="50" list="sugerencias_rfc"
                            style="height: 3.5rem;" readonly>
                        <div class="invalid-feedback">
                            Ingresa un RFC válido.
                        </div>
                        <datalist id="sugerencias_rfc">
                        </datalist>
                    </div>

                    <div class="col-sm-6">
                        <label for="total_alimentos_mes" class="form-label fw-bold" style="font-size: 1.2rem;">Total de alimentos</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)"
                                id="total_alimentos_mes" name="total_alimentos_mes" placeholder="0.000" step="0.00000001"
                                value="" required style="height: 3.5rem;" readonly> 
                            <div class="invalid-feedback">
                                Ingresa un monto válido.
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="total_traslado_local_mes" class="form-label fw-bold" style="font-size: 1.2rem;">Total de traslados locales</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)"
                                id="total_traslado_local_mes" name="total_traslado_local_mes" placeholder="0.000" step="0.00000001"
                                value="" required style="height: 3.5rem;" readonly> 
                            <div class="invalid-feedback">
                                Ingresa un monto válido.
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="total_traslado_externo_mes" class="form-label fw-bold" style="font-size: 1.2rem;">Total de traslados externos</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)"
                                id="total_traslado_externo_mes" name="total_traslado_externo_mes" placeholder="0.000" step="0.00000001"
                                value="" required style="height: 3.5rem;" readonly> 
                            <div class="invalid-feedback">
                                Ingresa un monto válido.
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="total_comision_bancaria_mes" class="form-label fw-bold" style="font-size: 1.2rem;">Total de comisión bancaria</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)"
                                id="total_comision_bancaria_mes" name="total_comision_bancaria_mes" placeholder="0.000" step="0.00000001"
                                value="" required style="height: 3.5rem;" readonly> 
                            <div class="invalid-feedback">
                                Ingresa un monto válido.
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="total_comision_sivale_mes" class="form-label fw-bold" style="font-size: 1.2rem;">Total de comisión Sí Vale</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)"
                                id="total_comision_sivale_mes" name="total_comision_sivale_mes" placeholder="0.000" step="0.00000001"
                                value="" required style="height: 3.5rem;"> 
                            <div class="invalid-feedback">
                                Ingresa un monto válido.
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mx-auto">
                        <label for="total_iva_mes" class="form-label fw-bold" style="font-size: 1.2rem;">Total de IVA</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)"
                                id="total_iva_mes" name="total_iva_mes" placeholder="0.000" step="0.00000001"
                                value="" required style="height: 3.5rem;"> 
                            <div class="invalid-feedback">
                                Ingresa un monto válido.
                            </div>
                        </div>
                    </div>

                    <hr class="my-4 mb-2">

                    <button class="d-block mx-auto btn btn-primary btn-lg fw-bold button-custom" type="button" onclick="ask_before_submit_new()"
                        style="background-color: var(--botones-color);">Realizar corte</button>
            </form>
        </div>
    </div>
@endsection
