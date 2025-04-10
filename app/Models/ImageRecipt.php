<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImageRecipt extends Model
{

    protected $table = 'image_recipt';
    protected $fillable = [
        'image_path',
        'recipt_id'

    ];

    //relasinyaaaa
    public function recipt()
    {
        return $this->belongsTo(Recipt::class);
    }
}
