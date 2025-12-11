@extends('layout')

@section('content')
    <div class="w-100 my-3 div-main">
        <h1 class="fw-bold my-3" style="font-size: 2rem; text-align:justify">Detalles del proyecto con el id: {{ $project->id }}</h1>
        <div class="w-100 div-secondary">

            <h2 class="mb-3 fw-bold" style="font-size: 1.5rem;">Datos del proyecto:</h2>
            <form id="actualizar" action="{{ route('projects.update') }}" method="post"
                enctype="application/x-www-form-urlencoded" autocomplete="off" class="needs-validation p-1" novalidate>
                @csrf
                @method('PUT')

                <input type="hidden" name="id_project" value="{{ $project->id }}" class="ignore">

                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="id" class="form-label fw-bold">id</label>
                        <input type="text" class="form-control" id="id" name="id" placeholder=""
                            value="{{ $project->id }}" required maxlength="80" disabled>
                        <div class="invalid-feedback">
                            Ingresa un id válido.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="nombre" class="form-label fw-bold">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder=""
                            value="{{ $project->nombre }}" required maxlength="150" disabled>
                        <div class="invalid-feedback">
                            Ingresa un nombre válido.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="sitio" class="form-label fw-bold">Sitio</label>
                        <input type="text" class="form-control" id="sitio" name="sitio" placeholder=""
                            value="{{ $project->sitio }}" required maxlength="50" disabled>
                        <div class="invalid-feedback">
                            Ingresa un sitio válido.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="customer_id" class="form-label fw-bold">Cliente (activo) 🤝🏻</label>
                        <select name="customer_id" id="customer_id" class="form-control form-select"
                            aria-label="Default select example" required disabled>

                            @if (!empty($customers))
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" @if ($project->customer_id == $customer->id) selected @endif>
                                        {{ $customer->razon_social }}
                                    </option>
                                @endforeach
                            @else
                                <option value="" selected>
                                    NINGUNO
                                </option>
                            @endif

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
                                id="monto_cobrar" name="monto_cobrar" placeholder="0.000" step="any" min="0"
                                value="{{ $project->monto_cobrar }}" required disabled>
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
                                step="any" min="0" value="{{ $project->monto_est_vtc_alimentos ?? 0 }}" disabled>
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
                                step="any" min="0" value="{{ $project->monto_est_vtc_tras_local ?? 0 }}"
                                disabled>
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
                                step="any" min="0" value="{{ $project->monto_est_vtc_tras_externo ?? 0 }}"
                                disabled>
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
                                step="any" min="0" value="{{ $project->monto_est_vtc_com_bancaria ?? 0 }}"
                                disabled>
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
                                step="any" min="0" value="{{ $project->monto_est_vtc_gasolina ?? 0 }}"
                                disabled>
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
                                id="monto_est_vtc_caseta" name="monto_est_vtc_caseta" placeholder="0.000" step="any"
                                min="0" value="{{ $project->monto_est_vtc_caseta ?? 0 }}" disabled>
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
                                step="any" min="0" value="{{ $project->monto_est_vtc_hospedaje ?? 0 }}"
                                disabled>
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
                                id="estimado_viaticos" name="estimado_viaticos" placeholder="0.000" step="any"
                                min="0" value="{{ $project->estimado_viaticos }}" required disabled>
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
                                placeholder="" value="{{ $project->estimado_tiempo }}" required maxlength="150"
                                disabled>
                            <div class="invalid-feedback">
                                Ingresa un estimado válido.
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="fecha_limite" class="form-label fw-bold">Fecha limite</label>
                        <input type="date" class="form-control sm-form-control" id="fecha_limite" name="fecha_limite"
                            value="{{ $project->fecha_limite->toDateString() }}" required disabled>
                        <div class="invalid-feedback">
                            Ingresa una fecha válida.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="status" class="form-label fw-bold">Estado del proyecto</label>
                        <select name="status" id="status" class="form-control form-select"
                            aria-label="Default select example" required disabled>
                            <option value="activo" @if ($project->status == 'activo') selected @endif>
                                ACTIVO
                            </option>
                            <option value="concluido" @if ($project->status == 'concluido') selected @endif>
                                CONCLUIDO
                            </option>
                        </select>
                        <div class="invalid-feedback">
                            Ingresa un status válido.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="fecha_creacion" class="form-label fw-bold">Fecha y hora de creación</label>
                        <!-- Elimine name="fecha_creacion" para que no se mande en el request de actualización. -->
                        <input type="text" class="form-control ignore" id="fecha_creacion" placeholder=""
                            value="{{ $project->fecha_creacion }}" required readonly>
                        <div class="invalid-feedback">
                            Ingresa una fecha de creación válida.
                        </div>
                    </div>

                    <div class="col-sm-6 mx-auto">
                        <label for="notas" class="form-label fw-bold">Notas</label>
                        <div class="input-group" style="min-height: 10rem !important;">
                            <span class="input-group-text">📝</span>
                            <textarea id="notas" name="notas" class="form-control" aria-label="Notas" maxlength="300" disabled
                                style="resize: none; overflow-y: auto;">{{ $project->notas ?? 'SIN NOTAS' }}</textarea>
                        </div>
                    </div>

                    <hr class="my-4 mb-2">

                    <div class="d-flex flex-row justify-content-end align-items-stretch gap-3" style="height: 60px">
                        @if ($project->status !== 'concluido')
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
                                    onclick="ask_before_submit()">
                                    <img src="{{ asset('img/guardar.png') }}" alt="guardar"
                                        style="height: 100%; width: 4rem;">
                                </button>
                            </div>
                        @else
                            <div style="height: 100%;" class="px-2 ps-0 d-flex flex-row align-items-stretch gap-3">
                                <button style="height: 100%; width:4rem; padding: 0px; !important" type="button"
                                    class="button-custom btn rounded-3 m-0" id="button_generate_pdf_project"
                                    onclick="generate_pdf_project()">
                                    <img src="{{ asset('img/pdf.png') }}" alt="pdf"
                                        style="height: 100%; width: 4rem;">
                                </button>
                            </div>
                        @endif
                    </div>

                    <hr class="my-4 mb-2">

                    <input type="hidden" id="razon_social" value="{{ $project->customer->razon_social }}" class="ignore">
                    <input type="hidden" id="ubicacion" value="{{ $project->customer->ubicacion }}" class="ignore">
                    <input type="hidden" id="customer_status" value="{{ $project->customer->status }}" class="ignore">

                    @if (session('success'))
                        <div class="alert alert-success mt-3 text-justify" role="alert">
                            <ul class="mb-0">
                                <li>{{ session('success') }}</li>
                            </ul>
                        </div>
                    @endif

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
