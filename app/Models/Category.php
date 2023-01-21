<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug'
    ];

    //Relaciones permitidas
    protected $allowIncluded = ['posts', 'posts.user'];


    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /* Query scope para que el usuario busque por relaciones https://localhost:6000/api/categories/?include=post esto ultimo de inglude */
    public function scopeIncluded(Builder $query)//La variable query me regresa la query que ese esta usando en el controlador, en este caso es findOrFail
    {
        if (empty($this->allowIncluded) || empty(request('included'))) return; //Verifica que si este la variable included con el request
        $relations = explode(',', request('included')); //Aqui se reciben los parametros que se mandand ?include=posts.user y se separan por comas con explode
        $allowIncluded = collect($this->allowIncluded); //Convierte el arreglo en una coleccion para poder usar el metodo contains
        foreach ($relations as $key => $relation) {
            if (!$allowIncluded->contains($relation)) {
                unset($relations[$key]);
            }
        }
        $query->with($relations);
    }
}
