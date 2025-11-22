@extends('layout')

@section('content')
    <div class="modal modal-sheet position-relative d-block p-4 py-md-5 bg-body-secondary" tabindex="-1" role="dialog"
        id="modalmain" style="min-height: 100vh; z-index: 0; box-sizing: border-box;">
        <div class="px-2" role="document"
            style="width: 30rem; max-width: 100%; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); box-sizing: border-box;">
            <div class="modal-content rounded-4"
                style="max-width: 100%; box-sizing: border-box; border-style:solid; border-width: 3px; border-color: rgba(0, 0, 0, 0.306); box-shadow: 0px 10px 18px 5px rgba(0,0,0,0.75); !important">
                <div class="modal-header p-5 pb-4 border-bottom-0" style="max-width: 100%; box-sizing: border-box;">
                    <h1 class="fw-bold mb-0" style="font-size: 1.5rem;">Consulta por placa vehícular:</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-5 pt-0" style="max-width: 100%;">
                    <form id="consultar_vehiculo" action="{{ route('vehiculos.consulta_act') }}" method="get" enctype="application/x-www-form-urlencoded"
                        autocomplete="off" class="needs-validation p-1" novalidate>
                        @csrf
                        
                        <div class="col-12 mb-4" style="max-width: 100%;" id="vehicle_id">
                            <select name="id" id="id" class="form-control form-select"
                                aria-label="Default select example" required style="height: 3.5rem;">
                                <option value="ABJ3-S23D" selected>
                                    ABJ3-S23D
                                </option>
                                <option value="ABJ3-S23E">
                                    ABJ3-S23E
                                </option>
                            </select>
                            <div class="invalid-feedback">
                                Selecciona una placa porfavor.
                            </div>
                        </div>
                        <button class="button-custom d-block mb-2 btn btn-lg rounded-3 btn-primary" type="submit"
                            style="background-color: var(--botones-color); font-size: 1.2rem;">Generar</button>
                        <small class="fw-bold d-block mx-auto my-2 text-center text-body-secondary"
                            style="font-size: 1.2rem">¡¡¡Selecciona una placa vehícular!!!</small>
                        <hr class="mt-4">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
