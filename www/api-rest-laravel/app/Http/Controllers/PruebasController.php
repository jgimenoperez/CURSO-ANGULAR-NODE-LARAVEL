<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;


class PruebasController extends Controller
{
    public function index(){
        
        $titulo='Animales';
        $animales=['Perro','Gato','Tigre'];

        return view('pruebas.index',array(
            'titulo' => $titulo,
            'animales' => $animales
        ));
    }

    public function textOrm(){
        $posts=Post::all();
        
        // var_dump(111);

        $categories=Category::all();
        foreach($categories as $category){
            echo "<h1>".$category->name."</h1>";

            foreach($category->posts as $post){
                echo "<h1>".$post->title."</h1>";
                echo "<span style='color:red;'>".$post->user->name."</span>";
                echo "<br/>";
                echo $post->content;
                echo "<hr/>";
            }

            echo "<span style='color:red;'>".$category->description."</span>";
            echo "<br/>";
            echo $category->long_description;
            echo "<hr/>";
        }

        die();
    }

}
