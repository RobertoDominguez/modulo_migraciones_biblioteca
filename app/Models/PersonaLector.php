<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonaLector extends Model
{
    use HasFactory;

    protected $table='Personas_Lector';

    protected $primaryKey = 'Id';

    protected $fillable=[
        'id',
        'codigo',
        'estado',
        'carrera_id'
    ];

    public $timestamps = false;

}
