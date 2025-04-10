<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Recipt extends Model
{
    use HasFactory, Notifiable;

    public $timestamps = false;
    protected $table = 'recipt';

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'status',
    ];

    //karena poto di table yang berbeda
    public function images()
    {
        return $this->hasMany(ImageRecipt::class);
    }
}
