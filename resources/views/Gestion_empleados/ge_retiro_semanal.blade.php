@extends('layout')

@section('content')
    <div class="w-100 my-3 div-main">
        <h1 class="fw-bold my-3" style="font-size: 2rem; text-align:justify">Resumen de retiro semanal de: {{ $employee_name }}
        </h1>
        <div class="table-responsive small">
            <table class="table table-striped table-sm">
                <thead>
                    <tr class="text-center">
                        <th scope="col" style="font-size: 1.3rem;">Día</th>
                        <th scope="col" style="font-size: 1.3rem;">Desayuno</th>
                        <th scope="col" style="font-size: 1.3rem;">Comida</th>
                        <th scope="col" style="font-size: 1.3rem;">Cena</th>
                        <th scope="col" style="font-size: 1.3rem;">Traslado local</th>
                        <th scope="col" style="font-size: 1.3rem;">Traslado externo</th>
                        <th scope="col" style="font-size: 1.3rem;">Comisión bancaria</th>
                        <th scope="col" style="font-size: 1.3rem;">id de proyecto</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($semanal_records))
                        @foreach ($semanal_records as $record)
                            <tr class="text-center" style="font-size: 1.2rem;">
                                <td>{{ $record->fecha_dispersion_dia->toDateString() }}</td>
                                <td>$ {{ $record->desayuno ?? 0 }}</td>
                                <td>$ {{ $record->comida ?? 0 }}</td>
                                <td>$ {{ $record->cena ?? 0 }}</td>
                                <td>$ {{ $record->traslado_local ?? 0 }}</td>
                                <td>$ {{ $record->traslado_externo ?? 0 }}</td>
                                <td>$ {{ $record->comision_bancaria ?? 0 }}</td>
                                <td>{{  $record->project_id }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <h2 class="fw-bold my-3" style="font-size: 2rem; text-align:justify">Total de retiro semanal de: {{ $employee_name }}</h2>
        <div class="table-responsive small">
            <table class="table table-striped table-sm">
                <thead>
                    <tr class="text-center">
                        <th scope="col" style="font-size: 1.3rem;">Total alimentos</th>
                        <th scope="col" style="font-size: 1.3rem;">Total traslados</th>
                        <th scope="col" style="font-size: 1.3rem;">Total comisión</th>
                        <th scope="col" style="font-size: 1.3rem;"><em>TOTAL A RETIRAR EN ESTA SEMANA</em></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center" style="font-size: 1.2rem;">
                        <td>$ {{ $total_alimentos }} MXN</td>
                        <td>$ {{ $total_traslados }} MXN</td>
                        <td>$ {{ $total_comision }} MXN</td>
                        <td>$ {{ $total_a_retirar }} MXN</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
