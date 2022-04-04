<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PruebasController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Middleware\ApiAuthMiddleware;
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
Route::get('/test-orm',[PruebasController::class,'textOrm']);

//rutas del api
Route::get('/usuario/pruebas',[UserController::class,'pruebas']);
Route::post('/api/register',[UserController::class,'register']);
Route::post('/api/login',[UserController::class,'login']);
Route::put('/api/user/update',[UserController::class,'update']);
Route::post('/api/user/upload',[UserController::class,'upload'])->middleware(\ApiAuthMiddleware::class);
Route::get('/api/user/avatar/{filename}',[UserController::class,'getImage']);
Route::get('/api/user/detail/{id}',[UserController::class,'detail']);

//Categorias
Route::resource('/api/category', CategoryController::class);
//Route::put('/api/category/{id}',[CategoryController::class,'update']);

//Rutas controlador post
Route::resource('/api/post', PostController::class);
Route::post('/api/post/upload',[PostController::class,'upload']);
Route::get('/api/post/imagen/{filename}',[PostController::class,'getImage']);
Route::get('/api/post/category/{id}',[PostController::class,'getPostsByCategory']);
Route::get('/api/post/user/{id}',[PostController::class,'getPostsByUser']);


