<?php

use App\Http\Controllers\InventarioControllerAPI;
use App\Http\Controllers\UsuarioControllerAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/usuario/login',[UsuarioControllerAPI::class,'loginAPI']); //nombre,clave

Route::post('/inventario/registrar',[InventarioControllerAPI::class,'registrar']); //rfid,nombre,clave