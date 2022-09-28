<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;


    protected $table = 'Usuarios';

    protected $primaryKey = 'Id';

    protected $username = 'Nombre';

    protected $fillable = [
        'Id',
        'Nombre',
        'Clave',
        'Rol_Id',
        'Estado',
        'Persona_Id'
    ];

    public $timestamps = false;
}
