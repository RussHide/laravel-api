<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    
    public function toArray($request)
    {
        //Permitir campos que se podran ver al recuperar los datos
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            /* Tambien se tienen que agregar las relaciones
            pero se creo un metodo soce included() para avisar de cuando quiero las relaciones
            y esto no lo respeta aqui, asi que tambien hay que decirle que respete y no
            traiga los post cuando no se los pido  'posts' => $this->whenLoaded('posts')
             */
            //Si quiero editar los campos que apareceran en la relacion posts
            'posts' => PostResource::collection($this->whenLoaded('posts'))
           
        ];
    }
}
