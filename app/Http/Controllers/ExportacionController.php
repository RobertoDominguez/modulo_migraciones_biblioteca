<?php

namespace App\Http\Controllers;

use App\Models\Ejemplar;
use App\Models\Material;
use Illuminate\Http\Request;

class ExportacionController extends Controller
{
    public function ejemplares_libros()
    {
        $ejemplares = Ejemplar::join('Materiales', 'materiales.Id', 'Ejemplares.Material_Id')
            ->join('clasificaciones', 'clasificaciones.Id', 'Materiales.Clasificacion_Id')
            ->where('Materiales.TipoMaterial','M')
            ->select('Ejemplares.*', 'Materiales.Titulo', 'Materiales.TipoMaterial', 'Clasificaciones.Nombre')->get();

        return view('exportacion.ejemplares_libros', compact('ejemplares'));
    }

    public function ejemplares_revistas()
    {
        $ejemplares = Ejemplar::join('Materiales', 'materiales.Id', 'Ejemplares.Material_Id')
            ->join('clasificaciones', 'clasificaciones.Id', 'Materiales.Clasificacion_Id')
            ->where('Materiales.TipoMaterial','S')
            ->select('Ejemplares.*', 'Materiales.Titulo', 'Materiales.TipoMaterial', 'Clasificaciones.Nombre')->get();

        return view('exportacion.ejemplares_revistas', compact('ejemplares'));
    }

    public function ejemplares_tesis()
    {
        $ejemplares = Ejemplar::join('Materiales', 'materiales.Id', 'Ejemplares.Material_Id')
            ->join('clasificaciones', 'clasificaciones.Id', 'Materiales.Clasificacion_Id')
            ->where('Materiales.TipoMaterial','T')
            ->select('Ejemplares.*', 'Materiales.Titulo', 'Materiales.TipoMaterial', 'Clasificaciones.Nombre')->get();

        return view('exportacion.ejemplares_tesis', compact('ejemplares'));
    }


    public function materiales_libros()
    {
        $materiales = Material::join('Editoriales','Editoriales.Id','Materiales.Editorial_Id')
        ->join('Clasificaciones','Clasificaciones.Id','Materiales.Clasificacion_Id')
        ->join('Autores','Autores.Id','Materiales.Autor_Id')
        ->join('Paises','Paises.Id','Materiales.Pais_Id')
        ->where('Materiales.TipoMaterial','M')
        ->select('Materiales.*', 'Editoriales.nombre as Editorial', 'Clasificaciones.nombre as Clasificacion',
        'Autores.nombre as Autor','Paises.Nombre as Pais')->get();

        return view('exportacion.materiales_libros', compact('materiales'));
    }

    public function materiales_revistas()
    {
        $materiales = Material::join('Editoriales','Editoriales.Id','Materiales.Editorial_Id')
        ->join('Clasificaciones','Clasificaciones.Id','Materiales.Clasificacion_Id')
        ->join('Autores','Autores.Id','Materiales.Autor_Id')
        ->join('Paises','Paises.Id','Materiales.Pais_Id')
        ->where('Materiales.TipoMaterial','S')
        ->select('Materiales.*', 'Editoriales.nombre as Editorial', 'Clasificaciones.nombre as Clasificacion',
        'Autores.nombre as Autor','Paises.Nombre as Pais')->get();


        return view('exportacion.materiales_revistas', compact('materiales'));
    }

    public function materiales_tesis()
    {
        $materiales = Material::join('Editoriales','Editoriales.Id','Materiales.Editorial_Id')
        ->join('Clasificaciones','Clasificaciones.Id','Materiales.Clasificacion_Id')
        ->join('Autores','Autores.Id','Materiales.Autor_Id')
        ->join('Paises','Paises.Id','Materiales.Pais_Id')
        ->where('Materiales.TipoMaterial','T')
        ->select('Materiales.*', 'Editoriales.nombre as Editorial', 'Clasificaciones.nombre as Clasificacion',
        'Autores.nombre as Autor','Paises.Nombre as Pais')->get();

        return view('exportacion.materiales_tesis', compact('materiales'));
    }
}
