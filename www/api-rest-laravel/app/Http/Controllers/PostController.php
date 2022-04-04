<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Post;

class PostController extends Controller
{

    //middleware aut
    public function __construct()
    {
        $this->middleware('ApiAuthMiddleware', ['except' => ['index', 'show','getPostsByCategory','getPostsByUser']]);
    }

    public function pruebas(Request $request){

        return "Hola mundo desde el controlador";
    }

    //devolver posts con modelo
    public function index()
    {
        $posts = Post::all()->load('category');
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'posts' => $posts
        ], 200);
    }
  
    
      //devover todos los posts con categorias
    // public function index()
    // {
    //     $posts = \DB::table('posts')
    //         ->join('categories', 'posts.category_id', '=', 'categories.id')
    //         ->select('posts.id', 'posts.title', 'posts.image', 'posts.created_at', 'categories.name as category')
    //         ->orderBy('posts.id', 'desc')
    //         ->get();

    //     return response()->json([
    //         'code' => 200,
    //         'status' => 'success',
    //         'posts' => $posts
    //     ], 200);
    // }
    

    //Show unico post
    public function show($id)
    {
        $post = Post::find($id);
        if ($post) {
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'post' => $post
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'status' => 'error',
                'message' => 'El post no existe'
            ], 404);
        }
    }

    //guardar post
    public function store(Request $request)
    {
        $json = $request->input('json', null);
        $params = json_decode($json);

        $params_array = json_decode($json, true);

        if (!empty($params_array)) {

            $jwtAuth = new \JwtAuth();
            $token = $request->header('Authorization', null);
            $user = $jwtAuth->checkToken($token, true);

            $validate = \Validator::make($params_array, [
                'title' => 'required',
                'content' => 'required',
                'category_id' => 'required',
                'image' => 'required'
            ]);

            if ($validate->fails()) {
                $data = array(
                    'code' => 404,
                    'status' => 'error',
                    'message' => 'El post no se ha creado',
                    'post' => $params,
                    'errors' => $validate->errors()
                );
            } else {
                $post = new Post();          
                $post->user_id = $user->sub; 
                $post->title = $params->title;
                $post->content = $params->content;
                $post->category_id = $params->category_id;
                $post->image = $params->image;
                $post->content = $params->content;

                $post->save();

                $data = array(
                    'code' => 200,
                    'status' => 'success',
                    'post' => $post
                );
            }
        } else {
            $data = array(
                'code' => 404,
                'status' => 'error',
                'message' => 'Los datos enviados no son correctos'
            );
        }

        return response()->json($data, $data['code']);
    }

    //actualizar post
    public function update($id, Request $request)
    {
        $json = $request->input('json', null);
        $params_array = json_decode($json, true);
        $jwtAuth = new \JwtAuth();
        $token = $request->header('Authorization', null);
        $user = $jwtAuth->checkToken($token, true);
        $params_array['user_id'] = $user->sub;

        if (!empty($params_array)) {

            $validate = \Validator::make($params_array, [
                'title' => 'required',
                'content' => 'required',
                'category_id' => 'required',
                // 'image' => 'required'
            ]);


            if ($validate->fails()) {
                $data = array(
                    'code' => 404,
                    'status' => 'error',
                    'message' => 'El post no se ha actualizado',
                    'errors' => $validate->errors()
                );
            } else {

                unset($params_array['id']);
                // unset($params_array['user_id']);
                unset($params_array['created_at']);
                unset($params_array['updated_at']); 

                //actualizar el post
                //  $post = Post::where('id', $id)->updateOrCreate($params_array);
                 $post = Post::updateOrCreate(['id' => $id], $params_array);
                //$post = Post::updateOrCreate(['id' => $id], $params_array);

                $data = array(
                    'code' => 200,
                    'status' => 'success',
                    'changes' => $params_array
                );
            }
        } else {
            $data = array(
                'code' => 404,
                'status' => 'error',
                'message' => 'Los datos enviados no son correctos'
            );
        }

        return response()->json($data, $data['code']);
    }

    //eliminar post
    public function destroy($id, Request $request)
    {
        $jwtAuth = new \JwtAuth();
        $token = $request->header('Authorization', null);
        // $user = $jwtAuth->checkToken($token, true);

        $user = $this->getUser($request);

        $post = Post::find($id);

        if ($post && $post->user_id == $user->sub) {
            $post->delete();
            $data = array(
                'code' => 200,
                'status' => 'success',
                'post' => $post
            );
        } else {
            $data = array(
                'code' => 404,
                'status' => 'error',
                'message' => 'El post no se ha eliminado'
            );
        }

        return response()->json($data, $data['code']);
    }

    //upload image
    public function upload(Request $request)
    {
        $image = $request->file('file0');
        $validate = \Validator::make($request->all(), [
            'file0' => 'required|image|mimes:jpg,jpeg,png,gif'
        ]);

        if (!$image || $validate->fails()) {
            $data = array(
                'code' => 404,
                'status' => 'error',
                'message' => 'Error al subir la imagen'
            );
        } else {
            $image_name = time() . $image->getClientOriginalName();
            \Storage::disk('images')->put($image_name, \File::get($image));
            $data = array(
                'code' => 200,
                'status' => 'success',
                'image' => $image_name
            );
        }

        return response()->json($data, $data['code']);
    }

    private function getUser(Request $request)
    {
        $jwt = new \JwtAuth;
        $token = $request->header('Authorization');
        $user = $jwt->checkToken($token, true);
 
        return $user;
    }

    //obtener imagen
    public function getImage($filename)
    {
        $isset = \Storage::disk('images')->exists($filename);

        if ($isset) {
            $file = \Storage::disk('images')->get($filename);
            return new Response($file, 200);
        } else {
            $data = array(
                'code' => 404,
                'status' => 'error',
                'message' => 'La imagen no existe'
            );
        }

        return response()->json($data, $data['code']);
    }

    //listar posts por categoria 
    public function getPostsByCategory($id)
    {
        $posts = Post::where([
            'category_id' => $id,
        ])->get();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'posts' => $posts
        ], 200);
    }

    //listar posts por usuario
    public function getPostsByUser($idUser)
    {
        $posts = Post::where([
            'user_id' => $idUser,
        ])->get();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'posts' => $posts
        ], 200);
    }

}
