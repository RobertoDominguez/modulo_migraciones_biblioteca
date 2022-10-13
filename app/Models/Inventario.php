<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;

    protected $table='Inventario';

    protected $primaryKey = 'Id';

    protected $fillable=[
        'Id',
        'f_ini',
        'f_fin',
        'cantidad',
        'faltantes'
    ];

    public $timestamps = false;
}
