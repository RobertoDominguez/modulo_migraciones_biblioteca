<?php

namespace App\Http\Controllers;

use App\Models\Ejemplar;
use App\Models\EjemplarInventario;
use App\Models\Inventario;


class InventarioController extends Controller
{
    public function index()
    {
        $inventarios = Inventario::orderBy('Id', 'desc')->get();
        return view('inventario.index', compact('inventarios'));
    }

    public function store()
    {
        $invAbierto = Inventario::whereNull('f_fin')->get()->first();

        if (is_null($invAbierto)) {


            $ejemplares = Ejemplar::all();

            $inventario = Inventario::create([
                'f_ini' => now(),
                'f_fin' => null,
                'cantidad' => 0,
                'faltantes' => count($ejemplares)
            ]);

            foreach ($ejemplares as $e) {
                EjemplarInventario::create([
                    'Id_Ejemplar' => $e->Id,
                    'Id_Inventario' => $inventario->Id,
                    'existe' => false,
                    'fecha_registro' => null
                ]);
            }


            return back()->with('message', 'Inventario abierto correctamente.');
        } else {
            return back()->withErrors(['Error' => 'Ya existe un inventario abierto, primero tiene que cerrarlo antes de abrir otro.']);
        }
    }

    public function cerrar()
    {
        $invAbierto = Inventario::whereNull('f_fin')->get()->first();

        if (is_null($invAbierto)) {
            return back()->withErrors(['Error' => 'No hay ningun inventario abierto.']);
        } else {
            $invAbierto->update(['f_fin' => now()]);
            return back()->with('message', 'Inventario cerrado correctamente.');
        }
    }

    public function registrados(Inventario $inventario)
    {

        $ejemplares = Ejemplar::join('Ejemplar_Inventario', 'Ejemplar_Inventario.Id_Ejemplar', 'Ejemplares.Id')
            ->join('Materiales', 'materiales.Id', 'Ejemplares.Material_Id')
            ->join('clasificaciones', 'clasificaciones.Id', 'Materiales.Clasificacion_Id')
            ->where('Ejemplar_Inventario.Id_Inventario', $inventario->Id)
            ->where('existe', 1)
            ->select('Ejemplares.*', 'Materiales.Titulo', 'Materiales.TipoMaterial', 'Clasificaciones.Nombre')->get();

        return view('inventario.registrados', compact('ejemplares', 'inventario'));
    }

    public function faltantes(Inventario $inventario)
    {
        $ejemplares = Ejemplar::join('Ejemplar_Inventario', 'Ejemplar_Inventario.Id_Ejemplar', 'Ejemplares.Id')
            ->join('Materiales', 'materiales.Id', 'Ejemplares.Material_Id')
            ->join('clasificaciones', 'clasificaciones.Id', 'Materiales.Clasificacion_Id')
            ->where('Ejemplar_Inventario.Id_Inventario', $inventario->Id)
            ->where('existe', 0)
            ->select('Ejemplares.*', 'Materiales.Titulo', 'Materiales.TipoMaterial', 'Clasificaciones.Nombre')->get();



        return view('inventario.faltantes', compact('ejemplares', 'inventario'));
    }

}
