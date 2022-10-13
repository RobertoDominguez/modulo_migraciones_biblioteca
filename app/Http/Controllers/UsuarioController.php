<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{
    public function loginView(Request $request)
    {

        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $this->validate(
            request(),
            [
                'nombre' => 'required|string',
                'clave' => 'required|string'
            ]
        );

        $user = Usuario::where('usuarios.nombre', $request->nombre)->get()->first();

        // $user = Usuario::join('Roles', 'usuarios.Rol_Id', 'Roles.id')->where('usuarios.nombre', $request->nombre)->get()->first();

        // dd($user);

        if ((strtoupper(md5($request->clave)) == $user->Clave || md5($request->clave) == $user->Clave) && ($user->Rol_Id == 7)) {

            // dd($user);

            Auth::login($user, false);

            // dd(Auth::user());
            return redirect()->route('menu');
        }


        return back()
            ->withErrors(['nombre' => 'Estas credenciales no concuerdan con nuestros registros.'])
            ->withInput(request(['nombre']));
    }



    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
