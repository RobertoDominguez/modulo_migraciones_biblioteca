<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialesLibro extends Model
{
    use HasFactory;

    protected $table='Materiales_Libro';

    protected $primaryKey = 'Id';

    protected $fillable=[
        'Id',
        'ISBN',
        'Edicion'
    ];

    public $timestamps = false;
}
