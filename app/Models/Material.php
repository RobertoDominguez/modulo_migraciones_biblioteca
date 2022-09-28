<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $table='Materiales';

    protected $primaryKey = 'Id';

    protected $fillable=[
        
        'codigo',
        'titulo',
        'resumen',
        'fechaPublicacion',
        'idioma',
        'observacion',
        'imagen',
        'editorial_id',
        'pais_id',
        'clasificacion_id',
        'autor_id',
        'imagen_url',
        'numpaginas',
        'pdf_url',
        'tipomaterial'
    ];

    public $timestamps = false;
}
