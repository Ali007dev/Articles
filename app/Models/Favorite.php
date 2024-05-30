<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    const USER_FAVORITEABLE_TYPE_AUTHOR = 'App\\Models\\Author';
    const USER_FAVORITEABLE_TYPE_SUBCATEGORY = 'App\\Models\\SubCategory';
    const USER_FAVORITEABLE_TYPE_SOURCE = 'App\\Models\\Source';
    protected $guarded=[];

    public function favoriteable()
    {
        return $this->morphTo();
    }
    protected $hidden=['created_at','updated_at'];

}
