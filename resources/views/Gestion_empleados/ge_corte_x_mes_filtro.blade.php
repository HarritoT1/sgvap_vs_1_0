@extends('layout')

@section('content')
    <div class="modal modal-sheet position-relative d-block p-4 py-md-5 bg-body-secondary" tabindex="-1" role="dialog"
        id="modalmain" style="min-height: 100vh; z-index: 0; box-sizing: border-box;">
        <div class="px-2" role="document"
            style="width: 30rem; max-width: 100%; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); box-sizing: border-box;">
            <div class="modal-content rounded-4"
                style="max-width: 100%; box-sizing: border-box; border-style:solid; border-width: 3px; border-color: rgba(0, 0, 0, 0.306); box-shadow: 0px 10px 18px 5px rgba(0,0,0,0.75); !important">
                <div class="modal-header p-5 pb-4 border-bottom-0" style="max-width: 100%; box-sizing: border-box;">
                    <h1 class="fw-bold mb-0" style="font-size: 1.5rem;">LLena el formulario:</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-5 pt-0" style="max-width: 100%;">
                    <form id="generar_form_corte_mensual" action="{{ route('empleados.generate_data_for_corte_mensual') }}" method="post"
                        enctype="application/x-www-form-urlencoded" autocomplete="off" class="needs-validation p-1"
                        novalidate>
                        @csrf

                        <div class="col-12 mb-3" style="max-width: 100%;" id="campo_mes">
                            <label for="mes" class="form-label fw-bold" style="font-size: 1.2rem;">Mes</label>
                            <select name="mes" id="mes" class="form-control form-select"
                                aria-label="Default select example" required style="height: 3.5rem;">
                                <option value="1" @if(old('mes') == "1") selected @endif>
                                    ENERO
                                </option>
                                <option value="2" @if(old('mes') == "2") selected @endif>
                                    FEBRERO
                                </option>
                                <option value="3" @if(old('mes') == "3") selected @endif> 
                                    MARZO
                                </option>
                                <option value="4" @if(old('mes') == "4") selected @endif>
                                    ABRIL
                                </option>
                                <option value="5" @if(old('mes') == "5") selected @endif>
                                    MAYO
                                </option>
                                <option value="6" @if(old('mes') == "6") selected @endif>
                                    JUNIO
                                </option>
                                <option value="7" @if(old('mes') == "7") selected @endif>
                                    JULIO
                                </option>
                                <option value="8" @if(old('mes') == "8") selected @endif>
                                    AGOSTO
                                </option>
                                <option value="9" @if(old('mes') == "9") selected @endif>
                                    SEPTIEMBRE
                                </option>
                                <option value="10" @if(old('mes') == "10") selected @endif>
                                    OCTUBRE
                                </option>
                                <option value="11" @if(old('mes') == "11") selected @endif>
                                    NOVIEMBRE
                                </option>
                                <option value="12" @if(old('mes') == "12") selected @endif>
                                    DICIEMBRE
                                </option>
                            </select>
                            <div class="invalid-feedback">
                                Ingresa un mes válido.
                            </div>
                        </div>
                        <div class="col-12 mb-3" style="max-width: 100%;">
                            <label for="anio" class="form-label fw-bold" style="font-size: 1.2rem;">Año</label>
                            <input type="number" class="form-control" id="anio" name="anio" placeholder="2025"
                                step="1" min="2000" max="2150" value="{{ old('anio')  }}" required style="height: 3.5rem;">
                            <div class="invalid-feedback">
                                Ingresa una año válido.
                            </div>
                        </div>
                        <div class="col-12 mb-3" style="max-width: 100%;">
                            <label for="input_find_rfc" class="form-label fw-bold" style="font-size: 1.2rem;">RFC</label>
                            <input type="text" class="form-control rounded-3" id="input_find_rfc" name="employee_id"
                                placeholder="" value="" required maxlength="50" list="sugerencias_rfc"
                                style="height: 3.5rem;">
                            <div class="invalid-feedback">
                                Ingresa un RFC válido.
                            </div>
                            <datalist id="sugerencias_rfc">
                            </datalist>
                        </div>
                        <button class="button-custom d-block mb-2 btn btn-lg rounded-3 btn-primary" type="submit"
                            style="background-color: var(--botones-color); font-size: 1.2rem;">Generar</button>
                        <small class="fw-bold d-block mx-auto my-2 text-center text-body-secondary"
                            style="font-size: 1.2rem">¡¡¡Ingrese el RFC sin espacios!!!</small>
                        <hr class="mt-4">

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
        </div>
    </div>
@endsection
