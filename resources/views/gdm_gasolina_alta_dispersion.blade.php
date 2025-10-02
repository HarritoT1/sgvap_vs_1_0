
@extends('layout')

@section('content')

<div class="w-100 my-3 div-main">
    <h1 class="fw-bold my-3" style="font-size: 2rem; text-align:justify">Registra una dispersión de gasolina llenando el formulario:</h1>
    <div class="w-100 div-secondary">

        <h2 class="mb-3 fw-bold" style="font-size: 1.5rem;">Datos de la dispersión:</h2>
        <form id="crear_dm_gasolina" action="#" method="post" enctype="application/x-www-form-urlencoded"
            autocomplete="off" class="needs-validation p-1" novalidate>
            <div class="row g-3">
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




                <div class="col-sm-6">
                    <label for="estimado_viaticos" class="form-label fw-bold">Estimado en viáticos</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)"
                            id="estimado_viaticos" name="estimado_viaticos" placeholder="0.000" step="0.00000001"
                            min="0" value="" required>
                        <div class="invalid-feedback">
                            Ingresa un estimado válido.
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <label for="fecha_limite" class="form-label fw-bold">Fecha limite</label>
                    <input type="date" class="form-control sm-form-control" id="fecha_limite" name="fecha_limite"
                        value="" required>
                    <div class="invalid-feedback">
                        Ingresa una fecha válida.
                    </div>
                </div>

                <hr class="my-4 mb-2">

                <button class="d-block mx-auto btn btn-primary btn-lg fw-bold button-custom" type="button" onclick="ask_before_submit_new()"
                    style="background-color: var(--botones-color);">Crear proyecto</button>
        </form>
    </div>
</div>

@endsection