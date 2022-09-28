<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    use HasFactory;

    protected $table='Paises';

    protected $primaryKey = 'Id';

    protected $fillable=[
        'nombre',
        'estado'
    ];

    public $timestamps = false;
}
