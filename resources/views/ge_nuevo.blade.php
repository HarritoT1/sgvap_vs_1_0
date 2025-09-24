@extends('layout')

@section('content')
    <div class="w-100 my-3 div-main">
        <h1 class="fw-bold my-3" style="font-size: 2rem; text-align:justify">Llena el formulario para dar de alta un empleado:
        </h1>
        <div class="w-100 div-secondary">

            <h2 class="mb-3 fw-bold" style="font-size: 1.5rem;">Datos del empleado:</h2>
            <form id="crear_empleado" action="#" method="post" enctype="application/x-www-form-urlencoded"
                autocomplete="off" class="needs-validation p-1" novalidate>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="id" class="form-label">RFC</label>
                        <input type="text" class="form-control" id="id" name="id" placeholder=""
                            value="" required maxlength="50">
                        <div class="invalid-feedback">
                            Ingresa un RFC válido.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="puesto" class="form-label">Puesto</label>
                        <input type="text" class="form-control" id="puesto" name="puesto" placeholder=""
                            value="" required maxlength="100">
                        <div class="invalid-feedback">
                            Ingresa un puesto válido.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder=""
                            value="" required maxlength="100">
                        <div class="invalid-feedback">
                            Ingresa un sitio válido.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="interno" class="form-label d-block">Modo (interno / contratista)</label>
                        <div class="text-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="modo" id="interno" value="interno"
                                    required checked>
                                <label class="form-check-label" for="interno">Interno</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="modo" id="contratista"
                                    value="contratista" required>
                                <label class="form-check-label" for="contratista">Contratista</label>
                            </div>
                            <!-- Aquí va el feedback para el grupo -->
                            <div class="invalid-feedback">
                                Selecciona un modo válido.
                            </div>
                        </div>
                    </div>

                    <hr class="my-4 mb-2">

                    <button class="d-block mx-auto btn btn-primary btn-lg fw-bold button-custom" type="submit"
                        style="background-color: var(--botones-color);">Crear proyecto</button>
            </form>
        </div>
    </div>
@endsection
