<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/inicio', function () {
    return view('inicio');
});

Route::get('/contacto', function () {
    return view('contacto');
});

Route::get('/gp_nuevo', function () {
    return view('gp_nuevo');
});

Route::get('/gp_consulta_act_filtro', function () {
    return view('gp_consulta_act_filtro');
});

Route::get('/gp_consulta_act', function () {
    return view('gp_consulta_act');
});

Route::get('/ge_nuevo', function () {
    return view('ge_nuevo');
});

