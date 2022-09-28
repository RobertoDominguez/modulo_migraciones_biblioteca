<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Editorial extends Model
{
    use HasFactory;

    protected $table='Editoriales';

    protected $primaryKey = 'Id';

    protected $fillable=[
        'codigo',
        'nombre',
        'estado'
    ];

    public $timestamps = false;
}
