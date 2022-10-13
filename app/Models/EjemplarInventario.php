<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EjemplarInventario extends Model
{
    use HasFactory;

    protected $table='Ejemplar_Inventario';

    protected $primaryKey = 'Id';

    protected $fillable=[
        'Id_Ejemplar',
        'Id_Inventario',
        'existe',
        'fecha_registro'
    ];

    public $timestamps = false;

}
