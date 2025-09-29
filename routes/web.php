<?php

use Illuminate\Support\Facades\Route;

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


