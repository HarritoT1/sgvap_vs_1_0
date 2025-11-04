@extends('layout')

@section('content')
    <div class="w-100 my-3 div-main">
        <h1 class="fw-bold my-3" style="font-size: 2rem; text-align:justify">Crea un proyecto dando de alta toda la
            información
            del formulario:</h1>
        <div class="w-100 div-secondary">

            <h2 class="mb-3 fw-bold" style="font-size: 1.5rem;">Datos del proyecto:</h2>
            <form id="crear_proyecto" action="{{ route('projects.create') }}" method="post"
                enctype="application/x-www-form-urlencoded" autocomplete="off" class="needs-validation p-1" novalidate>
                @csrf
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="id" class="form-label fw-bold">id</label>
                        <input type="text" class="form-control" id="id" name="id" placeholder=""
                            value="{{ old('id') }}" required maxlength="80">
                        <div class="invalid-feedback">
                            Ingresa un id válido.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="nombre" class="form-label fw-bold">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder=""
                            value="{{ old('nombre') }}" required maxlength="150">
                        <div class="invalid-feedback">
                            Ingresa un nombre válido.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="sitio" class="form-label fw-bold">Sitio</label>
                        <input type="text" class="form-control" id="sitio" name="sitio" placeholder=""
                            value="{{ old('sitio') }}" required maxlength="50">
                        <div class="invalid-feedback">
                            Ingresa un sitio válido.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="customer_id" class="form-label fw-bold">Cliente 🤝🏻</label>
                        <select name="customer_id" id="customer_id" class="form-control form-select"
                            aria-label="Default select example" required>
                            <option value="" selected>
                                NINGUNO
                            </option>
                            @if (!empty($customers))
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">
                                        {{ $customer->razon_social }}
                                    </option>
                                @endforeach
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
                                value="{{ old('monto_cobrar') }}" required>
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
                                step="any" min="0" value="{{ old('monto_est_vtc_alimentos') }}">
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
                                step="any" min="0" value="{{ old('monto_est_vtc_tras_local') }}">
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
                                step="any" min="0" value="{{ old('monto_est_vtc_tras_externo') }}">
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
                                step="any" min="0" value="{{ old('monto_est_vtc_com_bancaria') }}">
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
                                step="any" min="0" value="{{ old('monto_est_vtc_gasolina') }}">
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
                                step="any" min="0" value="{{ old('monto_est_vtc_caseta') }}">
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
                                step="any" min="0" value="{{ old('monto_est_vtc_hospedaje') }}">
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
                                min="0" value="{{ old('estimado_viaticos') }}" required>
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
                                placeholder="" value="{{ old('estimado_tiempo') }}" required maxlength="150">
                            <div class="invalid-feedback">
                                Ingresa un estimado válido.
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="fecha_limite" class="form-label fw-bold">Fecha limite</label>
                        <input type="date" class="form-control sm-form-control" id="fecha_limite" name="fecha_limite"
                            value="{{ old('fecha_limite') }}" required>
                        <div class="invalid-feedback">
                            Ingresa una fecha válida.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="notas" class="form-label fw-bold">Notas</label>
                        <div class="input-group" style="min-height: 10rem !important;">
                            <span class="input-group-text">📝</span>
                            <textarea id="notas" name="notas" class="form-control" aria-label="Notas" maxlength="300"
                                style="resize: none; overflow-y: auto;">{{ old('notas') }}</textarea>
                        </div>
                    </div>

                    <hr class="my-4 mb-2">

                    <button class="d-block mx-auto btn btn-primary btn-lg fw-bold button-custom" type="button"
                        onclick="ask_before_submit_new('crear_proyecto')" style="background-color: var(--botones-color);">Crear
                        proyecto</button>

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
@endsection
