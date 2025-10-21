@extends('layout')

@section('content')
    <div class="w-100 my-3 div-main">
        <h1 class="fw-bold my-3" style="font-size: 2rem; text-align:justify">Llena el formulario para dar de alta un cliente:
        </h1>
        <div class="w-100 div-secondary">

            <h2 class="mb-3 fw-bold" style="font-size: 1.5rem;">Datos del cliente:</h2>
            <form id="crear_cliente" action="#" method="post" enctype="application/x-www-form-urlencoded"
                autocomplete="off" class="needs-validation p-1" novalidate>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="id" class="form-label fw-bold">RFC</label>
                        <input type="text" class="form-control" id="id" name="id" placeholder=""
                            value="" required maxlength="50">
                        <div class="invalid-feedback">
                            Ingresa un RFC válido.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="razon_social" class="form-label fw-bold">Razón social</label>
                        <input type="text" class="form-control" id="razon_social" name="razon_social" placeholder=""
                            value="" required maxlength="200">
                        <div class="invalid-feedback">
                            Ingresa una razón social válida.
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="ubicacion" class="form-label fw-bold">Ubicación</label>
                        <input type="text" class="form-control" id="ubicacion" name="ubicacion" placeholder=""
                            value="" required maxlength="300">
                        <div class="invalid-feedback">
                            Ingresa una ubicación válida.
                        </div>
                    </div>

                    <hr class="my-4 mb-2">

                    <button class="d-block mx-auto btn btn-primary btn-lg fw-bold button-custom" type="button" onclick="ask_before_submit_new()"
                        style="background-color: var(--botones-color);">Registrar cliente</button>
            </form>
        </div>
    </div>
@endsection
