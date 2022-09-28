<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ejemplar extends Model
{
    use HasFactory;

    protected $table='Ejemplares';

    protected $primaryKey = 'Id';

    protected $fillable=[
        'codigo',
        'CodRFID',
        'CodBarras',
        'TipoPrestamo',
        'Ubicacion',
        'Material_Id',
        'Precio'
    ];

    public $timestamps = false;

}
