<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $guarded=[];
    use HasFactory;

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoriteable');
    }
}
