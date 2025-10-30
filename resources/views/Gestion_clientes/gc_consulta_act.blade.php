@extends('layout')

@section('content')
    <div class="w-100 my-3 div-main">
        <h1 class="fw-bold my-3" style="font-size: 2rem; text-align:justify">Datos del cliente con el RFC: {{ $customer->id }}
        </h1>
        <div class="w-100 div-secondary">

            <h2 class="mb-3 fw-bold" style="font-size: 1.5rem;">Datos del cliente:</h2>
            <form id="actualizar" action="{{ route('clientes.update') }}" method="post" enctype="application/x-www-form-urlencoded" autocomplete="off"
                class="needs-validation p-1" novalidate>
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="id" class="form-label fw-bold">RFC</label>
                        <input type="text" class="form-control" id="id" name="id" placeholder=""
                            value="{{ old('id', $customer->id) }}" required maxlength="50" disabled>
                        <div class="invalid-feedback">
                            Ingresa un RFC válido.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="razon_social" class="form-label fw-bold">Razón social</label>
                        <input type="text" class="form-control" id="razon_social" name="razon_social" placeholder=""
                            value="{{ old('razon_social', $customer->razon_social) }}" required maxlength="200" disabled>
                        <div class="invalid-feedback">
                            Ingresa una razón social válida.
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="ubicacion" class="form-label fw-bold">Ubicación</label>
                        <input type="text" class="form-control" id="ubicacion" name="ubicacion" placeholder=""
                            value="{{ old('ubicacion', $customer->ubicacion) }}" required maxlength="300" disabled>
                        <div class="invalid-feedback">
                            Ingresa una ubicación válida.
                        </div>
                    </div>

                    <div class="col-sm-6 mx-auto">
                        <label for="status" class="form-label fw-bold">Estado del cliente</label>
                        <select name="status" id="status" class="form-control form-select"
                            aria-label="Default select example" required disabled>
                            <option value="activo" @if ($customer->status == 'activo') selected @endif>
                                ACTIVO
                            </option>
                            <option value="inactivo" @if ($customer->status == 'inactivo') selected @endif>
                                INACTIVO
                            </option>
                        </select>
                        <div class="invalid-feedback">
                            Ingresa un status válido.
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

                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            <ul class="mb-0">
                                <li>{{ session('success') }}</li>
                            </ul>
                        </div>
                    @endif
            </form>
        </div>
    </div>
@endsection
