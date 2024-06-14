<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;
     protected $fillable = [
        'titulo',
        'director',
        'duracion',
        'sinopsis',
        'fecha_estreno',
        'genero',
        'clasificacion',
        'portada'
    ];
    public function setPortadaAttribute($value)
    {
        $this->attributes['portada'] = pathinfo($value, PATHINFO_BASENAME);
    }
}
