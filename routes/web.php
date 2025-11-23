<?php

use Illuminate\Support\Facades\Route;
use Phiki\Phast\Root;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DailyExpenseReportController;
use App\Http\Controllers\MonthlyExpenseCutController;
use App\Http\Controllers\ReporteViaticosController;
use App\Http\Controllers\GasolineDispersionController;
use App\Http\Controllers\TagDispersionController;
use App\Http\Controllers\LodgingDispersionController;
use App\Http\Controllers\VehicleController;
use App\Models\Customer;
use App\Models\DailyExpenseReport;
use App\Models\Employee;
use App\Models\Vehicle;

/*Route::get('/', function () {
    return view('welcome');
}); //http://127.0.0.1:8000/*/

Route::get('/gv_registro_prestamos', function () {
    return view('Gestion_vehiculos/gv_registro_prestamos'); //http://127.0.0.1:8000/gv_registro_prestamos
})->name("vehiculos.registro_prestamos");

Route::get('/gv_consulta_act_prestamos_filtro', function () {
    return view('Gestion_vehiculos/gv_consulta_act_prestamos_filtro'); //http://127.0.0.1:8000/gv_consulta_act_prestamos_filtro
})->name("vehiculos.consulta_act_prestamos_filtro");

Route::post('/prestamo_consulta_filtro', function () {
    return response()->json([["id" => 1, "fecha_prestamo" => "2025-12-24", "employee_name" => "Miguel Angel Mancera", "vehicle_id" => "ASFG-AH4D"], ["id" => 2, "fecha_prestamo" => "2025-12-25", "employee_name" => "Jose Cruz", "vehicle_id" => "AFGG-AH4B"], ["id" => 3, "fecha_prestamo" => "2025-12-26", "employee_name" => "Luis Joel", "vehicle_id" => "AHIG-AH4A"], ["id" => 4, "fecha_prestamo" => "2025-12-27", "employee_name" => "Victor Manuel", "vehicle_id" => "AJKG-AH4C"]]);
})->name("vehiculos.prestamo_consulta_filtro");

Route::get('/gv_consulta_act_prestamos/{id}', function () {
    return view('Gestion_vehiculos/gv_consulta_act_prestamos'); //http://127.0.0.1:8000/gv_consulta_act_prestamos
})->name("vehiculos.consulta_act_prestamos")->where('id', '[0-9]+');

// CONTROLADORES FINALES (PRODUCCION).
Route::get('/', function () {
    return view('Login_inicio_soporte/login'); //http://127.0.0.1:8000
})->name("login.index");

Route::post('/login', [LoginController::class, 'login'])->name('login.perform');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout.perform');

Route::middleware(['auth', 'inactive'])->group(function () {
    /* LOGIN INICIO SOPORTE */
    Route::get('/inicio', function () {
        return view('Login_inicio_soporte/inicio'); //http://127.0.0.1:8000/inicio
    })->name("inicio.index");

    Route::get('/contacto', function () {
        return view('Login_inicio_soporte/contacto'); //http://127.0.0.1:8000/contacto
    })->name("contacto.index");

    /* GESTION CLIENTES */

    Route::get('/gc_nuevo', function () {
        return view('Gestion_clientes/gc_nuevo'); //http://127.0.0.1:8000/gc_nuevo
    })->name("clientes.nuevo");

    Route::post('/customer_create', [CustomerController::class, 'create'])->name('clientes.create');

    Route::get('/gc_consulta_act_filtro', function () {
        return view('Gestion_clientes/gc_consulta_act_filtro'); //http://127.0.0.1:8000/gc_consulta_act_filtro
    })->name("clientes.consulta_filtro");

    Route::get('/gc_consulta_act', [CustomerController::class, 'show'])->middleware('sanitize')->name("clientes.consulta_act"); //http://127.0.0.1:8000/gc_consulta_act?id=AQGN311928WDF

    Route::put('/customer_update', [CustomerController::class, 'update'])->name('clientes.update');

    Route::get('/clientes/buscar-rfc', [CustomerController::class, 'buscarRFC'])->name('clientes.buscar_rfc');

    /* GESTION PROYECTOS */

    Route::get('/gp_nuevo', function () {
        return view('Gestion_proyectos/gp_nuevo', ['customers' => Customer::all()]); //http://127.0.0.1:8000/gp_nuevo
    })->name("projects.nuevo");

    Route::post('/project_create', [ProjectController::class, 'create'])->name('projects.create');

    Route::get('/gp_consulta_act_filtro', function () {
        return view('Gestion_proyectos/gp_consulta_act_filtro'); //http://127.0.0.1:8000/gp_consulta_act_filtro
    })->name("projects.consulta_filtro");

    Route::get('/gp_consulta_act', [ProjectController::class, 'show'])->middleware('sanitize')->name("projects.consulta_act"); //http://127.0.0.1:8000/gp_consulta_act?id=PRJ-0042-TXI

    Route::put('/project_update', [ProjectController::class, 'update'])->name('projects.update');

    Route::get('/projects/buscar-id', [ProjectController::class, 'buscarID'])->name('projects.buscar_id');

    /* GESTION EMPLEADOS */

    Route::get('/ge_nuevo', function () {
        return view('Gestion_empleados/ge_nuevo'); //http://127.0.0.1:8000/ge_nuevo
    })->name("empleados.nuevo");

    Route::post('/employee_create', [EmployeeController::class, 'create'])->name('empleados.create');

    Route::get('/ge_consulta_act_filtro', function () {
        return view('Gestion_empleados/ge_consulta_act_filtro'); //http://127.0.0.1:8000/ge_consulta_act_filtro
    })->name("empleados.consulta_filtro");

    Route::get('/ge_consulta_act', [EmployeeController::class, 'show'])->middleware('sanitize')->name("empleados.consulta_act"); //http://127.0.0.1:8000/ge_consulta_act?id=EMP-0001-MNB

    Route::put('/empleado_update', [EmployeeController::class, 'update'])->name('empleados.update');

    Route::get('/empleados/buscar-rfc', [EmployeeController::class, 'buscarRFC'])->name('empleados.buscar_rfc');

    Route::get('/ge_corte_x_dia', function () {
        return view('Gestion_empleados/ge_corte_x_dia'); //http://127.0.0.1:8000/ge_corte_x_dia
    })->name("empleados.corte_x_dia");

    Route::post('/validar_form_generator', [DailyExpenseReportController::class, 'possible_generate_form'])->name('empleados.validar_form_generator');

    Route::get('/ask_info_about_project', [DailyExpenseReportController::class, 'ask_info_about_project'])->name('empleados.ask_info_about_project');

    Route::post('/daily_create', [DailyExpenseReportController::class, 'create'])->name('dailys.create');

    Route::get('/ge_corte_x_dia_delete', function () {
        return view('Gestion_empleados/ge_corte_x_dia_delete'); //http://127.0.0.1:8000/ge_corte_x_dia_delete
    })->name("empleados.corte_x_dia_delete");

    Route::post('/empleado_corte_x_dia_consulta_filtro', [DailyExpenseReportController::class, 'find'])->name('dailys.find');

    Route::delete('/ge_corte_x_dia_destroy/{id}', [DailyExpenseReportController::class, 'destroy'])->name('dailys.destroy')->where('id', '[0-9]+');

    Route::get('/ge_retiro_semanal_filtro', function () {
        return view('Gestion_empleados/ge_retiro_semanal_filtro'); //http://127.0.0.1:8000/ge_retiro_semanal_filtro
    })->name("empleados.retiro_semanal_filtro");

    Route::get('/ge_retiro_semanal_find', [DailyExpenseReportController::class, 'find_semanal'])->name('dailys.find_semanal');

    Route::get('/ge_corte_x_mes_filtro', function () {
        return view('Gestion_empleados/ge_corte_x_mes_filtro'); //http://127.0.0.1:8000/ge_corte_x_mes_filtro
    })->name("empleados.corte_x_mes_filtro");

    Route::post('/generate_data_for_corte_mensual', [MonthlyExpenseCutController::class, 'generate_data_for_corte_mensual'])->name('monthlys.generate_data_for_corte_mensual');

    Route::get('/ge_corte_x_mes', [MonthlyExpenseCutController::class, 'show_monthly_cut'])->name("empleados.corte_x_mes"); //http://127.0.0.1:8000/ge_corte_x_mes?employee=FVV431303686&mes=3&mesName=MARZO&anio=2001&total_alimentos_mes=1200&total_traslado_local_mes=600&total_traslado_externo_mes=0&total_comision_bancaria_mes=800

    Route::post('/monthly_create', [MonthlyExpenseCutController::class, 'create'])->name('monthlys.create');

    Route::get('/ge_consulta_corte_x_año_filtro', function () {
        return view('Gestion_empleados/ge_consulta_corte_x_año_filtro'); //http://127.0.0.1:8000/ge_consulta_corte_x_año_filtro
    })->name("empleados.consulta_corte_x_año_filtro");

    Route::get('/ge_consulta_corte_x_año_especifico', [MonthlyExpenseCutController::class, 'show_year_cuts'])->name("empleados.consulta_corte_x_año_especifico");

    Route::get('/allpersonneltables', [MonthlyExpenseCutController::class, 'generate_data_for_all_personnel'])->name("monthlys.allpersonneltables");

    Route::get('/ge_graficas_viaticos', [ReporteViaticosController::class, 'barras'])->name("empleados.graficas_viaticos"); //http://127.0.0.1:8000/ge_graficas_viaticos

    Route::get('/ge_graficas_x_viatico', [ReporteViaticosController::class, 'pasteles'])->name("empleados.graficas_x_viatico");

    /* GESTION DISPERSIONES MONETARIAS */

    Route::get('/gdm_gasolina_alta_dispersion', function () {
        return view('Gestion_dispersiones_monetarias/gdm_gasolina_alta_dispersion', ['vehicles' => Vehicle::all()]); //http://127.0.0.1:8000/gdm_gasolina_alta_dispersion
    })->name("dispersiones.gasolina_alta_dispersion");

    Route::post('/gasoline_create', [GasolineDispersionController::class, 'storeOne'])->name('gasoline.create');

    Route::post('/gdm_gasolina_auto_alta_xls', [GasolineDispersionController::class, 'storeMany'])->name('gasoline.createMany');

    Route::get('/gdm_gasolina_disp_consulta_act/{dispersion}', [GasolineDispersionController::class, 'show'])->name("dispersiones.gasolina_disp_consulta_act")->where('dispersion', '[0-9]+'); //http://127.0.0.1:8000/gdm_gasolina_disp_consulta_act/1

    Route::put('/gasoline_update', [GasolineDispersionController::class, 'update'])->name('gasoline.update');

    Route::get('/gdm_gasolina_disp_consulta_act_filtro', function () {
        return view('Gestion_dispersiones_monetarias/gdm_gasolina_disp_consulta_act_filtro', ['vehicles' => Vehicle::all()]); //http://127.0.0.1:8000/gdm_gasolina_disp_consulta_act_filtro
    })->name("dispersiones.gasolina_disp_consulta_act_filtro");

    Route::post('/gasolina_disp_consulta_filtro', [GasolineDispersionController::class, 'find'])->name('gasoline.find');

    Route::delete('/gasolina_destroy/{dispersion}', [GasolineDispersionController::class, 'destroy'])->name('gasoline.destroy')->where('dispersion', '[0-9]+');

    Route::get('/gdm_caseta_alta_dispersion', function () {
        return view('Gestion_dispersiones_monetarias/gdm_caseta_alta_dispersion', ['vehicles' => Vehicle::all()]); //http://127.0.0.1:8000/gdm_caseta_alta_dispersion
    })->name("dispersiones.caseta_alta_dispersion");

    Route::post('/tag_create', [TagDispersionController::class, 'storeOne'])->name('tag.create');

    Route::post('/gdm_tag_auto_alta_xls', [TagDispersionController::class, 'storeMany'])->name('tag.createMany');

    Route::get('/gdm_caseta_disp_consulta_act/{dispersion}', [TagDispersionController::class, 'show'])->name("dispersiones.caseta_disp_consulta_act")->where('dispersion', '[0-9]+');

    Route::put('/tag_update', [TagDispersionController::class, 'update'])->name('tag.update');

    Route::get('/gdm_caseta_disp_consulta_act_filtro', function () {
        return view('Gestion_dispersiones_monetarias/gdm_caseta_disp_consulta_act_filtro', ['vehicles' => Vehicle::all()]); //http://127.0.0.1:8000/gdm_caseta_disp_consulta_act_filtro
    })->name("dispersiones.caseta_disp_consulta_act_filtro");

    Route::post('/caseta_disp_consulta_filtro', [TagDispersionController::class, 'find'])->name('tag.find');

    Route::delete('/caseta_destroy/{dispersion}', [TagDispersionController::class, 'destroy'])->name('tag.destroy')->where('dispersion', '[0-9]+');

    Route::get('/gdm_hospedaje_alta_dispersion', function () {
        return view('Gestion_dispersiones_monetarias/gdm_hospedaje_alta_dispersion'); //http://127.0.0.1:8000/gdm_hospedaje_alta_dispersion
    })->name("dispersiones.hospedaje_alta_dispersion");

    Route::post('/lodging_create', [LodgingDispersionController::class, 'storeOne'])->name('lodging.create');

    Route::post('/gdm_lodging_auto_alta_xls', [LodgingDispersionController::class, 'storeMany'])->name('lodging.createMany');

    Route::get('/gdm_hospedaje_disp_consulta_act/{dispersion}', [LodgingDispersionController::class, 'show'])->name("dispersiones.lodging_disp_consulta_act")->where('dispersion', '[0-9]+');

    Route::put('/lodging_update', [LodgingDispersionController::class, 'update'])->name('lodging.update');

    Route::get('/gdm_hospedaje_disp_consulta_act_filtro', function () {
        return view('Gestion_dispersiones_monetarias/gdm_hospedaje_disp_consulta_act_filtro');
    })->name("dispersiones.hospedaje_disp_consulta_act_filtro");

    Route::post('/hospedaje_disp_consulta_filtro', [LodgingDispersionController::class, 'find'])->name('lodging.find');

    Route::delete('/hospedaje_destroy/{dispersion}', [LodgingDispersionController::class, 'destroy'])->name('lodging.destroy')->where('dispersion', '[0-9]+');

    Route::get('/lodgings/buscar-rfc', [LodgingDispersionController::class, 'buscarRFCHospedaje'])->name('lodgings.buscar_rfc_hospedaje');

    Route::get('/gdm_graficas_gasolina', [ReporteViaticosController::class, 'barras_gasolina'])->name("dispersiones.graficas_gasolina"); //http://127.0.0.1:8000/gdm_graficas_gasolina

    Route::get('/gdm_graficas_caseta', [ReporteViaticosController::class, 'barras_caseta'])->name("dispersiones.graficas_caseta"); //http://127.0.0.1:8000/gdm_graficas_caseta

    Route::get('/gdm_graficas_hospedaje', [ReporteViaticosController::class, 'barras_hospedaje'])->name("dispersiones.graficas_hospedaje"); //http://127.0.0.1:8000/gdm_graficas_hospedaje

    /* GESTION VEHÍCULAR */

    Route::get('/gv_registro_vehiculos', function () {
        return view('Gestion_vehiculos/gv_registro_vehiculos'); //http://127.0.0.1:8000/gv_registro_vehiculos
    })->name("vehiculos.registro_vehiculos");

    Route::post('/vehicle_create', [VehicleController::class, 'create'])->name('vehicles.create');

    Route::get('/gv_consulta_act_filtro', function () {
        return view('Gestion_vehiculos/gv_consulta_act_filtro')->with(['vehicles' => Vehicle::all()]); //http://127.0.0.1:8000/gv_consulta_act_filtro
    })->name("vehiculos.consulta_act_filtro");

    Route::get('/gv_consulta_act', [VehicleController::class, 'show'])->name("vehiculos.consulta_act"); //http://127.0.0.1:8000/gv_consulta_act?id=ABC-DFA

    Route::put('/vehicle_update', [VehicleController::class, 'update'])->name('vehicles.update');
});
