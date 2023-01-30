<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ApiTrait;
class Post extends Model
{
    use HasFactory;
    use ApiTrait;
    protected $fillable = ['name', 'slug', 'extract', 'body', 'status', 'category_id', 'user_id'];

    const BORRADOR = 1;
    const PUBLICADO = 0;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function images(){
        return $this->morphMany(Image::class, 'imageable');
    }
}
