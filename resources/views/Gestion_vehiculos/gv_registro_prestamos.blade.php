@extends('layout')

@section('content')
    <div class="w-100 my-3 div-main">
        <h1 class="fw-bold my-3" style="font-size: 2rem; text-align:justify">Genera prestamos de vehículos a empleados de E
            Core Network, llena el formulario:</h1>
        <div class="w-100 div-secondary">

            <h2 class="mb-3 fw-bold" style="font-size: 1.5rem;">Datos del prestamo:</h2>
            <form id="crear_prestamo" action="#" method="post" enctype="application/x-www-form-urlencoded"
                autocomplete="off" class="needs-validation p-1" novalidate>
                <div class="row g-3">

                    <div class="col-sm-6">
                        <label for="input_find_rfc" class="form-label fw-bold">RFC del empleado títular</label>
                        <input type="text" class="form-control" id="input_find_rfc" name="employee_id" placeholder=""
                            value="" required maxlength="50" list="sugerencias_rfc">
                        <div class="invalid-feedback">
                            Ingresa un RFC válido.
                        </div>
                        <datalist id="sugerencias_rfc">
                        </datalist>
                    </div>

                    <div class="col-sm-6">
                        <label for="proveedor" class="form-label fw-bold">Proveedor</label>
                        <input type="text" class="form-control" id="proveedor" name="proveedor" placeholder=""
                            value="" required maxlength="100">
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

                        <input type="text" class="form-control" id="input_find_id_proyect" name="project_id"
                            placeholder="" value="" required maxlength="80" list="sugerencias_id_proyect">
                        <div class="invalid-feedback">
                            Ingresa un id de proyecto válido.
                        </div>
                        <datalist id="sugerencias_id_proyect">
                        </datalist>
                    </div>

                    <div class="col-sm-6">
                        <label for="vehicle_id" class="form-label fw-bold">Placa del vehículo</label>
                        <select name="vehicle_id" id="vehicle_id" class="form-control form-select"
                            aria-label="Default select example" required>
                            <option value="" selected>
                                NINGUNA
                            </option>
                            <option value="ABJ3-S23D">
                                ABJ3-S23D
                            </option>
                            <option value="ABJ3-S23E">
                                ABJ3-S23E
                            </option>
                        </select>
                        <div class="invalid-feedback">
                            Ingresa una placa de vehículo válida.
                        </div>
                    </div>

                    <div class="col-sm-6 mx-auto">
                        <label for="fecha_prestamo" class="form-label fw-bold">Fecha del prestamo</label>
                        <input type="date" class="form-control sm-form-control" id="fecha_prestamo"
                            name="fecha_prestamo" value="" required>
                        <div class="invalid-feedback">
                            Ingresa una fecha válida.
                        </div>
                    </div>

                    <hr class="my-4 mb-2">

                    <button class="d-block mx-auto btn btn-primary btn-lg fw-bold button-custom" type="button"
                        onclick="ask_before_submit_new()" style="background-color: var(--botones-color);">Generar
                        prestamo</button>
                </div>
            </form>
        </div>
    </div>
@endsection
