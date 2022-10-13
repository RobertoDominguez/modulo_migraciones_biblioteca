<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioControllerAPI extends Controller
{
    
    public function loginAPI(Request $request)
    {
        $credentials = $this->validate(
            request(),
            [
                'nombre' => 'required|string',
                'clave' => 'required|string'
            ]
        );

        $data = [
            'data' => [],
            'message' => 'Inicio de sesion exitoso.'
        ];

        $user = Usuario::where('usuarios.nombre', $request->nombre)->get()->first();

        if (is_null($user)){
            $data['message']='No existe el usuario.';
            return response()->json($data, 400);
        }

        if ((strtoupper(md5($request->clave)) == $user->Clave || md5($request->clave) == $user->Clave) && ($user->Rol_Id == 7)) {
            $data['data']=$user;
            return response()->json($data, 200);
        }

        $data['message']='Clave incorrecta.';
        return response()->json($data, 400);
    }
}
