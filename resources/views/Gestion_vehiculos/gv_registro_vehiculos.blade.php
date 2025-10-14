@extends('layout')

@section('content')
    <div class="w-100 my-3 div-main">
        <h1 class="fw-bold my-3" style="font-size: 2rem; text-align:justify">Da de alta un vehículo en el sistema para su
            prestamo, llena el formulario:</h1>
        <div class="w-100 div-secondary">

            <h2 class="mb-3 fw-bold" style="font-size: 1.5rem;">Datos del vehículo:</h2>
            <form id="crear_vehículo" action="#" method="post" enctype="multipart/form-data" autocomplete="off"
                class="needs-validation p-1" novalidate>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="id" class="form-label fw-bold">Placa</label>
                        <input type="text" class="form-control" id="id" name="id" placeholder="ASP-MV9"
                            value="" required maxlength="20">
                        <div class="invalid-feedback">
                            Ingresa una placa vehícular válida.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="nombre_modelo" class="form-label fw-bold">Nombre del modelo</label>
                        <input type="text" class="form-control" id="nombre_modelo" name="nombre_modelo" placeholder=""
                            value="" required maxlength="50">
                        <div class="invalid-feedback">
                            Ingresa un nombre de modelo válido.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="marca" class="form-label fw-bold">Marca</label>
                        <input type="text" class="form-control" id="marca" name="marca" placeholder=""
                            value="" required maxlength="50">
                        <div class="invalid-feedback">
                            Ingresa una marca válida.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="anio" class="form-label fw-bold">Año</label>
                        <input type="number" class="form-control" id="anio" name="anio" placeholder=""
                            step="1" min="1900" value="" required>
                        <div class="invalid-feedback">
                            Ingresa una año válido.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="color" class="form-label fw-bold">Color</label>
                        <input type="text" class="form-control" id="color" name="color" placeholder=""
                            value="" required maxlength="50">
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
                                step="1" min="0" value="" required>
                            <div class="invalid-feedback">
                                Ingresa un km entero válido.
                            </div>
                        </div>
                    </div>

                    <hr class="my-4 mb-2">

                    <h2 class="mb-3 fw-bold" style="font-size: 1.5rem;">Selecciona los ítems del estado actual del vehículo:
                    </h2>

                    <div class="row align-items-center justify-content-evenly g-3 mt-0">
                        <div class="col-sm-5 text-center">
                            <div class="d-inline-block text-start">
                                <div class="form-check form-switch">
                                    <input class="form-check-input checklist" type="checkbox" id="char1" checked required
                                        name="caracteristicas[]" value="Retrovisor izquierdo">
                                    <label class="form-check-label fw-bold" for="char1">Retrovisor Izquierdo</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input checklist" type="checkbox" id="char2" checked
                                        name="caracteristicas[]" value="Retrovisor derecho">
                                    <label class="form-check-label fw-bold" for="char2">Retrovisor Derecho</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input checklist" type="checkbox" id="char3" checked
                                        name="caracteristicas[]" value="Tapon gasolina">
                                    <label class="form-check-label fw-bold" for="char3">Tapon Gasolina</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input checklist" type="checkbox" id="char4" checked
                                        name="caracteristicas[]" value="Tapones llantas">
                                    <label class="form-check-label fw-bold" for="char4">Tapones Llantas</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input checklist" type="checkbox" id="char5" checked
                                        name="caracteristicas[]" value="Cristales puertas">
                                    <label class="form-check-label fw-bold" for="char5">Cristales Puertas</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input checklist" type="checkbox" id="char6" checked
                                        name="caracteristicas[]" value="Llanta refaccion">
                                    <label class="form-check-label fw-bold" for="char6">Llanta Refaccion</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input checklist" type="checkbox" id="char7" checked
                                        name="caracteristicas[]" value="Limpiadores">
                                    <label class="form-check-label fw-bold" for="char7">Limpiadores</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input checklist" type="checkbox" id="char8" checked
                                        name="caracteristicas[]" value="Parabrisas frontal">
                                    <label class="form-check-label fw-bold" for="char8">Parabrisas Frontal</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input checklist" type="checkbox" id="char9" checked
                                        name="caracteristicas[]" value="Parabrisas trasero">
                                    <label class="form-check-label fw-bold" for="char9">Parabrisas Trasero</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input checklist" type="checkbox" id="char10" checked
                                        name="caracteristicas[]" value="Medallon">
                                    <label class="form-check-label fw-bold" for="char10">Medallón</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input checklist" type="checkbox" id="char11" checked
                                        name="caracteristicas[]" value="Molduras">
                                    <label class="form-check-label fw-bold" for="char11">Molduras</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5 text-center">
                            <div class="d-inline-block text-start">
                                <div class="form-check form-switch">
                                    <input class="form-check-input checklist" type="checkbox" id="char1" checked required
                                        name="caracteristicas[]" value="Retrovisor izquierdo">
                                    <label class="form-check-label fw-bold" for="char1">Retrovisor Izquierdo</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input checklist" type="checkbox" id="char2" checked
                                        name="caracteristicas[]" value="Retrovisor derecho">
                                    <label class="form-check-label fw-bold" for="char2">Retrovisor Derecho</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input checklist" type="checkbox" id="char3" checked
                                        name="caracteristicas[]" value="Tapon gasolina">
                                    <label class="form-check-label fw-bold" for="char3">Tapon Gasolina</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input checklist" type="checkbox" id="char4" checked
                                        name="caracteristicas[]" value="Tapones llantas">
                                    <label class="form-check-label fw-bold" for="char4">Tapones Llantas</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input checklist" type="checkbox" id="char5" checked
                                        name="caracteristicas[]" value="Cristales puertas">
                                    <label class="form-check-label fw-bold" for="char5">Cristales Puertas</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input checklist" type="checkbox" id="char6" checked
                                        name="caracteristicas[]" value="Llanta refaccion">
                                    <label class="form-check-label fw-bold" for="char6">Llanta Refaccion</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input checklist" type="checkbox" id="char7" checked
                                        name="caracteristicas[]" value="Limpiadores">
                                    <label class="form-check-label fw-bold" for="char7">Limpiadores</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input checklist" type="checkbox" id="char8" checked
                                        name="caracteristicas[]" value="Parabrisas frontal">
                                    <label class="form-check-label fw-bold" for="char8">Parabrisas Frontal</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input checklist" type="checkbox" id="char9" checked
                                        name="caracteristicas[]" value="Parabrisas trasero">
                                    <label class="form-check-label fw-bold" for="char9">Parabrisas Trasero</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input checklist" type="checkbox" id="char10" checked
                                        name="caracteristicas[]" value="Medallon">
                                    <label class="form-check-label fw-bold" for="char10">Medallón</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input checklist" type="checkbox" id="char11" checked
                                        name="caracteristicas[]" value="Molduras">
                                    <label class="form-check-label fw-bold" for="char11">Molduras</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button class="d-block mx-auto btn btn-primary btn-lg fw-bold button-custom" type="button"
                        onclick="ask_before_submit_new()" style="background-color: var(--botones-color);">Crear
                        proyecto</button>
            </form>
        </div>
    </div>
@endsection
