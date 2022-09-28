<?php

use App\Http\Controllers\MigracionController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware(['guest'])->group(function () {
    Route::get('/login', [UsuarioController::class, 'loginView'])->name('login');
    Route::post('/login', [UsuarioController::class, 'login'])->name('login.form');
});




Route::middleware(['auth:web'])->group(function () {
    Route::post('/logout', [UsuarioController::class, 'logout'])->name('logout.form');

    Route::get('/', function () {
        return view('menu');
    })->name('menu');


    Route::prefix('migracion')->group(function () {
        Route::get('/material', [MigracionController::class, 'migracionMaterial'])->name('migracion.material');
        Route::post('/material', [MigracionController::class, 'migrarMateriales'])->name('migrar.materiales');

        Route::get('/persona', [MigracionController::class, 'migracionPersona'])->name('migracion.persona');
        Route::post('/persona', [MigracionController::class, 'migrarPersonas'])->name('migrar.personas');
    });
});