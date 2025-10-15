@extends('layout')

@section('content')
    <div class="w-100 my-3 div-main">
        <h1 class="fw-bold my-3" style="font-size: 2rem; text-align:justify">Detalles del vehículo con el placa: $id</h1>
        <div class="w-100 div-secondary">

            <h2 class="mb-3 fw-bold" style="font-size: 1.5rem;">Datos del vehículo:</h2>
            <form id="actualizar_version_2" action="#" method="post" enctype="multipart/form-data" autocomplete="off"
                class="needs-validation p-1" novalidate>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="id" class="form-label fw-bold">Placa</label>
                        <input type="text" class="form-control" id="id" name="id" placeholder="ASP-MV9"
                            value="" required maxlength="20" disabled>
                        <div class="invalid-feedback">
                            Ingresa una placa vehícular válida.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="nombre_modelo" class="form-label fw-bold">Nombre del modelo</label>
                        <input type="text" class="form-control" id="nombre_modelo" name="nombre_modelo" placeholder=""
                            value="" required maxlength="50" disabled>
                        <div class="invalid-feedback">
                            Ingresa un nombre de modelo válido.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="marca" class="form-label fw-bold">Marca</label>
                        <input type="text" class="form-control" id="marca" name="marca" placeholder=""
                            value="" required maxlength="50" disabled>
                        <div class="invalid-feedback">
                            Ingresa una marca válida.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="anio" class="form-label fw-bold">Año</label>
                        <input type="number" class="form-control" id="anio" name="anio" placeholder=""
                            step="1" min="1900" value="" required disabled>
                        <div class="invalid-feedback">
                            Ingresa una año válido.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="color" class="form-label fw-bold">Color</label>
                        <input type="text" class="form-control" id="color" name="color" placeholder=""
                            value="" required maxlength="50" disabled>
                        <div class="invalid-feedback">
                            Ingresa un color válido.
                        </div>
                    </div>

                    <div class="col-sm-6 mx-auto">
                        <label for="km_actual" class="form-label fw-bold">Km actual</label>
                        <div class="input-group">
                            <span class="input-group-text">⏲</span>
                            <input type="number" class="form-control" id="km_actual" name="km_actual" placeholder=""
                                step="1" min="0" value="" required disabled>
                            <div class="invalid-feedback">
                                Ingresa un km entero válido.
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="status" class="form-label fw-bold">Estado del vehículo</label>
                        <select name="status" id="status" class="form-control form-select"
                            aria-label="Default select example" required disabled>
                            <option value="funcional" selected>
                                FUNCIONAL
                            </option>
                            <option value="mantenimiento">
                                MANTENIMIENTO
                            </option>
                        </select>
                        <div class="invalid-feedback">
                            Ingresa un status válido.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="is_on_loan" class="form-label fw-bold">En prestamo</label>
                        <input type="text" class="form-control" id="is_on_loan" name="is_on_loan" placeholder=""
                            value="SI" required maxlength="2" readonly>
                        <div class="invalid-feedback">
                            Entrada invalida.
                        </div>
                    </div>

                    <div class="mx-auto mt-4" style="width: 25rem;">
                        <label for="ruta_foto_1" class="form-label d-block w-100" style="cursor: pointer;"
                            title="Cambiar fotografía">
                            <img id="prev_foto" class="imageResponsive my-2 img_file" alt="img" src="{{ asset('img/sin_img.jpg') }}"
                                style="width: 15rem; border-radius: 15px; box-shadow: -1px 3px 10px 4px rgba(0,0,0,0.75); height: 12rem;">
                        </label>
                        <input type="file" class="form-control mt-4 mb-3" id="ruta_foto_1" name="ruta_foto_1"
                            accept="image/png, image/jpeg, image/webp, image/gif" disabled>
                        <div class="invalid-feedback">
                            Ingresa un archivo válido.
                        </div>
                    </div>

                    <hr class="my-4 mb-2">

                    <h2 class="mb-3 fw-bold" style="font-size: 1.5rem;">Selecciona los ítems del estado actual del
                        vehículo:</h2>

                    <div class="row align-items-center justify-content-evenly g-3 mt-0">
                        <div class="col-sm-5 text-center">
                            <div class="d-inline-block text-start">
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input checklist" type="checkbox" id="char1" checked
                                        required name="caracteristicas[]" value="Retrovisor izquierdo" disabled>
                                    <label class="form-check-label fw-bold" for="char1">Retrovisor Izquierdo.</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input checklist" type="checkbox" id="char2" checked
                                        name="caracteristicas[]" value="Retrovisor derecho" disabled>
                                    <label class="form-check-label fw-bold" for="char2">Retrovisor Derecho.</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input checklist" type="checkbox" id="char3" checked
                                        name="caracteristicas[]" value="Tapon gasolina" disabled>
                                    <label class="form-check-label fw-bold" for="char3">Tapón Gasolina.</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input checklist" type="checkbox" id="char4" checked
                                        name="caracteristicas[]" value="Tapones llantas" disabled>
                                    <label class="form-check-label fw-bold" for="char4">Tapones Llantas.</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input checklist" type="checkbox" id="char5" checked
                                        name="caracteristicas[]" value="Cristales puertas" disabled>
                                    <label class="form-check-label fw-bold" for="char5">Cristales Puertas.</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input checklist" type="checkbox" id="char6" checked
                                        name="caracteristicas[]" value="Llanta refaccion" disabled>
                                    <label class="form-check-label fw-bold" for="char6">Llanta Refacción.</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input checklist" type="checkbox" id="char7" checked
                                        name="caracteristicas[]" value="Limpiadores" disabled>
                                    <label class="form-check-label fw-bold" for="char7">Limpiadores.</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input checklist" type="checkbox" id="char8" checked
                                        name="caracteristicas[]" value="Parabrisas frontal" disabled>
                                    <label class="form-check-label fw-bold" for="char8">Parabrisas Frontal.</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input checklist" type="checkbox" id="char9" checked
                                        name="caracteristicas[]" value="Parabrisas trasero" disabled>
                                    <label class="form-check-label fw-bold" for="char9">Parabrisas Trasero.</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input checklist" type="checkbox" id="char10" checked
                                        name="caracteristicas[]" value="Medallon" disabled>
                                    <label class="form-check-label fw-bold" for="char10">Medallón.</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input checklist" type="checkbox" id="char11" checked
                                        name="caracteristicas[]" value="Molduras" disabled>
                                    <label class="form-check-label fw-bold" for="char11">Molduras.</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-5 text-center" id="caracteristicas_2">
                            <div class="d-inline-block text-start">
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input checklist" type="checkbox" id="char12" checked
                                        name="caracteristicas[]" value="Calaveras" disabled>
                                    <label class="form-check-label fw-bold" for="char12">Calaveras.</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input checklist" type="checkbox" id="char13" checked
                                        name="caracteristicas[]" value="Parrilla" disabled>
                                    <label class="form-check-label fw-bold" for="char13">Parrilla.</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input checklist" type="checkbox" id="char14" checked
                                        name="caracteristicas[]" value="Placa delantera" disabled>
                                    <label class="form-check-label fw-bold" for="char14">Placa Delantera.</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input checklist" type="checkbox" id="char15" checked
                                        name="caracteristicas[]" value="Placa trasera" disabled>
                                    <label class="form-check-label fw-bold" for="char15">Placa Trasera.</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input checklist" type="checkbox" id="char16" checked
                                        name="caracteristicas[]" value="Faros" disabled>
                                    <label class="form-check-label fw-bold" for="char16">Faros.</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input checklist" type="checkbox" id="char17" checked
                                        name="caracteristicas[]" value="Retrovisor" disabled>
                                    <label class="form-check-label fw-bold" for="char17">Retrovisor.</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input checklist" type="checkbox" id="char18" checked
                                        name="caracteristicas[]" value="Tapetes" disabled>
                                    <label class="form-check-label fw-bold" for="char18">Tapetes.</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input checklist" type="checkbox" id="char19" checked
                                        name="caracteristicas[]" value="Claxon" disabled>
                                    <label class="form-check-label fw-bold" for="char19">Claxon.</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input checklist" type="checkbox" id="char20" checked
                                        name="caracteristicas[]" value="Estereo" disabled>
                                    <label class="form-check-label fw-bold" for="char20">Estéreo.</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input checklist" type="checkbox" id="char21" checked
                                        name="caracteristicas[]" value="Poliza de seguro" disabled>
                                    <label class="form-check-label fw-bold" for="char21">Póliza de Seguro.</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input checklist" type="checkbox" id="char22" checked
                                        name="caracteristicas[]" value="Tarjeta de circulacion" disabled>
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
                        <div class="input-group" style="min-height: 10rem !important;">
                            <span class="input-group-text">📝</span>
                            <textarea id="obs_gral" name="obs_gral" class="form-control" aria-label="Notas" maxlength="500" disabled style="resize: none; overflow-y: auto;"></textarea>
                        </div>
                    </div>

                    <hr class="my-4 mb-2">

                    <div class="d-flex flex-row justify-content-end align-items-stretch gap-3" style="height: 60px">
                        <div style="height: 100%;" class="px-2 d-flex flex-row align-items-stretch gap-3">
                            <button style="height: 100%; width:4rem; padding: 0px; !important" type="button"
                                class="d-none button-custom btn rounded-3 m-0" id="cancel"
                                onclick="cancel_edit_mode()">
                                <img src="{{ asset('img/cancel.png') }}" alt="cancelar"
                                    style="height: 100%; width: 4rem;">
                            </button>
                            <button style="height: 100%; width:4rem; padding: 0px; !important" type="button"
                                class="button-custom btn rounded-3 m-0" id="edit"
                                onclick="enable_inpus_edit_mode()">
                                <img src="{{ asset('img/lapiz.png') }}" alt="editar"
                                    style="height: 100%; width: 4rem;">
                            </button>
                            <button style="height: 100%; width:4rem; padding: 0px; !important" type="button"
                                class="button-custom btn rounded-3 m-0" disabled id="save"
                                onclick="ask_before_submit_with_files()">
                                <img src="{{ asset('img/guardar.png') }}" alt="guardar"
                                    style="height: 100%; width: 4rem;">
                            </button>
                        </div>
                    </div>

                    <hr class="my-4 mb-2">
            </form>
        </div>
    </div>
@endsection
