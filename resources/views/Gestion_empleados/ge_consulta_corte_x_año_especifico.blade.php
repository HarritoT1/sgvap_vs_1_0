@extends('layout')

@section('content')
    <div class="w-100 my-3 div-main">
        <h2 class="fw-bold my-3" style="font-size: 2rem; text-align:justify" id="corte_anio_especifico">Corte anual
            {{ $anio }} del
            empleado {{ $employee->nombre }}:
        </h2>
        <script>
            let anio_query = @json($anio);
            let id_query = @json($employee->id);
        </script>
        <div class="table-responsive small">
            <table class="table table-striped table-sm">
                <thead>
                    <tr class="text-center">
                        <th scope="col" style="font-size: 1.3rem;">Mes</th>
                        <th scope="col" style="font-size: 1.3rem;">Año específico</th>
                        <th scope="col" style="font-size: 1.3rem;">Total alimentos</th>
                        <th scope="col" style="font-size: 1.3rem;">Total traslados locales</th>
                        <th scope="col" style="font-size: 1.3rem;">Total traslados externos</th>
                        <th scope="col" style="font-size: 1.3rem;">Total comisión bancaria</th>
                        <th scope="col" style="font-size: 1.3rem;">Total comisión Sí Vale</th>
                        <th scope="col" style="font-size: 1.3rem;">Total de IVA</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($cuts))
                        @foreach ($cuts as $cut)
                            <tr class="text-center" style="font-size: 1.2rem;">
                                <td>{{ $cut->mesName }}</td>
                                <td>{{ $cut->anio }}</td>
                                <td>$ {{ $cut->total_alimentos_mes ?? 0 }}</td>
                                <td>$ {{ $cut->total_traslado_local_mes ?? 0 }}</td>
                                <td>$ {{ $cut->total_traslado_externo_mes ?? 0 }}</td>
                                <td>$ {{ $cut->total_comision_bancaria_mes ?? 0 }}</td>
                                <td>$ {{ $cut->total_comision_sivale_mes ?? 0 }}</td>
                                <td>$ {{ $cut->total_iva_mes ?? 0 }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <div class="col-12 d-flex flex-row justify-content-evenly alig-items-center mt-4">
            <div style="width: 30%">
                <hr class="w-100" style="border-style: solid; border-width: 3px;">
            </div>
            <div style="width: 30%; display: flex; align-items: center; justify-content: center;">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="include_all_personnel">
                    <label class="form-check-label fw-bold text-center" for="include_all_personnel"
                        style="font-size: 0.8rem;">
                        <em>Incluír todo el personal</em>
                    </label>
                </div>
            </div>
            <div style="width: 30%">
                <hr class="w-100" style="border-style: solid; border-width: 3px;">
            </div>
        </div>

        <hr class="my-4 mb-2">

        @if (session('success'))
            <div class="alert alert-success mt-3 text-justify" role="alert" id="success_alert">
                <ul class="mb-0">
                    <li>{{ session('success') }}</li>
                </ul>
            </div>
        @endif

        <div class="loader d-none" id="loaderCircle"></div>
        
        <div id="tables_of_all_personnel" class="d-none"></div>
    </div>
@endsection
