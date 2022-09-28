<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $table='Personas';

    protected $primaryKey = 'Id';

    protected $fillable=[
        'ci',
        'nombres',
        'apPaterno',
        'apMaterno',
        'fechaNac',
        'Direccion',
        'Telefono',
        'CorreoE',
        'Sexo',
        'Imagen'
    ];

    public $timestamps = false;

}
