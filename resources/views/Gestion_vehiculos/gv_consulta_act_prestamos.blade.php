@extends('layout')

@section('content')
    <div class="w-100 my-3 div-main">
        <h1 class="fw-bold my-3" style="font-size: 2rem; text-align:justify" id="prestamo_vehicular_act_form">Detalles del
            prestamo y actualización del estado
            del vehículo:</h1>

        <form id="actualizar_version_2" action="#" method="post" enctype="multipart/form-data" autocomplete="off"
            class="needs-validation p-1" novalidate>

            <div class="w-100 div-secondary mb-3">
                <h2 class="mb-3 fw-bold" style="font-size: 1.5rem;">Datos del vehículo en cuestión:</h2>

                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="vehicle_id" class="form-label fw-bold">Placa</label>
                        <input type="text" class="form-control" id="vehicle_id" name="vehicle_id" placeholder="ASP-MV9"
                            value="ASP-MV9" required maxlength="20" readonly>
                        <div class="invalid-feedback">
                            Ingresa una placa vehícular válida.
                        </div>
                    </div>

                    <div class="col-sm-6 mx-auto">
                        <label for="km_salida" class="form-label fw-bold">Km previo al prestamo</label>
                        <div class="input-group">
                            <span class="input-group-text">⏲</span>
                            <input type="number" class="form-control" id="km_salida" name="km_salida" placeholder=""
                                step="1" min="0" value="55500" required readonly>
                            <div class="invalid-feedback">
                                Ingresa un km entero válido.
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="vehicle_status" class="form-label fw-bold">Estado del vehículo</label>
                        <select name="vehicle_status" id="vehicle_status" class="form-control form-select"
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

                    <hr class="my-4 mb-2">

                    <h2 class="mb-3 fw-bold" style="font-size: 1.5rem;text-align:justify;">Selecciona los ítems del estado
                        actual del
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

                </div>
            </div>

            <div class="w-100 div-secondary my-5">

                <h2 class="mb-3 fw-bold" style="font-size: 1.5rem;">Datos del prestamo:</h2>

                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="input_find_rfc" class="form-label fw-bold">RFC del empleado títular</label>
                        <input form="actualizar_version_2" type="text" class="form-control" id="input_find_rfc"
                            name="employee_id" placeholder="" value="XXXXYYYYMMDDZZZ" required maxlength="50"
                            list="sugerencias_rfc" readonly>
                        <div class="invalid-feedback">
                            Ingresa un RFC válido.
                        </div>
                        <datalist id="sugerencias_rfc">
                        </datalist>
                    </div>

                    <div class="col-sm-6">
                        <label for="proveedor" class="form-label fw-bold">Proveedor</label>
                        <input form="actualizar_version_2" type="text" class="form-control" id="proveedor"
                            name="proveedor" placeholder="" value="Miguel Cuevas Díaz" required maxlength="100"
                            disabled>
                        <div class="invalid-feedback">
                            Ingresa un nombre de proveedor válido.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="input_find_id_proyect" class="form-label fw-bold w-100">id del proyecto <span
                                class="position-relative" id="msgBASE" style="cursor: pointer;">ⓘ
                                <div class="msgFloat">
                                    Este prestamo vehícular considera traslados vehículares a diferentes proyectos.
                                </div>
                            </span></label>

                        <input form="actualizar_version_2" type="text" class="form-control"
                            id="input_find_id_proyect" name="project_id" placeholder="" value="PRJ-2025-001" required
                            maxlength="80" list="sugerencias_id_proyect" readonly>
                        <div class="invalid-feedback">
                            Ingresa un id de proyecto válido.
                        </div>
                        <datalist id="sugerencias_id_proyect">
                        </datalist>
                    </div>

                    <div class="col-sm-6">
                        <label for="fecha_prestamo" class="form-label fw-bold">Fecha del prestamo</label>
                        <input form="actualizar_version_2" type="date" class="form-control sm-form-control"
                            id="fecha_prestamo" name="fecha_prestamo" value="2025-12-12" required disabled>
                        <div class="invalid-feedback">
                            Ingresa una fecha válida.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="prestamo_status" class="form-label fw-bold">Estado del prestamo</label>
                        <select form="actualizar_version_2" name="prestamo_status" id="prestamo_status"
                            class="form-control form-select" aria-label="Default select example" required disabled>
                            <option value="entregado" selected>
                                CONCLUIDO
                            </option>
                            <option value="no_entregado">
                                PENDIENTE
                            </option>
                        </select>
                        <div class="invalid-feedback">
                            Ingresa un status válido.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="fecha_devolucion" class="form-label fw-bold">Fecha de devolución</label>
                        <input form="actualizar_version_2" type="date" class="form-control sm-form-control"
                            id="fecha_devolucion" name="fecha_devolucion" value="2025-12-20" required disabled>
                        <div class="invalid-feedback">
                            Ingresa una fecha válida.
                        </div>
                    </div>

                    <div class="col-sm-6 mx-auto">
                        <label for="km_retorno" class="form-label fw-bold">Km posterior al prestamo</label>
                        <div class="input-group">
                            <span class="input-group-text">⏲</span>
                            <input form="actualizar_version_2" type="number" class="form-control" id="km_retorno"
                                name="km_retorno" placeholder="" step="1" min="0" value="56000" required
                                disabled>
                            <div class="invalid-feedback">
                                Ingresa un km entero válido.
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="w-100 div-secondary my-3">

                <h2 class="mb-3 fw-bold" style="font-size: 1.5rem;">Evidencias gráficas del prestamo:</h2>

                <div class="row g-3">
                    <div class="col-sm-6">
                        <label class="form-label d-block w-100" style="cursor: pointer;" title="Cambiar fotografía">
                            <img id="prev_foto_1" class="imageResponsive my-2 img_file" alt="img"
                                src="{{ asset('img/sin_img.jpg') }}"
                                style="max-width: 90%; width: 16rem; border-radius: 15px; box-shadow: -1px 3px 10px 4px rgba(0,0,0,0.75); height: 13rem;">
                        </label>
                        <input form="actualizar_version_2" type="file" class="form-control mt-4 mb-3"
                            id="ruta_evidencia_1" name="ruta_evidencia_1"
                            accept="image/png, image/jpeg, image/webp, image/gif" disabled>
                        <div class="invalid-feedback">
                            Ingresa un archivo válido.
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label d-block w-100" style="cursor: pointer;" title="Cambiar fotografía">
                            <img id="prev_foto_2" class="imageResponsive my-2 img_file" alt="img"
                                src="{{ asset('img/sin_img.jpg') }}"
                                style="max-width: 90%; width: 16rem; border-radius: 15px; box-shadow: -1px 3px 10px 4px rgba(0,0,0,0.75); height: 13rem;">
                        </label>
                        <input form="actualizar_version_2" type="file" class="form-control mt-4 mb-3"
                            id="ruta_evidencia_2" name="ruta_evidencia_2"
                            accept="image/png, image/jpeg, image/webp, image/gif" disabled>
                        <div class="invalid-feedback">
                            Ingresa un archivo válido.
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label d-block w-100" style="cursor: pointer;" title="Cambiar fotografía">
                            <img id="prev_foto_3" class="imageResponsive my-2 img_file" alt="img"
                                src="{{ asset('img/sin_img.jpg') }}"
                                style="max-width: 90%; width: 16rem; border-radius: 15px; box-shadow: -1px 3px 10px 4px rgba(0,0,0,0.75); height: 13rem;">
                        </label>
                        <input form="actualizar_version_2" type="file" class="form-control mt-4 mb-3"
                            id="ruta_evidencia_3" name="ruta_evidencia_3"
                            accept="image/png, image/jpeg, image/webp, image/gif" disabled>
                        <div class="invalid-feedback">
                            Ingresa un archivo válido.
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label d-block w-100" style="cursor: pointer;" title="Cambiar fotografía">
                            <img id="prev_foto_4" class="imageResponsive my-2 img_file" alt="img"
                                src="{{ asset('img/prueba_seat.jpg') }}"
                                style="max-width: 90%; width: 16rem; border-radius: 15px; box-shadow: -1px 3px 10px 4px rgba(0,0,0,0.75); height: 13rem;">
                        </label>
                        <input form="actualizar_version_2" type="file" class="form-control mt-4 mb-3"
                            id="ruta_evidencia_4" name="ruta_evidencia_4"
                            accept="image/png, image/jpeg, image/webp, image/gif" disabled>
                        <div class="invalid-feedback">
                            Ingresa un archivo válido.
                        </div>
                    </div>
                    <div class="col-sm-6 mx-auto">
                        <label class="form-label d-block w-100" style="cursor: pointer;" title="Cambiar fotografía">
                            <img id="prev_foto_5" class="imageResponsive my-2 img_file" alt="img"
                                src="{{ asset('img/sin_img.jpg') }}"
                                style="max-width: 90%; width: 16rem; border-radius: 15px; box-shadow: -1px 3px 10px 4px rgba(0,0,0,0.75); height: 13rem;">
                        </label>
                        <input form="actualizar_version_2" type="file" class="form-control mt-4 mb-3"
                            id="ruta_evidencia_5" name="ruta_evidencia_5"
                            accept="image/png, image/jpeg, image/webp, image/gif" disabled>
                        <div class="invalid-feedback">
                            Ingresa un archivo válido.
                        </div>
                    </div>
                </div>

                <hr class="my-4 mb-2">

                <div class="col-12 mb-3">
                    <label for="prestamo_obs_gral" class="form-label fw-bold">Observación general del
                        prestamo:</label>
                    <div class="input-group" style="min-height: 10rem !important;">
                        <span class="input-group-text">📝</span>
                        <textarea form="actualizar_version_2" id="prestamo_obs_gral" name="prestamo_obs_gral" class="form-control"
                            aria-label="Notas" maxlength="500" disabled style="resize: none; overflow-y: auto;">El coche perdio los tapones de las llantas.</textarea>
                    </div>
                </div>

                <hr class="my-4 mb-2">

                <div class="d-flex flex-row justify-content-end align-items-stretch gap-3" style="height: 60px">
                    @if ('entregado' !== 'entregado')
                        <div style="height: 100%;" class="d-flex flex-row align-items-stretch gap-3">
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
                    @else
                        <div style="height: 100%; border-width: 3px; border-color: rgba(0, 0, 0, 0.148); border-right-style: solid;"
                            class="px-2 pe-3 d-flex flex-row align-items-stretch gap-3">
                            <label class="form-label m-0" style="cursor: pointer;" title="Subir política" for="politica">
                                <img src="{{ asset('img/politica.png') }}" alt="img" style="height: 100%; width: 4rem;">
                            </label>
                            <input form="" type="file" class="form-control form-control-sm d-none" style="align-self: center; width: 12rem;"
                                id="politica" name="politica"
                                accept="image/png">
                        </div>
                        <div style="height: 100%;" class="px-2 ps-0 d-flex flex-row align-items-stretch gap-3">
                            <button style="height: 100%; width:4rem; padding: 0px; !important" type="button"
                                class="button-custom btn rounded-3 m-0" disabled id="button_generate_pdf" onclick="generate_pdf_prestamos_vehiculares()">
                                <img src="{{ asset('img/pdf.png') }}" alt="pdf" style="height: 100%; width: 4rem;">
                            </button>
                        </div>
                    @endif
                </div>

                <hr class="my-4 mb-2">
            </div>

        </form>
    </div>
@endsection
