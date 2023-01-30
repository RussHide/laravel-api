<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ApiTrait;


class Category extends Model
{
    use HasFactory;
    use ApiTrait;
    
    protected $fillable = [
        'name',
        'slug'
    ];

    //Relaciones permitidas
    protected $allowIncluded = ['posts', 'posts.user'];
    protected $allowFilter = ['id', 'name', 'slug'];
    protected $allowedSort = ['id', 'name'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }


}
