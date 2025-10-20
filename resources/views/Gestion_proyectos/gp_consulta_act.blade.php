@extends('layout')

@section('content')
    <div class="w-100 my-3 div-main">
        <h1 class="fw-bold my-3" style="font-size: 2rem; text-align:justify">Detalles del proyecto con el id: $id</h1>
        <div class="w-100 div-secondary">

            <h2 class="mb-3 fw-bold" style="font-size: 1.5rem;">Datos del proyecto:</h2>
            <form id="actualizar" action="#" method="post" enctype="application/x-www-form-urlencoded"
                autocomplete="off" class="needs-validation p-1" novalidate>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="id" class="form-label fw-bold">id</label>
                        <input type="text" class="form-control" id="id" name="id" placeholder=""
                            value="ID001" required maxlength="80" disabled>
                        <div class="invalid-feedback">
                            Ingresa un id válido.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="nombre" class="form-label fw-bold">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder=""
                            value="Proyecto ICE 2025" required maxlength="150" disabled>
                        <div class="invalid-feedback">
                            Ingresa un nombre válido.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="sitio" class="form-label fw-bold">Sitio</label>
                        <input type="text" class="form-control" id="sitio" name="sitio" placeholder=""
                            value="Antara" required maxlength="50" disabled>
                        <div class="invalid-feedback">
                            Ingresa un sitio válido.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="customer_id" class="form-label fw-bold">Cliente 🤝🏻</label>
                        <select name="customer_id" id="customer_id" class="form-control form-select"
                            aria-label="Default select example" required disabled>
                            <option value="">
                                NINGUNO
                            </option>
                            <option value="RFC_1" selected>
                                RAZON_SOCIAL_1
                            </option>
                            <option value="RFC_2">
                                RAZON_SOCIAL_2
                            </option>
                        </select>
                        <div class="invalid-feedback">
                            Selecciona un cliente por favor.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="monto_cobrar" class="form-label fw-bold">Monto a cobrar</label>
                        <div class="input-group">
                            <span class="input-group-text">💰</span>
                            <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)"
                                id="monto_cobrar" name="monto_cobrar" placeholder="0.000" step="0.00000001" min="0"
                                value="15230.75" required disabled>
                            <div class="invalid-feedback">
                                Ingresa un monto válido.
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="monto_est_vtc_alimentos" class="form-label fw-bold">Estimado de viático
                            alimentos</label>
                        <div class="input-group">
                            <span class="input-group-text">🍞</span>
                            <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)"
                                id="monto_est_vtc_alimentos" name="monto_est_vtc_alimentos" placeholder="0.000"
                                step="0.00000001" min="0" value="1200.50" disabled>
                            <div class="invalid-feedback">
                                Ingresa un estimado válido.
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="monto_est_vtc_tras_local" class="form-label fw-bold">Estimado de viático traslado
                            local</label>
                        <div class="input-group">
                            <span class="input-group-text">🚗</span>
                            <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)"
                                id="monto_est_vtc_tras_local" name="monto_est_vtc_tras_local" placeholder="0.000"
                                step="0.00000001" min="0" value="450.00" disabled>
                            <div class="invalid-feedback">
                                Ingresa un estimado válido.
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="monto_est_vtc_tras_externo" class="form-label fw-bold">Estimado de viático traslado
                            externo</label>
                        <div class="input-group">
                            <span class="input-group-text">✈️</span>
                            <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)"
                                id="monto_est_vtc_tras_externo" name="monto_est_vtc_tras_externo" placeholder="0.000"
                                step="0.00000001" min="0" value="800.00" disabled>
                            <div class="invalid-feedback">
                                Ingresa un estimado válido.
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="monto_est_vtc_com_bancaria" class="form-label fw-bold">Estimado de viático comisión
                            bancaria</label>
                        <div class="input-group">
                            <span class="input-group-text">🏦</span>
                            <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)"
                                id="monto_est_vtc_com_bancaria" name="monto_est_vtc_com_bancaria" placeholder="0.000"
                                step="0.00000001" min="0" value="300.00" disabled>
                            <div class="invalid-feedback">
                                Ingresa un estimado válido.
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="monto_est_vtc_gasolina" class="form-label fw-bold">Estimado de viático
                            gasolina</label>
                        <div class="input-group">
                            <span class="input-group-text">⛽</span>
                            <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)"
                                id="monto_est_vtc_gasolina" name="monto_est_vtc_gasolina" placeholder="0.000"
                                step="0.00000001" min="0" value="1500.00" disabled>
                            <div class="invalid-feedback">
                                Ingresa un estimado válido.
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="monto_est_vtc_caseta" class="form-label fw-bold">Estimado de viático caseta</label>
                        <div class="input-group">
                            <span class="input-group-text">🛣️</span>
                            <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)"
                                id="monto_est_vtc_caseta" name="monto_est_vtc_caseta" placeholder="0.000"
                                step="0.00000001" min="0" value="200.00" disabled>
                            <div class="invalid-feedback">
                                Ingresa un estimado válido.
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="monto_est_vtc_hospedaje" class="form-label fw-bold">Estimado de viático
                            hospedaje</label>
                        <div class="input-group">
                            <span class="input-group-text">🏨</span>
                            <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)"
                                id="monto_est_vtc_hospedaje" name="monto_est_vtc_hospedaje" placeholder="0.000"
                                step="0.00000001" min="0" value="2500.00" disabled>
                            <div class="invalid-feedback">
                                Ingresa un estimado válido.
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="estimado_viaticos" class="form-label fw-bold">Estimado en viáticos total</label>
                        <div class="input-group">
                            <span class="input-group-text">💵</span>
                            <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)"
                                id="estimado_viaticos" name="estimado_viaticos" placeholder="0.000" step="0.00000001"
                                min="0" value="6950.50" required disabled>
                            <div class="invalid-feedback">
                                Ingresa un estimado válido.
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="estimado_tiempo" class="form-label fw-bold">Estimado en tiempo</label>
                        <div class="input-group">
                            <span class="input-group-text">⌛</span>
                            <input type="text" class="form-control" id="estimado_tiempo" name="estimado_tiempo"
                                placeholder="" value="15 días" required maxlength="150" disabled>
                            <div class="invalid-feedback">
                                Ingresa un estimado válido.
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="fecha_limite" class="form-label fw-bold">Fecha limite</label>
                        <input type="date" class="form-control sm-form-control" id="fecha_limite" name="fecha_limite"
                            value="2025-11-15" required disabled>
                        <div class="invalid-feedback">
                            Ingresa una fecha válida.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="status" class="form-label fw-bold">Estado del proyecto</label>
                        <select name="status" id="status" class="form-control form-select" aria-label="Default select example" required disabled>
                            <option value="activo">
                                ACTIVO
                            </option>
                            <option value="concluido" selected>
                                CONCLUIDO
                            </option>
                        </select>
                        <div class="invalid-feedback">
                            Ingresa un status válido.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="fecha_creacion" class="form-label fw-bold">Fecha y hora de creación</label>
                        <input type="text" class="form-control" id="fecha_creacion" name="fecha_creacion" placeholder=""
                            value="2025-10-20 14:30:00" required readonly>
                        <div class="invalid-feedback">
                            Ingresa una fecha de creación válida.
                        </div>
                    </div>

                    <div class="col-sm-6 mx-auto">
                        <label for="notas" class="form-label fw-bold">Notas</label>
                        <div class="input-group">
                            <span class="input-group-text">📝</span>
                            <textarea id="notas" name="notas" class="form-control" aria-label="Notas" maxlength="300" disabled style="height: 1.5rem;">Visita de supervisión programada. Revisar documentos y actas previas.</textarea>
                        </div>
                    </div>

                    <hr class="my-4 mb-2">

                    <div class="d-flex flex-row justify-content-end align-items-stretch gap-3" style="height: 60px">
                        <div style="height: 100%; border-width: 3px; border-color: rgba(0, 0, 0, 0.148); border-right-style: solid;" class="px-2 pe-3 d-flex flex-row align-items-stretch gap-3">
                            <button style="height: 100%; width:4rem; padding: 0px; !important" type="button" class="d-none button-custom btn rounded-3 m-0" id="cancel" onclick="cancel_edit_mode()">
                                <img src="{{asset('img/cancel.png')}}" alt="cancelar" style="height: 100%; width: 4rem;">
                            </button>
                            <button style="height: 100%; width:4rem; padding: 0px; !important" type="button" class="button-custom btn rounded-3 m-0" id="edit" onclick="enable_inpus_edit_mode()">
                                <img src="{{asset('img/lapiz.png')}}" alt="editar" style="height: 100%; width: 4rem;">
                            </button>
                            <button style="height: 100%; width:4rem; padding: 0px; !important" type="button" class="button-custom btn rounded-3 m-0" disabled id="save" onclick="ask_before_submit()">
                                <img src="{{asset('img/guardar.png')}}" alt="guardar" style="height: 100%; width: 4rem;">
                            </button>
                        </div>
                        <div style="height: 100%;" class="px-2 ps-0 d-flex flex-row align-items-stretch gap-3">
                            <button style="height: 100%; width:4rem; padding: 0px; !important" type="button" class="button-custom btn rounded-3 m-0" disabled id="pdf">
                                <img src="{{asset('img/pdf.png')}}" alt="pdf" style="height: 100%; width: 4rem;">
                            </button>
                        </div>
                    </div>

                    <hr class="my-4 mb-2">
            </form>
        </div>
    </div>
@endsection
