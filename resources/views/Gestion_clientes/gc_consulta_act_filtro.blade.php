@extends('layout')

@section('content')
    <div class="modal modal-sheet position-relative d-block p-4 py-md-5 bg-body-secondary" tabindex="-1" role="dialog"
        id="modalmain" style="min-height: 100vh; z-index: 0; box-sizing: border-box;">
        <div class="px-2" role="document"
            style="width: 30rem; max-width: 100%; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); box-sizing: border-box;">
            <div class="modal-content rounded-4"
                style="max-width: 100%; box-sizing: border-box; border-style:solid; border-width: 3px; border-color: rgba(0, 0, 0, 0.306); box-shadow: 0px 10px 18px 5px rgba(0,0,0,0.75); !important">
                <div class="modal-header p-5 pb-4 border-bottom-0" style="max-width: 100%; box-sizing: border-box;">
                    <h1 class="fw-bold mb-0" style="font-size: 1.2rem;">Ingresa el RFC del cliente:</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-5 pt-0" style="max-width: 100%;">
                    <form id="buscar_cliente" action="{{route('clientes.consulta_act')}}" method="get" enctype="application/x-www-form-urlencoded"
                        autocomplete="off" class="needs-validation p-1" novalidate>
                        <div class="form-floating mb-3" style="max-width: 100%;">
                            <input type="text" class="form-control rounded-3" id="input_find_rfc_cliente" name="id"
                                placeholder="" value="" required maxlength="50" list="sugerencias_rfc_cliente">
                            <label for="input_find_rfc_cliente">RFC</label>
                            <div class="invalid-feedback">
                                Ingresa un RFC válido.
                            </div>
                            <datalist id="sugerencias_rfc_cliente">
                            </datalist>
                        </div>
                        <button class="button-custom d-block mb-2 btn btn-lg rounded-3 btn-primary" type="submit"
                            style="background-color: var(--botones-color); font-size: 1.2rem;">Consultar</button>
                        <small class="fw-bold d-block mx-auto my-2 text-center text-body-secondary"
                            style="font-size: 1.2rem">¡¡¡Ingrese el RFC sin espacios!!!</small>
                        <hr class="mt-4">

                        @if($errors->any())
                            <div class="alert alert-danger text-justify" role="alert">
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
        </div>
    </div>
@endsection
