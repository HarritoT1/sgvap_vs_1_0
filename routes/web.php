<?php

use Illuminate\Support\Facades\Route;
use Phiki\Phast\Root;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CustomerController;

/*Route::get('/', function () {
    return view('welcome');
}); //http://127.0.0.1:8000/*/

Route::get('/ge_nuevo', function () {
    return view('Gestion_empleados/ge_nuevo'); //http://127.0.0.1:8000/ge_nuevo
})->name("empleados.nuevo");

Route::get('/ge_consulta_act_filtro', function () {
    return view('Gestion_empleados/ge_consulta_act_filtro'); //http://127.0.0.1:8000/ge_consulta_act_filtro
})->name("empleados.consulta_filtro");

Route::get('/ge_consulta_act/{id}', function () {
    return view('Gestion_empleados/ge_consulta_act'); //http://127.0.0.1:8000/ge_consulta_act
})->name("empleados.consulta_act");

Route::get('/ge_corte_x_dia', function () {
    return view('Gestion_empleados/ge_corte_x_dia'); //http://127.0.0.1:8000/ge_corte_x_dia
})->name("empleados.corte_x_dia");

Route::get('/ge_retiro_semanal_filtro', function () {
    return view('Gestion_empleados/ge_retiro_semanal_filtro'); //http://127.0.0.1:8000/ge_retiro_semanal_filtro
})->name("empleados.retiro_semanal_filtro");

Route::get('/ge_retiro_semanal/{id}', function () {
    return view('Gestion_empleados/ge_retiro_semanal'); //http://127.0.0.1:8000/ge_retiro_semanal
})->name("empleados.retiro_semanal");

Route::get('/ge_corte_x_mes_filtro', function () {
    return view('Gestion_empleados/ge_corte_x_mes_filtro'); //http://127.0.0.1:8000/ge_corte_x_mes_filtro
})->name("empleados.corte_x_mes_filtro");

Route::get('/ge_consulta_corte_x_año_filtro', function () {
    return view('Gestion_empleados/ge_consulta_corte_x_año_filtro'); //http://127.0.0.1:8000/ge_consulta_corte_x_año_filtro
})->name("empleados.consulta_corte_x_año_filtro");

Route::get('/ge_corte_x_mes/{id}', function () {
    return view('Gestion_empleados/ge_corte_x_mes'); //http://127.0.0.1:8000/ge_corte_x_mes
})->name("empleados.corte_x_mes");

Route::get('/ge_consulta_corte_x_año_especifico/{id}', function () {
    return view('Gestion_empleados/ge_consulta_corte_x_año_especifico'); //http://127.0.0.1:8000/ge_consulta_corte_x_año_especifico
})->name("empleados.consulta_corte_x_año_especifico");

Route::get('/ge_graficas_viaticos', function () {
    return view('Gestion_empleados/ge_graficas_viaticos'); //http://127.0.0.1:8000/ge_graficas_viaticos
})->name("empleados.graficas_viaticos");

Route::get('/ge_graficas_x_viatico', function () {
    return view('Gestion_empleados/ge_graficas_x_viatico'); //http://127.0.0.1:8000/ge_graficas_x_viatico
})->name("empleados.graficas_x_viatico");

Route::get('/gdm_gasolina_alta_dispersion', function () {
    return view('Gestion_dispersiones_monetarias/gdm_gasolina_alta_dispersion'); //http://127.0.0.1:8000/gdm_gasolina_alta_dispersion
})->name("dispersiones.gasolina_alta_dispersion");

Route::get('/gdm_gasolina_disp_consulta_act_filtro', function () {
    return view('Gestion_dispersiones_monetarias/gdm_gasolina_disp_consulta_act_filtro'); //http://127.0.0.1:8000/gdm_gasolina_disp_consulta_act_filtro
})->name("dispersiones.gasolina_disp_consulta_act_filtro");

Route::post('/gasolina_disp_consulta_filtro', function () {
    return response()->json([["id" => 1, "fecha_dispersion" => "2025-12-24", "project_name" => "uetamo", "vehicle_id" => "ASFG-AH4D"], ["id" => 2, "fecha_dispersion" => "2025-12-25", "project_name" => "parajilla", "vehicle_id" => "ZXCW-RT56"], ["id" => 3, "fecha_dispersion" => "2025-12-26", "project_name" => "zacatenco", "vehicle_id" => "QWER-YUI7"]]);
});

Route::get('/gdm_gasolina_disp_consulta_act/{id}', function () {
    return view('Gestion_dispersiones_monetarias/gdm_gasolina_disp_consulta_act'); //http://127.0.0.1:8000/gdm_gasolina_disp_consulta_act
})->name("dispersiones.gasolina_disp_consulta_act")->where('id', '[0-9]+');

Route::get('/gdm_graficas_gasolina', function () {
    return view('Gestion_dispersiones_monetarias/gdm_graficas_gasolina'); //http://127.0.0.1:8000/gdm_graficas_gasolina
})->name("dispersiones.graficas_gasolina");

Route::get('/gdm_caseta_alta_dispersion', function () {
    return view('Gestion_dispersiones_monetarias/gdm_caseta_alta_dispersion'); //http://127.0.0.1:8000/gdm_caseta_alta_dispersion
})->name("dispersiones.caseta_alta_dispersion");

Route::get('/gdm_caseta_disp_consulta_act_filtro', function () {
    return view('Gestion_dispersiones_monetarias/gdm_caseta_disp_consulta_act_filtro'); //http://127.0.0.1:8000/gdm_caseta_disp_consulta_act_filtro
})->name("dispersiones.caseta_disp_consulta_act_filtro");

Route::post('/caseta_disp_consulta_filtro', function () {
    return response()->json([["id" => 1, "fecha_dispersion" => "2025-12-24", "project_name" => "uetamo", "vehicle_id" => "ASFG-AH4D"], ["id" => 2, "fecha_dispersion" => "2025-12-25", "project_name" => "parajilla", "vehicle_id" => "ZXCW-RT56"], ["id" => 3, "fecha_dispersion" => "2025-12-26", "project_name" => "zacatenco", "vehicle_id" => "QWER-YUI7"]]);
});

Route::get('/gdm_caseta_disp_consulta_act/{id}', function () {
    return view('Gestion_dispersiones_monetarias/gdm_caseta_disp_consulta_act'); //http://127.0.0.1:8000/gdm_caseta_disp_consulta_act
})->name("dispersiones.caseta_disp_consulta_act")->where('id', '[0-9]+');

Route::get('/gdm_graficas_caseta', function () {
    return view('Gestion_dispersiones_monetarias/gdm_graficas_caseta'); //http://127.0.0.1:8000/gdm_graficas_caseta
})->name("dispersiones.graficas_caseta");

Route::get('/gdm_hospedaje_alta_dispersion', function () {
    return view('Gestion_dispersiones_monetarias/gdm_hospedaje_alta_dispersion'); //http://127.0.0.1:8000/gdm_hospedaje_alta_dispersion
})->name("dispersiones.hospedaje_alta_dispersion");

Route::get('/gdm_hospedaje_disp_consulta_act_filtro', function () {
    return view('Gestion_dispersiones_monetarias/gdm_hospedaje_disp_consulta_act_filtro'); //http://127.0.0.1:8000/gdm_hospedaje_disp_consulta_act_filtro
})->name("dispersiones.hospedaje_disp_consulta_act_filtro");

Route::post('/hospedaje_disp_consulta_filtro', function () {
    return response()->json([["id" => 1, "fecha_dispersion" => "2025-12-24", "project_name" => "uetamo", "razon_social" => "ASFG-AH4D"], ["id" => 2, "fecha_dispersion" => "2025-12-25", "project_name" => "parajilla", "razon_social" => "ZXCW-RT56"], ["id" => 3, "fecha_dispersion" => "2025-12-26", "project_name" => "zacatenco", "razon_social" => "QWER-YUI7"], ["id" => 1, "fecha_dispersion" => "2025-12-24", "project_name" => "uetamo", "razon_social" => "ASFG-AH4D"], ["id" => 2, "fecha_dispersion" => "2025-12-25", "project_name" => "parajilla", "razon_social" => "ZXCW-RT56"], ["id" => 3, "fecha_dispersion" => "2025-12-26", "project_name" => "zacatenco", "razon_social" => "QWER-YUI7"], ["id" => 1, "fecha_dispersion" => "2025-12-24", "project_name" => "uetamo", "razon_social" => "ASFG-AH4D"], ["id" => 2, "fecha_dispersion" => "2025-12-25", "project_name" => "parajilla", "razon_social" => "ZXCW-RT56"], ["id" => 3, "fecha_dispersion" => "2025-12-26", "project_name" => "zacatenco", "razon_social" => "QWER-YUI7"], ["id" => 1, "fecha_dispersion" => "2025-12-24", "project_name" => "uetamo", "razon_social" => "ASFG-AH4D"], ["id" => 2, "fecha_dispersion" => "2025-12-25", "project_name" => "parajilla", "razon_social" => "ZXCW-RT56"], ["id" => 3, "fecha_dispersion" => "2025-12-26", "project_name" => "zacatenco", "razon_social" => "QWER-YUI7"]]);
});

Route::get('/gdm_hospedaje_disp_consulta_act/{id}', function () {
    return view('Gestion_dispersiones_monetarias/gdm_hospedaje_disp_consulta_act'); //http://127.0.0.1:8000/gdm_hospedaje_disp_consulta_act
})->name("dispersiones.hospedaje_disp_consulta_act")->where('id', '[0-9]+');

Route::get('/gdm_graficas_hospedaje', function () {
    return view('Gestion_dispersiones_monetarias/gdm_graficas_hospedaje'); //http://127.0.0.1:8000/gdm_graficas_hospedaje
})->name("dispersiones.graficas_hospedaje");

Route::get('/gv_registro_vehiculos', function () {
    return view('Gestion_vehiculos/gv_registro_vehiculos'); //http://127.0.0.1:8000/gv_registro_vehiculos
})->name("vehiculos.registro_vehiculos");

Route::get('/gv_consulta_act_filtro', function () {
    return view('Gestion_vehiculos/gv_consulta_act_filtro'); //http://127.0.0.1:8000/gv_consulta_act_filtro
})->name("vehiculos.consulta_act_filtro");

Route::get('/gv_consulta_act/{id}', function () {
    return view('Gestion_vehiculos/gv_consulta_act'); //http://127.0.0.1:8000/gv_consulta_act
})->name("vehiculos.consulta_act");

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

Route::get('/ge_corte_x_dia_delete', function () {
    return view('Gestion_empleados/ge_corte_x_dia_delete'); //http://127.0.0.1:8000/ge_corte_x_dia_delete
})->name("empleados.corte_x_dia_delete");

Route::post('/empleado_corte_x_dia_consulta_filtro', function () {
    return response()->json([["id" => 1, "fecha_dispersion_dia" => "2025-12-24", "employee_name" => "Miguel Angel Mancera", "project_name" => "uetamo"], ["id" => 2, "fecha_dispersion_dia" => "2025-12-25", "employee_name" => "Jose Cruz", "project_name" => "parajilla"], ["id" => 3, "fecha_dispersion_dia" => "2025-12-26", "employee_name" => "Luis Joel", "project_name" => "zacatenco"]]);
});

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

    Route::get('/gc_consulta_act_filtro', function () {
        return view('Gestion_clientes/gc_consulta_act_filtro'); //http://127.0.0.1:8000/gc_consulta_act_filtro
    })->name("clientes.consulta_filtro");

    Route::get('/gc_consulta_act', [CustomerController::class, 'show'])->name("clientes.consulta_act"); //http://127.0.0.1:8000/gc_consulta_act?id=AQGN311928WDF

    /* GESTION PROYECTOS */
    Route::get('/gp_nuevo', function () {
        return view('Gestion_proyectos/gp_nuevo'); //http://127.0.0.1:8000/gp_nuevo
    })->name("proyectos.nuevo");

    Route::get('/gp_consulta_act_filtro', function () {
        return view('Gestion_proyectos/gp_consulta_act_filtro'); //http://127.0.0.1:8000/gp_consulta_act_filtro
    })->name("proyectos.consulta_filtro");

    Route::get('/gp_consulta_act/{id}', function () {
        return view('Gestion_proyectos/gp_consulta_act'); //http://127.0.0.1:8000/gp_consulta_act
    })->name("proyectos.consulta_act");
});
