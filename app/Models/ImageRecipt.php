<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImageRecipt extends Model
{
    protected $table = 'image_recipt';  // Nama tabel
    protected $fillable = [
        'image_path',
        'recipt_id'

    ];
}
