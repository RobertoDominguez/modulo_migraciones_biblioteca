<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clasificacion extends Model
{
    use HasFactory;

    protected $table='Clasificaciones';

    protected $primaryKey = 'Id';

    protected $fillable=[
        'codigo',
        'descripcion',
        'nombre',
        'estado'
    ];

    public $timestamps = false;
}
