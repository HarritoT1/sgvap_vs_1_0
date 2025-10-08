@extends('layout')

@section('content')
    <div class="w-100 my-3 div-main">
        <h1 class="fw-bold my-3" style="font-size: 2rem; text-align:justify">Registra una dispersión de caseta llenando el
            formulario:</h1>
        <div class="w-100 div-secondary">

            <h2 class="mb-3 fw-bold" style="font-size: 1.5rem;">Datos de la dispersión:</h2>
            <form id="crear_dm_caseta" action="#" method="post" enctype="application/x-www-form-urlencoded"
                autocomplete="off" class="needs-validation p-1" novalidate>
                <div class="row g-3">

                    <div class="col-sm-6">
                        <label for="fecha_dispersion" class="form-label fw-bold">Fecha de la dispersión</label>
                        <input type="date" class="form-control sm-form-control" id="fecha_dispersion"
                            name="fecha_dispersion" value="" required>
                        <div class="invalid-feedback">
                            Ingresa una fecha válida.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="input_find_id_proyect" class="form-label fw-bold">id del proyecto</label>
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
                            <option value="ABJ3-S23D" selected>
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

                    <div class="col-sm-6">
                        <label for="nombre_caseta" class="form-label fw-bold">Nombre de la caseta</label>
                        <input type="text" class="form-control" id="nombre_caseta" name="nombre_caseta"
                            placeholder="" value="" required maxlength="100">
                        <div class="invalid-feedback">
                            Ingresa un id de proyecto válido.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="base_imponible" class="form-label fw-bold w-100">Base imponible <span
                                class="position-relative" id="msgBASE" style="cursor: pointer;">ⓘ
                                <div class="msgFloat">
                                    La base imponible se calcula como: Monto dispersado / 1.16
                                </div>
                            </span></label>

                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)"
                                id="base_imponible" name="base_imponible" placeholder="0.000" step="0.000001" min="0"
                                value="" required readonly>
                            <div class="invalid-feedback">
                                Ingresa una base imponible válida.
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="iva_acumulado" class="form-label fw-bold w-100">IVA acumulado <span
                                class="position-relative" id="msgIVA" style="cursor: pointer;">ⓘ
                                <div class="msgFloat">
                                    El IVA acumulado se calcula como: Base imponible * 0.16
                                </div>
                            </span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)"
                                id="iva_acumulado" name="iva_acumulado" placeholder="0.000" step="0.000001" min="0"
                                value="" required readonly>
                            <div class="invalid-feedback">
                                Ingresa un IVA acumulado válido.
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mx-auto">
                        <label for="importe_total" class="form-label fw-bold">Importe total</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)"
                                id="importe_total" name="importe_total" placeholder="0.000" step="0.000001"
                                min="0" value="" required>
                            <div class="invalid-feedback">
                                Ingresa un importe total válido.
                            </div>
                        </div>
                    </div>

                    <hr class="my-4 mb-2">

                    <button class="d-block mx-auto btn btn-primary btn-lg fw-bold button-custom" type="button"
                        onclick="ask_before_submit_new()" style="background-color: var(--botones-color);">Registrar
                        dispersión</button>

                    <hr class="my-4 mb-2">
            </form>

            <h2 class="mb-3 fw-bold" style="font-size: 1.5rem; text-align: justify">Importar excel para registro de
                dispersiones de caseta automaticamente.</h2>

            <h3 class="my-3 fw-bold" style="font-size: 1.3rem; text-align: justify">Tu archivo tiene que cumplir algunos
                criterios para ser apto:</h3>

            <ul class="mb-3 flex-column vineta" style="font-size: 1.2rem; text-align: justify">
                <li class="mb-2">Tu archivo tiene que estar en formato ‘.xls’ o ‘.xlsx’.</li>
                <li>Tu archivo tiene que tener una tabla con los siguientes headers (estrictamente igual nombrados). Por
                    ejemplo:</li>
            </ul>

            <div class="p-0" style="overflow-x: auto;">
                <img class="imageResponsive my-2" alt="img" src="{{ asset('img/gasoline_example.png') }}"
                    style="width: 70rem; min-height: 4rem; max-width: none;">
            </div>

            <ul class="mb-3 flex-column vineta" style="font-size: 1.2rem; text-align: justify">
                <li class="mb-2">La fila 1 es para los headers y las posteriores para los registros, compara los valores
                    de la imagen con
                    tu tabla.</li>
                <li class="mb-2">La hoja de cálculo de los registros a almacenar debe ser la primera.</li>
                <li class="mb-2">El campo <em class="fw-bold">fecha_dispersion</em> debe de ir como una cadena texto
                    <strong>encerrada entre comillas dobles</strong>. Y cumplir el formato <strong>aaaa/mm/dd</strong>.</li>
                <li class="mb-2">Si necesitas la plantilla base .xlsx compatible, la puedes <a
                        class="text-decoration-none" download="dp_gasolina_formato_valido.xlsx"
                        href="{{ asset('img/dp_gasolina_formato_valido.xlsx') }}">descargar aquí</a>. Los campos
                    <strong>base_imponible</strong>, <strong>iva_acumulado</strong> e <strong>importe_total</strong> ya
                    vienen calculados automáticamente en esta plantilla al momento de ingresar el
                    <strong>monto_dispersado</strong>.</li>
                <li>Si cumples con todo ello tus registros serán almacenados correctamente y se te notificará aquí mismo, en
                    caso contrario, se te notificará de igual forma.</li>
            </ul>

            <div class="mb-3 mx-auto" style="width: 25rem;">
                <label for="xls_gasoline" class="form-label d-block w-100" style="cursor: pointer;">
                    <img class="imageResponsive my-2" alt="img" src="{{ asset('img/xls.png') }}"
                        style="width: 10rem;">
                </label>
                <input type="file" class="form-control my-3" id="xls_gasoline" accept=".xls, .xlsx">
                <div class="invalid-feedback">
                    Ingresa un archivo válido.
                </div>
            </div>

            <hr class="my-4 mb-2">

            <button class="d-block mx-auto btn btn-primary btn-lg fw-bold button-custom" type="button"
                id="button_analizar_excel"
                onclick="analizar_xls(['fecha_dispersion', 'project_id', 'vehicle_id', 'costo_lt', 'cant_litros', 'monto_dispersado', 'base_imponible', 'iva_acumulado', 'importe_total'])"
                style="background-color: rgb(161, 160, 160)" disabled>Analizar excel y almacenar registros</button>
        </div>
    </div>
@endsection
