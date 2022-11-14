<?php

use App\Http\Controllers\EjemplarController;
use App\Http\Controllers\ExportacionController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\MigracionController;
use App\Http\Controllers\ReportesPrestamoController;
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

    Route::prefix('inventario')->group(function () {
        Route::get('/', [InventarioController::class, 'index'])->name('inventario.index');
        Route::post('/store', [InventarioController::class, 'store'])->name('inventario.store');

        Route::post('/cerrar', [InventarioController::class, 'cerrar'])->name('inventario.cerrar');

        Route::get('/registrados/{inventario}', [InventarioController::class, 'registrados'])->name('inventario.registrados');
        Route::get('/faltantes/{inventario}', [InventarioController::class, 'faltantes'])->name('inventario.faltantes');
    });

    Route::prefix('reporte')->group(function () {
        Route::prefix('prestamo')->group(function () {
            Route::get('/mensual', [ReportesPrestamoController::class, 'mensual'])->name('reporte.prestamo.mensual');
            Route::get('/anual', [ReportesPrestamoController::class, 'anual'])->name('reporte.prestamo.anual');
        });
    });


    Route::prefix('exportacion')->group(function () {
        Route::prefix('ejemplares')->group(function () {
            Route::get('/libros', [ExportacionController::class, 'ejemplares_libros'])->name('exportacion.ejemplares.libros');
            Route::get('/revistas', [ExportacionController::class, 'ejemplares_revistas'])->name('exportacion.ejemplares.revistas');
            Route::get('/tesis', [ExportacionController::class, 'ejemplares_tesis'])->name('exportacion.ejemplares.tesis');
        });

        Route::prefix('materiales')->group(function () {
            Route::get('/libros', [ExportacionController::class, 'materiales_libros'])->name('exportacion.materiales.libros');
            Route::get('/revistas', [ExportacionController::class, 'materiales_revistas'])->name('exportacion.materiales.revistas');
            Route::get('/tesis', [ExportacionController::class, 'materiales_tesis'])->name('exportacion.materiales.tesis');
        });
    });


    Route::prefix('administracion')->group(function () {
        Route::prefix('ejemplares')->group(function () {
            Route::get('/libros', [EjemplarController::class, 'index_libros'])->name('administracion.ejemplares.index_libros');
            Route::get('/revistas', [EjemplarController::class, 'index_revistas'])->name('administracion.ejemplares.index_revistas');
            Route::get('/tesis', [EjemplarController::class, 'index_tesis'])->name('administracion.ejemplares.index_tesis');
            
            Route::get('/edit/{ejemplar}', [EjemplarController::class, 'edit'])->name('administracion.ejemplares.edit');

            Route::post('/update/{ejemplar}', [EjemplarController::class, 'update'])->name('administracion.ejemplares.update');

            Route::get('/materiales', [EjemplarController::class, 'materiales'])->name('administracion.ejemplares.materiales');
            Route::get('/create/{material}', [EjemplarController::class, 'create'])->name('administracion.ejemplares.create');
            Route::post('/', [EjemplarController::class, 'store'])->name('administracion.ejemplares.store');

            Route::get('/delete/{ejemplar}', [EjemplarController::class, 'delete'])->name('administracion.ejemplares.delete');            
        });


    });
});
