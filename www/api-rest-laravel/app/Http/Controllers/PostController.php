<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function pruebas(Request $request){

        return "Hola mundo desde el controlador";
        }
}
