<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait ApiTrait
{
    /* Query scope para que el usuario busque por relaciones https://localhost:6000/api/categories/?include=post esto ultimo de inglude */
    public function scopeIncluded(Builder $query) //La variable query me regresa la query que ese esta usando en el controlador, en este caso es findOrFail
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


    public function scopeFilter(Builder $query)
    {

        if (empty($this->allowFilter) || empty(request('filter'))) return;
        $filters = request('filter');
        $allowFilter = collect($this->allowFilter);

        foreach ($filters as $nameFilter => $value) {
            if ($allowFilter->contains($nameFilter)) {
                $query->where($nameFilter, 'LIKE', '%' . $value . '%');
            }
        }
    }

    public function scopeSort(Builder $query)
    {

        if (empty($this->allowedSort) || empty(request('sort'))) return;
        $sortFields = explode(',', request('sort'));
        $allowedSort = collect($this->allowedSort);

        foreach ($sortFields as $field) {
            $direction = 'asc';
            if (substr($field, 0, 1) == '-') {
                $direction = 'desc';
                $field = substr($field, 1);
            }
            if ($allowedSort->contains($field)) {
                $query->orderBy($field, $direction);
            }
        }
    }

    public function scopeGetOrPaginate(Builder $query)
    {

        if (request('perPage')) {
            //Se rescata el valor que hay en la url en perPage="X" y se convierte a entero
            $perPage = intval(request('perPage'));
            if ($perPage) {
                return $query->paginate($perPage);
            }
            //Se tiene que poner el return por que es el final de la consulta, tiene que haber un get
            //en los filtros anteriores no se retorna nada por que simplemente se agregan filtros, y el get
            //se pone al final, en el modelo
        }
        return $query->get();
    }
}
