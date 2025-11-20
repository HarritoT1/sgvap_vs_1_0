@extends('layout')

@section('content')
    <div class="w-100 my-3 div-main">
        <h1 class="fw-bold my-3" style="font-size: 2rem; text-align:justify">Da de alta un vehículo en el sistema para su
            prestamo, llena el formulario:</h1>
        <div class="w-100 div-secondary">

            <h2 class="mb-3 fw-bold" style="font-size: 1.5rem;">Datos del vehículo:</h2>
            <form id="crear_vehículo" action="{{ route('vehicles.create') }}" method="post" enctype="multipart/form-data" autocomplete="off"
                class="needs-validation p-1" novalidate>
                @csrf

                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="id" class="form-label fw-bold">Placa</label>
                        <input type="text" class="form-control" id="id" name="id" placeholder="ASP-MV9"
                            value="{{ old('id') }}" required maxlength="20">
                        <div class="invalid-feedback">
                            Ingresa una placa vehícular válida.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="nombre_modelo" class="form-label fw-bold">Nombre del modelo</label>
                        <input type="text" class="form-control" id="nombre_modelo" name="nombre_modelo" placeholder=""
                            value="{{ old('nombre_modelo') }}" required maxlength="50">
                        <div class="invalid-feedback">
                            Ingresa un nombre de modelo válido.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="marca" class="form-label fw-bold">Marca</label>
                        <input type="text" class="form-control" id="marca" name="marca" placeholder=""
                            value="{{ old('marca') }}" required maxlength="50">
                        <div class="invalid-feedback">
                            Ingresa una marca válida.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="anio" class="form-label fw-bold">Año</label>
                        <input type="number" class="form-control" id="anio" name="anio" placeholder=""
                            step="1" min="1900" value="{{ old('anio') }}" required>
                        <div class="invalid-feedback">
                            Ingresa una año válido.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="color" class="form-label fw-bold">Color</label>
                        <input type="text" class="form-control" id="color" name="color" placeholder=""
                            value="{{ old('color') }}" required maxlength="50">
                        <div class="invalid-feedback">
                            Ingresa un color válido.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="ruta_foto_1" class="form-label fw-bold">Fotografía del vehículo</label>
                        <input type="file" class="form-control" id="ruta_foto_1" name="ruta_foto_1"
                            accept="image/png, image/jpeg, image/webp, image/gif">
                        <div class="invalid-feedback">
                            Ingresa un archivo válido.
                        </div>
                    </div>

                    <div class="col-sm-6 mx-auto">
                        <label for="km_actual" class="form-label fw-bold">Km actual</label>
                        <div class="input-group">
                            <span class="input-group-text">⏲</span>
                            <input type="number" class="form-control" id="km_actual" name="km_actual" placeholder=""
                                step="1" min="0" value="{{ old('km_actual') }}" required>
                            <div class="invalid-feedback">
                                Ingresa un km entero válido.
                            </div>
                        </div>
                    </div>

                    <hr class="my-4 mb-2">

                    <h2 class="mb-3 fw-bold" style="font-size: 1.5rem; text-align:justify;">Selecciona los ítems del estado actual del vehículo:
                    </h2>

                    <div class="row align-items-center justify-content-evenly g-3 mt-0">
                        <div class="col-sm-5 text-center">
                            <div class="d-inline-block text-start">
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input checklist" type="checkbox" id="char1" required
                                        name="caracteristicas[]" value="Retrovisor izquierdo" @checked(in_array("Retrovisor izquierdo", old('caracteristicas', [])))>
                                    <label class="form-check-label fw-bold" for="char1">Retrovisor Izquierdo.</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input checklist" type="checkbox" id="char2" 
                                        name="caracteristicas[]" value="Retrovisor derecho" @checked(in_array("Retrovisor derecho", old('caracteristicas', [])))>
                                    <label class="form-check-label fw-bold" for="char2">Retrovisor Derecho.</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input checklist" type="checkbox" id="char3" 
                                        name="caracteristicas[]" value="Tapon gasolina" @checked(in_array("Tapon gasolina", old('caracteristicas', [])))>
                                    <label class="form-check-label fw-bold" for="char3">Tapón Gasolina.</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input checklist" type="checkbox" id="char4" 
                                        name="caracteristicas[]" value="Tapones llantas" @checked(in_array("Tapones llantas", old('caracteristicas', [])))>
                                    <label class="form-check-label fw-bold" for="char4">Tapones Llantas.</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input checklist" type="checkbox" id="char5" 
                                        name="caracteristicas[]" value="Cristales puertas" @checked(in_array("Cristales puertas", old('caracteristicas', [])))>
                                    <label class="form-check-label fw-bold" for="char5">Cristales Puertas.</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input checklist" type="checkbox" id="char6" 
                                        name="caracteristicas[]" value="Llanta refaccion" @checked(in_array("Llanta refaccion", old('caracteristicas', [])))>
                                    <label class="form-check-label fw-bold" for="char6">Llanta Refacción.</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input checklist" type="checkbox" id="char7" 
                                        name="caracteristicas[]" value="Limpiadores" @checked(in_array("Limpiadores", old('caracteristicas', [])))>
                                    <label class="form-check-label fw-bold" for="char7">Limpiadores.</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input checklist" type="checkbox" id="char8" 
                                        name="caracteristicas[]" value="Parabrisas frontal" @checked(in_array("Parabrisas frontal", old('caracteristicas', [])))>
                                    <label class="form-check-label fw-bold" for="char8">Parabrisas Frontal.</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input checklist" type="checkbox" id="char9" 
                                        name="caracteristicas[]" value="Parabrisas trasero" @checked(in_array("Parabrisas trasero", old('caracteristicas', [])))>
                                    <label class="form-check-label fw-bold" for="char9">Parabrisas Trasero.</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input checklist" type="checkbox" id="char10" 
                                        name="caracteristicas[]" value="Medallon" @checked(in_array("Medallon", old('caracteristicas', [])))>
                                    <label class="form-check-label fw-bold" for="char10">Medallón.</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input checklist" type="checkbox" id="char11" 
                                        name="caracteristicas[]" value="Molduras" @checked(in_array("Molduras", old('caracteristicas', [])))>
                                    <label class="form-check-label fw-bold" for="char11">Molduras.</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-5 text-center" id="caracteristicas_2">
                            <div class="d-inline-block text-start">
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input checklist" type="checkbox" id="char12" 
                                        name="caracteristicas[]" value="Calaveras" @checked(in_array("Calaveras", old('caracteristicas', [])))>
                                    <label class="form-check-label fw-bold" for="char12">Calaveras.</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input checklist" type="checkbox" id="char13" 
                                        name="caracteristicas[]" value="Parrilla" @checked(in_array("Parrilla", old('caracteristicas', [])))>
                                    <label class="form-check-label fw-bold" for="char13">Parrilla.</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input checklist" type="checkbox" id="char14" 
                                        name="caracteristicas[]" value="Placa delantera" @checked(in_array("Placa delantera", old('caracteristicas', [])))>
                                    <label class="form-check-label fw-bold" for="char14">Placa Delantera.</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input checklist" type="checkbox" id="char15" 
                                        name="caracteristicas[]" value="Placa trasera" @checked(in_array("Placa trasera", old('caracteristicas', [])))>
                                    <label class="form-check-label fw-bold" for="char15">Placa Trasera.</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input checklist" type="checkbox" id="char16" 
                                        name="caracteristicas[]" value="Faros" @checked(in_array("Faros", old('caracteristicas', [])))>
                                    <label class="form-check-label fw-bold" for="char16">Faros.</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input checklist" type="checkbox" id="char17" 
                                        name="caracteristicas[]" value="Retrovisor" @checked(in_array("Retrovisor", old('caracteristicas', [])))>
                                    <label class="form-check-label fw-bold" for="char17">Retrovisor.</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input checklist" type="checkbox" id="char18" 
                                        name="caracteristicas[]" value="Tapetes" @checked(in_array("Tapetes", old('caracteristicas', [])))>
                                    <label class="form-check-label fw-bold" for="char18">Tapetes.</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input checklist" type="checkbox" id="char19" 
                                        name="caracteristicas[]" value="Claxon" @checked(in_array("Claxon", old('caracteristicas', [])))>
                                    <label class="form-check-label fw-bold" for="char19">Claxon.</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input checklist" type="checkbox" id="char20" 
                                        name="caracteristicas[]" value="Estereo" @checked(in_array("Estereo", old('caracteristicas', [])))>
                                    <label class="form-check-label fw-bold" for="char20">Estéreo.</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input checklist" type="checkbox" id="char21" 
                                        name="caracteristicas[]" value="Poliza de seguro" @checked(in_array("Poliza de seguro", old('caracteristicas', [])))>
                                    <label class="form-check-label fw-bold" for="char21">Póliza de Seguro.</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input checklist" type="checkbox" id="char22" 
                                        name="caracteristicas[]" value="Tarjeta de circulacion" @checked(in_array("Tarjeta de circulacion", old('caracteristicas', [])))>
                                    <label class="form-check-label fw-bold" for="char22">Tarjeta de Circulación.</label>
                                </div>
                            </div>
                        </div>
                        <div class="invalid-feedback d-block mt-3 text-center fw-bold">
                            Marca por lo menos una característica vehícular.
                        </div>
                    </div>

                    <hr class="my-4 mb-2">

                    <div class="col-12 mb-3">
                        <label for="obs_gral" class="form-label fw-bold">Observación general descriptiva:</label>
                        <div class="input-group" style="height: 10rem !important;">
                            <span class="input-group-text">📝</span>
                            <textarea id="obs_gral" name="obs_gral" class="form-control" aria-label="Obs_gral" maxlength="500">{{ old('obs_gral') }}</textarea>
                        </div>
                    </div>

                    <hr class="my-4 mb-2">

                    <button class="d-block mx-auto btn btn-primary btn-lg fw-bold button-custom" type="button"
                        onclick="ask_before_submit_new('crear_vehículo')" style="background-color: var(--botones-color);">Registrar vehículo</button>

                    @if ($errors->any())
                        <div class="alert alert-danger mt-3 text-justify" role="alert">
                            <h6>Por favor corrige los errores debajo:</h6>
                            <ul style="text-align: justify;">
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
