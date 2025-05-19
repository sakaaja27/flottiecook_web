<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Recipt extends Model
{
    use HasFactory, Notifiable;

        protected $table = 'recipt';

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'category_id',
        'ingredient',
        'tools',
        'instruction',
        'status',
    ];

    //karena poto di table yang berbeda
    public function images()
    {
        return $this->hasMany(ImageRecipt::class);
    }

    public function category()
    {
        return $this->belongsTo(RecipeCategory::class, 'category_id');
    }
}
