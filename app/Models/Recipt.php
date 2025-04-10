<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Recipt extends Model
{
    use HasFactory, Notifiable;

    public $timestamps = false;  // Nonaktifkan timestamps otomatis
    protected $table = 'recipt';  // Nama tabel

    protected $fillable = [
        'user_id',  // Kolom yang boleh diisi secara massal
        'name',
        'description',
        'status',
    ];
}
