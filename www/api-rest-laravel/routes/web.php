<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PruebasController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pruebas/{nombre?}', function ($nombre=null) {
    $texto='<h1>hola mundo</h1>';
    $texto.='Nombre'.$nombre;
    return view('pruebas',array(
        'texto'=> $texto
    ));
});

Route::get('/animales',[PruebasController::class,'index']);

