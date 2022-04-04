<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{

    //Middelware laravel 8
    public function __construct()
    {
        $this->middleware('ApiAuthMiddleware', ['except' => ['index', 'show']]);
    }

    public function pruebas(Request $request)
    {

        return "Hola mundo desde el controlador";
    }

    public function index()
    {
        $categories = \DB::table('categories')->get();
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'categories' => $categories
        ], 200);
    }

    //mostrar una unica categoria
    public function show($id)
    {
        $category = \DB::table('categories')->where('id', $id)->first();
        if ($category) {
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'category' => $category
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'status' => 'error',
                'message' => 'La categoria no existe'
            ], 404);
        }
    }

    //save category
    public function store(Request $request)
    {
        $json = $request->input('json', null);
        $params = json_decode($json);
        $params_array = json_decode($json, true);

        if (!empty($params_array)) {
            $validate = \Validator::make($params_array, [
                'name' => 'required|alpha'
            ]);

            if ($validate->fails()) {
                $data = array(
                    'code' => 404,
                    'status' => 'error',
                    'message' => 'La categoria no se ha creado',
                    'category' => $params,
                    'errors' => $validate->errors()
                );
            } else {
                $category = new \App\Models\Category();
                $category->name = $params->name;
                $category->save();

                $data = array(
                    'code' => 200,
                    'status' => 'success',
                    'category' => $category
                );
            }
        } else {
            $data = array(
                'code' => 400,
                'status' => 'error',
                'message' => 'Los datos estan vacios'
            );
        }

        return response()->json($data, $data['code']);
    }

    //update category
    public function update($id, Request $request)
    {

        $json = $request->input('json', null);
        $params = json_decode($json);
        $params_array = json_decode($json, true);

        if (!empty($params_array)) {
            $validate = \Validator::make($params_array, [
                'name' => 'required'
            ]);

            if ($validate->fails()) {
                $data = array(
                    'code' => 404,
                    'status' => 'error',
                    'message' => 'La categoria no se ha actualizado',
                    'category' => $params,
                    'errors' => $validate->errors()
                );
            } else {
                $category = \DB::table('categories')->where('id', $id)->update([
                    'name' => $params->name
                ]);

                $data = array(
                    'code' => 200,
                    'status' => 'success',
                    'category' => $params
                );
            }
        } else {
            $data = array(
                'code' => 400,
                'status' => 'error',
                'message' => 'Los datos estan vacios'
            );
        }

        return response()->json($data, $data['code']);
    }

}
