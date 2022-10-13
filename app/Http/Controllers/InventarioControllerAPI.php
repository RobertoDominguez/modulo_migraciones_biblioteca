<?php

namespace App\Http\Controllers;

use App\Models\Ejemplar;
use App\Models\EjemplarInventario;
use App\Models\Inventario;
use App\Models\Usuario;
use Exception;
use Illuminate\Http\Request;

class InventarioControllerAPI extends Controller
{
    
    public function registrar(Request $request)
    {
        $validated = $request->validate([
            'rfid' => ['required'],
            'nombre' => ['required', 'string'],
            'clave' => ['required', 'string']
        ]);

        ////////////////SEGURIDAD///////////////
        $user = Usuario::where('usuarios.nombre', $request->nombre)->get()->first();

        if (is_null($user)) {
            $data['message'] = 'No existe el usuario.';
            return response()->json($data, 400);
        }

        if ((strtoupper(md5($request->clave)) == $user->Clave || md5($request->clave) == $user->Clave) && ($user->Rol_Id == 7)) {


            /////////////////////////////////////////////////

            $data = [
                'data' => [],
                'message' => 'Ejemplar Registrado Correctamente.'
            ];

            $invAbierto = Inventario::whereNull('f_fin')->get()->first();

            if (is_null($invAbierto)) {
                $data['message'] = 'No existe ningun inventario abierto.';
                return response()->json($data, 400);
            }

            $ejemplar = Ejemplar::where('CodRFID', $request->rfid)->get()->first();

            if (is_null($ejemplar)) {
                $data['message'] = 'Ejemplar no encontrado';
                return response()->json($data, 400);
            }

            $ejemplarInventario = EjemplarInventario::where('Id_Ejemplar', $ejemplar->Id)->where('Id_Inventario', $invAbierto->Id)->get()->first();

            if (is_null($ejemplarInventario)) {
                $data['message'] = 'El ejemplar no se encuentra registrado en este inventario, cierre y abra un nuevo inventario si agrego un nuevo ejemplar recientemente.';
                return response()->json($data, 400);
            }

            if ($ejemplarInventario->existe==1) {
                $data['message'] = 'El ejemplar ya esta agregado al inventario.';
                return response()->json($data, 200);
            }


            try{
                $ejemplarInventario->update([
                    'fecha_registro' => now(),
                    'existe' => 1
                ]);
                $invAbierto->update([
                    'cantidad'=>$invAbierto->cantidad+1,
                    'faltantes'=>$invAbierto->faltantes-1
                ]);
            }catch(Exception $e){
                $data['message'] = $e;
                return response()->json($data, 400);
            }
            

            return response()->json($data, 200);
        } else {
            $data['message'] = 'Clave incorrecta.';
            return response()->json($data, 400);
        }
    }
}
