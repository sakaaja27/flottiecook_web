<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecipeCategory extends Model
{
    protected $table = 'recipes_category';

    protected $fillable = [
        'id',
        'name',
        'image'
    ];

    protected $guarded = ['id'];
}
