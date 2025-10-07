<?php

use Illuminate\Support\Facades\Route;
use Phiki\Phast\Root;

Route::get('/', function () {
    return view('welcome');
}); //http://127.0.0.1:8000/

Route::get('/login', function () {
    return view('login'); //http://127.0.0.1:8000/login
});

Route::get('/inicio', function () {
    return view('inicio'); //http://127.0.0.1:8000/inicio
});

Route::get('/contacto', function () {
    return view('contacto'); //http://127.0.0.1:8000/contacto
});

Route::get('/gp_nuevo', function () {
    return view('gp_nuevo'); //http://127.0.0.1:8000/gp_nuevo
});

Route::get('/gp_consulta_act_filtro', function () {
    return view('gp_consulta_act_filtro'); //http://127.0.0.1:8000/gp_consulta_act_filtro
});

Route::get('/gp_consulta_act', function () {
    return view('gp_consulta_act'); //http://127.0.0.1:8000/gp_consulta_act
});

Route::get('/ge_nuevo', function () {
    return view('ge_nuevo'); //http://127.0.0.1:8000/ge_nuevo
});

Route::get('/ge_consulta_act_filtro', function () {
    return view('ge_consulta_act_filtro'); //http://127.0.0.1:8000/ge_consulta_act_filtro
});

Route::get('/ge_consulta_act', function () {
    return view('ge_consulta_act'); //http://127.0.0.1:8000/ge_consulta_act
});

Route::get('/ge_corte_x_dia', function () {
    return view('ge_corte_x_dia'); //http://127.0.0.1:8000/ge_corte_x_dia
});

Route::get('/ge_retiro_semanal_filtro', function () {
    return view('ge_retiro_semanal_filtro'); //http://127.0.0.1:8000/ge_retiro_semanal_filtro
});

Route::get('/ge_retiro_semanal', function () {
    return view('ge_retiro_semanal'); //http://127.0.0.1:8000/ge_retiro_semanal
});

Route::get('/ge_corte_x_mes_filtro', function () {
    return view('ge_corte_x_mes_filtro'); //http://127.0.0.1:8000/ge_corte_x_mes_filtro
});

Route::get('/ge_consulta_corte_x_año_filtro', function () {
    return view('ge_consulta_corte_x_año_filtro'); //http://127.0.0.1:8000/ge_consulta_corte_x_año_filtro
});

Route::get('/ge_corte_x_mes', function () {
    return view('ge_corte_x_mes'); //http://127.0.0.1:8000/ge_corte_x_mes
});

Route::get('/ge_consulta_corte_x_año_especifico', function () {
    return view('ge_consulta_corte_x_año_especifico'); //http://127.0.0.1:8000/ge_consulta_corte_x_año_especifico
});

Route::get('/ge_graficas_viaticos', function () {
    return view('ge_graficas_viaticos'); //http://127.0.0.1:8000/ge_graficas_viaticos
});

Route::get('/ge_graficas_x_viatico', function () {
    return view('ge_graficas_x_viatico'); //http://127.0.0.1:8000/ge_graficas_x_viatico
});

Route::get('/gdm_gasolina_alta_dispersion', function () {
    return view('gdm_gasolina_alta_dispersion'); //http://127.0.0.1:8000/gdm_gasolina_alta_dispersion
});


Route::get('/gdm_gasolina_disp_consulta_act_filtro', function () {
    return view('gdm_gasolina_disp_consulta_act_filtro'); //http://127.0.0.1:8000/gdm_gasolina_disp_consulta_act_filtro
});

Route::post('/gasolina_disp_consulta_filtro', function () {
    return response()->json([["id" => 1, "fecha_dispersion" => "2025-12-24", "project_name" => "uetamo", "vehicle_id" => "ASFG-AH4D"], ["id" => 2, "fecha_dispersion" => "2025-12-25", "project_name" => "parajilla", "vehicle_id" => "ZXCW-RT56"], ["id" => 3, "fecha_dispersion" => "2025-12-26", "project_name" => "zacatenco", "vehicle_id" => "QWER-YUI7"]]);
});

Route::get('/gdm_gasolina_disp_consulta_act', function () {
    return view('gdm_gasolina_disp_consulta_act'); //http://127.0.0.1:8000/gdm_gasolina_disp_consulta_act
});

Route::get('/gdm_graficas_gasolina', function () {
    return view('gdm_graficas_gasolina'); //http://127.0.0.1:8000/gdm_graficas_gasolina
});

Route::get('/gdm_caseta_alta_dispersion', function () {
    return view('gdm_caseta_alta_dispersion'); //http://127.0.0.1:8000/gdm_caseta_alta_dispersion
});

Route::get('/gdm_caseta_disp_consulta_act_filtro', function () {
    return view('gdm_caseta_disp_consulta_act_filtro'); //http://127.0.0.1:8000/gdm_caseta_disp_consulta_act_filtro
});

Route::post('/caseta_disp_consulta_filtro', function () {
    return response()->json([["id" => 1, "fecha_dispersion" => "2025-12-24", "project_name" => "uetamo", "vehicle_id" => "ASFG-AH4D"], ["id" => 2, "fecha_dispersion" => "2025-12-25", "project_name" => "parajilla", "vehicle_id" => "ZXCW-RT56"], ["id" => 3, "fecha_dispersion" => "2025-12-26", "project_name" => "zacatenco", "vehicle_id" => "QWER-YUI7"]]);
});

Route::get('/gdm_caseta_disp_consulta_act', function () {
    return view('gdm_caseta_disp_consulta_act'); //http://127.0.0.1:8000/gdm_caseta_disp_consulta_act
});

Route::get('/gdm_graficas_caseta', function () {
    return view('gdm_graficas_caseta'); //http://127.0.0.1:8000/gdm_graficas_caseta
});