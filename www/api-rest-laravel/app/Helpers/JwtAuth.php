<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class JwtAuth{

    //buscar usuario por contraseña 
    public static function signup($email,$password,$getToken = null){

        $user=User::where([
            'email'=>$email,
            'password'=>$password
        ])->first();
        if(is_object($user)){
            //crear token
            $token=JWT::encode(
                [
                    'sub'=>$user->id,
                    'email'=>$user->email,
                    'name'=>$user->name,
                    'surname'=>$user->surname,
                    'iat'=>time(),
                    'exp'=>time()+7200
                ],
                'clave-secreta',
                'HS256'
            );

            //decodificar token
            $decoded = JWT::decode($token, new Key('clave-secreta', 'HS256'));
            
            if (is_null($getToken)) {
                 $data=$token;
            }else{
                $data=$decoded;            
            }
            
        }else{
            $data = array(
                'status' => 'error',
                'code' => 404,
                'message' => 'El usuario no se ha podido identificar',
                'email' => $email,
                'password' => $password
            );
        }
    
        return $data;
    }

    //comprobar token
    public static function checkToken($jwt,$getIdentity = false){
        $auth=false;
        try{
            $decoded = JWT::decode($jwt, new Key('clave-secreta', 'HS256'));
        }catch(\UnexpectedValueException $e){
            $auth=false;
        }catch(\DomainException $e){
            $auth=false;
        }

        if(!empty($decoded) && is_object($decoded) && isset($decoded->sub)){
            $auth=true;
        }else{
            $auth=false;
        }

        if($getIdentity){
            return $decoded;
        }else{
            return $auth;
        }
    }

}

