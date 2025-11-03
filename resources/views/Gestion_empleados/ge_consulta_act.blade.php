@extends('layout')

@section('content')
    <div class="w-100 my-3 div-main">
        <h1 class="fw-bold my-3" style="font-size: 2rem; text-align:justify">Datos del empleado con el RFC:
            {{ $employee->id }}
        </h1>
        <div class="w-100 div-secondary">

            <h2 class="mb-3 fw-bold" style="font-size: 1.5rem;">Datos del empleado:</h2>
            <form id="actualizar" action="{{ route('empleados.update') }}" method="post"
                enctype="application/x-www-form-urlencoded" autocomplete="off" class="needs-validation p-1" novalidate>
                @csrf
                @method('PUT')

                <input type="hidden" name="id_employee" value="{{ $employee->id }}">

                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="id" class="form-label fw-bold">RFC</label>
                        <input type="text" class="form-control" id="id" name="id" placeholder=""
                            value="{{ $employee->id }}" required maxlength="50" disabled>
                        <div class="invalid-feedback">
                            Ingresa un RFC válido.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="puesto" class="form-label fw-bold">Puesto</label>
                        <input type="text" class="form-control" id="puesto" name="puesto" placeholder=""
                            value="{{ $employee->puesto }}" required maxlength="100" disabled>
                        <div class="invalid-feedback">
                            Ingresa un puesto válido.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="nombre" class="form-label fw-bold">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder=""
                            value="{{ $employee->nombre }}" required maxlength="100" disabled>
                        <div class="invalid-feedback">
                            Ingresa un sitio válido.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="status" class="form-label fw-bold">Estado del empleado</label>
                        <select name="status" id="status" class="form-control form-select"
                            aria-label="Default select example" required disabled>
                            <option value="activo" @if ($employee->status == 'activo') selected @endif>
                                ACTIVO
                            </option>
                            <option value="inactivo" @if ($employee->status == 'inactivo') selected @endif>
                                INACTIVO
                            </option>
                        </select>
                        <div class="invalid-feedback">
                            Ingresa un status válido.
                        </div>
                    </div>

                    <div class="col-sm-6 mx-auto" style="max-width: 500px;">
                        <label for="interno" class="form-label d-block fw-bold">Modo (interno / contratista)</label>
                        <div class="text-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="modo" id="interno" value="interno"
                                    required disabled @if ($employee->modo == 'interno') checked @endif>
                                <label class="form-check-label fw-bold" for="interno">Interno</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="modo" id="contratista"
                                    value="contratista" required disabled @if ($employee->modo == 'contratista') checked @endif>
                                <label class="form-check-label fw-bold" for="contratista">Contratista</label>
                            </div>
                            <!-- Aquí va el feedback para el grupo -->
                            <div class="invalid-feedback">
                                Selecciona un modo válido.
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
                                <img src="{{ asset('img/guardar.png') }}" alt="guardar"
                                    style="height: 100%; width: 4rem;">
                            </button>
                        </div>
                    </div>

                    <hr class="my-4 mb-2">

                    @if (session('success'))
                        <div class="alert alert-success mt-3 text-justify" role="alert">
                            <ul class="mb-0">
                                <li>{{ session('success') }}</li>
                            </ul>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger mt-3 text-justify" role="alert">
                            <h6>Por favor corrige los errores debajo:</h6>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
            </form>
        </div>
    </div>
@endsection
