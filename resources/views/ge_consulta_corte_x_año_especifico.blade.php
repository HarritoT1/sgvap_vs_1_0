@extends('layout')

@section('content')
    <div class="w-100 my-3 div-main">
        <h2 class="fw-bold my-3" style="font-size: 2rem; text-align:justify">Corte anual $anio del empleado $nombre:
        </h2>
        <script>
            let anio_query = 2025;
            let id_query = 2025;
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
                    <tr class="text-center" style="font-size: 1.2rem;">
                        <td>enero</td>
                        <td>2025</td>
                        <td>$ 1,260.00</td>
                        <td>$ 0</td>
                        <td>$ 3,918.90</td>
                        <td>$ 69.45</td>
                        <td>$ 52.58</td>
                        <td>$ 848.15</td>
                    </tr>
                    <tr class="text-center" style="font-size: 1.2rem;">
                        <td>febrero</td>
                        <td>2025</td>
                        <td>$ 1,260.00</td>
                        <td>$ 0</td>
                        <td>$ 3,918.90</td>
                        <td>$ 69.45</td>
                        <td>$ 52.58</td>
                        <td>$ 848.15</td>
                    </tr>
                    <tr class="text-center" style="font-size: 1.2rem;">
                        <td>marzo</td>
                        <td>2025</td>
                        <td>$ 1,260.00</td>
                        <td>$ 0</td>
                        <td>$ 3,918.90</td>
                        <td>$ 69.45</td>
                        <td>$ 52.58</td>
                        <td>$ 848.15</td>
                    </tr>
                    <tr class="text-center" style="font-size: 1.2rem;">
                        <td>abril</td>
                        <td>2025</td>
                        <td>$ 1,260.00</td>
                        <td>$ 0</td>
                        <td>$ 3,918.90</td>
                        <td>$ 69.45</td>
                        <td>$ 52.58</td>
                        <td>$ 848.15</td>
                    </tr>
                    <tr class="text-center" style="font-size: 1.2rem;">
                        <td>mayo</td>
                        <td>2025</td>
                        <td>$ 1,260.00</td>
                        <td>$ 0</td>
                        <td>$ 3,918.90</td>
                        <td>$ 69.45</td>
                        <td>$ 52.58</td>
                        <td>$ 848.15</td>
                    </tr>
                    <tr class="text-center" style="font-size: 1.2rem;">
                        <td>junio</td>
                        <td>2025</td>
                        <td>$ 1,260.00</td>
                        <td>$ 0</td>
                        <td>$ 3,918.90</td>
                        <td>$ 69.45</td>
                        <td>$ 52.58</td>
                        <td>$ 848.15</td>
                    </tr>
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
                    <label class="form-check-label fw-bold text-center" for="include_all_personnel" style="font-size: 0.8rem;">
                        <em>Incluír todo el personal</em>
                    </label>
                </div>
            </div>
            <div style="width: 30%">
                <hr class="w-100" style="border-style: solid; border-width: 3px;">
            </div>
        </div>

        <hr class="my-4 mb-2">
        
        <div id="tables_of_all_personnel" class="d-none"></div>
    </div>
@endsection
