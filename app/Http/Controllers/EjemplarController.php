<?php

namespace App\Http\Controllers;

use App\Models\Ejemplar;
use App\Models\Material;
use Illuminate\Http\Request;

class EjemplarController extends Controller
{
    public function index_libros()
    {
        $ejemplares = Ejemplar::join('Materiales', 'materiales.Id', 'Ejemplares.Material_Id')
            ->join('clasificaciones', 'clasificaciones.Id', 'Materiales.Clasificacion_Id')
            ->where('Materiales.TipoMaterial', 'M')
            ->select('Ejemplares.*', 'Materiales.Titulo', 'Materiales.TipoMaterial', 'Clasificaciones.Nombre')->get();

        return view('administracion.ejemplares.index_libros', compact('ejemplares'));
    }

    public function index_revistas()
    {
        $ejemplares = Ejemplar::join('Materiales', 'materiales.Id', 'Ejemplares.Material_Id')
            ->join('clasificaciones', 'clasificaciones.Id', 'Materiales.Clasificacion_Id')
            ->where('Materiales.TipoMaterial', 'S')
            ->select('Ejemplares.*', 'Materiales.Titulo', 'Materiales.TipoMaterial', 'Clasificaciones.Nombre')->get();

        return view('administracion.ejemplares.index_revistas', compact('ejemplares'));
    }

    public function index_tesis()
    {
        $ejemplares = Ejemplar::join('Materiales', 'materiales.Id', 'Ejemplares.Material_Id')
            ->join('clasificaciones', 'clasificaciones.Id', 'Materiales.Clasificacion_Id')
            ->where('Materiales.TipoMaterial', 'T')
            ->select('Ejemplares.*', 'Materiales.Titulo', 'Materiales.TipoMaterial', 'Clasificaciones.Nombre')->get();

        return view('administracion.ejemplares.index_tesis', compact('ejemplares'));
    }

    public function edit(Ejemplar $ejemplar){
        return view('administracion.ejemplares.edit',compact('ejemplar'));
    }

    public function update(Ejemplar $ejemplar, Request $request)
    {
        $ejemplar->update([
            'Codigo' => $request->Codigo,
            'CodRFID' => $request->CodRFID,
            'Ubicacion'=>$request->Ubicacion
        ]);

        $material=Material::find($ejemplar->Material_Id);

        if ($material->TipoMaterial=='M'){
            return redirect()->route('administracion.ejemplares.index_libros');
        }

        if ($material->TipoMaterial=='S'){
            return redirect()->route('administracion.ejemplares.index_revistas');
        }

        if ($material->TipoMaterial=='T'){
            return redirect()->route('administracion.ejemplares.index_tesis');
        }
        
        return redirect()->route('administracion.ejemplares.materiales');
    }

    public function materiales()
    {
        $materiales = Material::join('Editoriales','Editoriales.Id','Materiales.Editorial_Id')
        ->join('Clasificaciones','Clasificaciones.Id','Materiales.Clasificacion_Id')
        ->join('Autores','Autores.Id','Materiales.Autor_Id')
        ->join('Paises','Paises.Id','Materiales.Pais_Id')
        // ->where('Materiales.TipoMaterial','M')
        ->select('Materiales.*', 'Editoriales.nombre as Editorial', 'Clasificaciones.nombre as Clasificacion',
        'Autores.nombre as Autor','Paises.Nombre as Pais')->get();

        return view('administracion.ejemplares.materiales',compact('materiales'));
    }


    public function create(Material $material){
        return view('administracion.ejemplares.create',compact('material'));
    }

    public function store(Request $request)
    {

        Ejemplar::create([
            'Codigo'=>$request->Codigo,
            'CodRFID'=>$request->CodRFID,
            'CodBarras'=>$request->Codigo,
            'TipoPrestamo'=>2,
            'Ubicacion'=>$request->Ubicacion,
            'Material_Id'=>$request->Material_Id,
            'Precio'=>0
        ]);

        return redirect()->route('administracion.ejemplares.materiales');
    }

    public function delete(Ejemplar $ejemplar){
        

        $material=Material::find($ejemplar->Material_Id);

        $ejemplar->delete();

        if ($material->TipoMaterial=='M'){
            return redirect()->route('administracion.ejemplares.index_libros');
        }

        if ($material->TipoMaterial=='S'){
            return redirect()->route('administracion.ejemplares.index_revistas');
        }

        if ($material->TipoMaterial=='T'){
            return redirect()->route('administracion.ejemplares.index_tesis');
        }
        
        return redirect()->route('administracion.ejemplares.materiales');
    }
}
