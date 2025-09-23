
@extends('layout')

@section('content')

<div class="w-100 my-3 div-main">
    <h1 class="fw-bold my-3" style="font-size: 2rem; text-align:justify">Crea un proyecto dando de alta toda la información
        del formulario:</h1>
    <div class="w-100 div-secondary">

        <h2 class="mb-3 fw-bold" style="font-size: 1.5rem;">Datos del proyecto:</h2>
        <form id="crear_proyecto" action="#" method="post" enctype="application/x-www-form-urlencoded"
            autocomplete="off" class="needs-validation p-1" novalidate>
            <div class="row g-3">
                <div class="col-sm-6">
                    <label for="id" class="form-label">id</label>
                    <input type="text" class="form-control" id="id" name="id" placeholder=""
                        value="" required maxlength="80">
                    <div class="invalid-feedback">
                        Ingresa un id válido.
                    </div>
                </div>

                <div class="col-sm-6">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder=""
                        value="" required maxlength="150">
                    <div class="invalid-feedback">
                        Ingresa un nombre válido.
                    </div>
                </div>

                <div class="col-sm-6">
                    <label for="sitio" class="form-label">Sitio</label>
                    <input type="text" class="form-control" id="sitio" name="sitio" placeholder=""
                        value="" required maxlength="50">
                    <div class="invalid-feedback">
                        Ingresa un sitio válido.
                    </div>
                </div>

                <div class="col-sm-6">
                    <label for="monto_cobrar" class="form-label">Monto a cobrar</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)"
                            id="monto_cobrar" name="monto_cobrar" placeholder="0.000" step="0.00000001" min="0"
                            value="" required>
                        <div class="invalid-feedback">
                            Ingresa un monto válido.
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <label for="estimado_viaticos" class="form-label">Estimado en viáticos</label>
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
                    <label for="estimado_tiempo" class="form-label">Estimado en tiempo</label>
                    <div class="input-group">
                        <span class="input-group-text">⌛</span>
                        <input type="text" class="form-control" id="estimado_tiempo" name="estimado_tiempo"
                            placeholder="" value="" required maxlength="150">
                        <div class="invalid-feedback">
                            Ingresa un estimado válido.
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <label for="fecha_limite" class="form-label">Fecha limite</label>
                    <input type="date" class="form-control sm-form-control" id="fecha_limite" name="fecha_limite"
                        value="" required>
                    <div class="invalid-feedback">
                        Ingresa una fecha válida.
                    </div>
                </div>

                <div class="col-sm-6">
                    <label for="notas" class="form-label">Notas</label>
                    <div class="input-group">
                        <span class="input-group-text">📝</span>
                        <textarea id="notas" name="notas" class="form-control" aria-label="Notas" maxlength="300"></textarea>
                    </div>
                </div>

                <hr class="my-4 mb-2">

                <button class="d-block mx-auto btn btn-primary btn-lg fw-bold button-custom" type="submit"
                    style="background-color: var(--botones-color);">Crear proyecto</button>
        </form>
    </div>
</div>

@endsection