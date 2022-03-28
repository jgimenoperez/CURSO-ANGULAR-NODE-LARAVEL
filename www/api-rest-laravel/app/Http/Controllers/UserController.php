<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function pruebas(Request $request){
        return "Hola mundo desde el controlador";
    }

    public function register(Request $request){

        //recoger datos
        $json=$request->input('json',null);
        $params=json_decode($json);
        $params_array=json_decode($json,true);

        //limpiar datos
        $params_array=array_map('trim',$params_array);

        //data is empty
        if(empty($params_array)){
            $data=array(
                'status'=>'error',
                'code'=>400,
                'message'=>'Los datos estan vacios'
            );
        }

        // var_dump($params);

        //validate data
        $validate=\Validator::make($params_array,[
            'name'=>'required|alpha',
            'surname'=>'required|alpha',
            'email'=>'required|email|unique:users',
            'password'=>'required'
        ]);

        if($validate->fails()){
            
            $data= array(
                'code' => 404,
                'status' => 'error',
                'message' => 'El usuario no se ha creado',
                'usuario' => $params_array,
                'errors' => $validate->errors()
            );

        }else{
            //cifrar la contraseña
            // $pwd=hash('sha256',$params->password);
            $pwd=password_hash($params->password,PASSWORD_BCRYPT,['cost'=>4]);

            //comproabar si el usuario existe
            // $user=\App\User::where('email',$params_array['email'])->first();

            // //crear el usuario
            $user=new User();
            $user->name=$params_array['name'];
            $user->surname=$params_array['surname'];
            $user->email=$params_array['email'];
            $user->role='ROLE_USER';
            $user->password=$pwd;
            $user->save();

            $data= array(
                'code' => 200,
                'status' => 'success',
                'message' => 'El usuario se ha creado correctamente',
                // 'usuario' => $user
            );}
                
         return response()->json($data,400);


        $datos = [
            'nombre' => $request->input('nombre'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password'))
        ];


        // return $datos;
    }

    public function login(Request $request){
        return "Login user";
    }
}
