<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_promo',
        'nama_promo',
        'tipe',
        'nilai',
        'minimal_belanja',
        'maksimal_diskon',
        'mulai',
        'berakhir',
        'status',
    ];

    protected $casts = [
        'mulai' => 'datetime',
        'berakhir' => 'datetime',
        'status' => 'boolean',
    ];

}
