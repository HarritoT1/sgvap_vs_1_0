@extends('layout')

@section('content')
    <div class="w-100 my-3 div-main">
        <h1 class="fw-bold my-3" style="font-size: 2rem; text-align:justify">Llena el formulario para dar de alta un empleado:
        </h1>
        <div class="w-100 div-secondary">

            <h2 class="mb-3 fw-bold" style="font-size: 1.5rem;">Datos del empleado:</h2>
            <form id="actualizar" action="#" method="post" enctype="application/x-www-form-urlencoded"
                autocomplete="off" class="needs-validation p-1" novalidate>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="id" class="form-label">RFC</label>
                        <input type="text" class="form-control" id="id" name="id" placeholder=""
                            value="" required maxlength="50" disabled>
                        <div class="invalid-feedback">
                            Ingresa un RFC válido.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="puesto" class="form-label">Puesto</label>
                        <input type="text" class="form-control" id="puesto" name="puesto" placeholder=""
                            value="" required maxlength="100" disabled>
                        <div class="invalid-feedback">
                            Ingresa un puesto válido.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder=""
                            value="" required maxlength="100" disabled>
                        <div class="invalid-feedback">
                            Ingresa un sitio válido.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="status" class="form-label">Estado del empleado</label>
                        <select name="status" id="status" class="form-control form-select" aria-label="Default select example" required disabled>
                            <option value="activo" selected>
                                ACTIVO
                            </option>
                            <option value="inactivo">
                                INACTIVO
                            </option>
                        </select>
                        <div class="invalid-feedback">
                            Ingresa un status válido.
                        </div>
                    </div>

                    <div class="col-sm-6 mx-auto">
                        <label for="interno" class="form-label d-block">Modo (interno / contratista)</label>
                        <div class="text-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="modo" id="interno" value="interno"
                                    required checked disabled>
                                <label class="form-check-label" for="interno">Interno</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="modo" id="contratista"
                                    value="contratista" required disabled>
                                <label class="form-check-label" for="contratista">Contratista</label>
                            </div>
                            <!-- Aquí va el feedback para el grupo -->
                            <div class="invalid-feedback">
                                Selecciona un modo válido.
                            </div>
                        </div>
                    </div>

                    <hr class="my-4 mb-2">

                    <div class="d-flex flex-row justify-content-end align-items-stretch gap-3" style="height: 60px">
                        <div style="height: 100%;"
                            class="px-2 d-flex flex-row align-items-stretch gap-3">
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
