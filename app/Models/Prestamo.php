<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    use HasFactory;

    protected $table='Prestamos';

    protected $primaryKey = 'Id';

    protected $fillable=[
        'Id',
        'Codigo',
        'FechaIni',
        'FechaFin',
        'FechaDev',
        'TipoPrestamo',
        'Devuelto',
        'Estado',
        'Lector_Id',
        'Bibliotecario_Id',
        'Estudiante_Codigo',
        'Impreso',
        'FechaRegistro'
    ];

    public $timestamps = false;

}
