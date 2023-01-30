<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::included()->filter()->sort()->getOrPaginate();
          //Mandar llamar la forma en la que se mostraran los datos al recuperarlos DE VARIOS REGISTROS
        //return new CategoryResource($category);
        //O tambien puede ser
        return CategoryResource::collection($categories);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|max:255|unique:categories',
        ]);
        $category = Category::create($request->all());
        return CategoryResource::make($category);

    }


    public function show($id)
    {
        /*
        -FindOrFail sirve para buscar un registro, y que de un aviso si falla
        -El metodo with permite buscar alguna relacion de esa variable, por ejemplo, aqui se esta habilidando para poder ver las relaciones de categorias con posts
        -Si son mas de 1 relaciones, se ponen en un arreglo ['relacion1', 'relacion2']
        -En este caso se busacan categorias, y como habilitamos la relacion, salen los posts de esa categoria, pero para saber cual usuario hizo cada post, hay que hacer una 
        relacion anidada, se hace poniendo un punto a la realcion anterior, 'posts.users' no puede ser category.users por que category no tiene ninguna relacion con usuarios
        */
        /* $category = Category::with('posts.user')->findOrFail($id); */


        /* 
        -Para que el usuario traiga las relaciones que el quiera desde la url, se usan las query scope, con las que se pueden modificar las consultas que se hacen
        */
        $category = Category::included()->findOrFail($id);


        //Mandar llamar la forma en la que se mostraran los datos al recuperarlos DE UN SOLO REGISTRO
        //return new CategoryResource($category);
        //O tambien puede ser 
        return CategoryResource::make($category);
    }


    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|max:255|unique:categories,slug,' . $category->id, //no considera el id de este registro para sobreescribirlo
        ]);
        $category->update($request->all());
        return CategoryResource::make($category);

    }


    public function destroy(Category $category)
    {
        $category->delete();
        return CategoryResource::make($category);

    }
}
