<?php

namespace App\Http\Controllers;

use App\Models\Autor;
use App\Models\Carrera;
use App\Models\Clasificacion;
use App\Models\Editorial;
use App\Models\Ejemplar;
use App\Models\Material;
use App\Models\Pais;
use App\Models\Persona;
use App\Models\PersonaLector;
use Illuminate\Http\Request;
use PDOException;
use ReflectionClass;

use function PHPSTORM_META\map;

class MigracionController extends Controller
{

    public function migracionMaterial()
    {
        return view('migracion_material');
    }


    
    public static function accessProtected($obj, $prop)
    {
        $reflection = new ReflectionClass($obj);
        $property = $reflection->getProperty($prop);
        $property->setAccessible(true);
        return $property->getValue($obj);
    }

    public function migrarMateriales(Request $request)
    {

        $validated = $request->validate([
            'material' => ['required', 'file', 'mimes:txt']
        ]);

        $cantidad_errores = 0;

        $log_errors = fopen('log_errors.txt', 'a');

        $nro = 0;

        if ($request->hasFile('material')) {
            $file = $request->file('material');
        }

        $file = fopen($file->getRealPath(), 'r');
        while (!feof($file)) {
            $nro = $nro + 1;

            $linea = utf8_encode(fgets($file));
            $elementos = explode("|", $linea);

            if (count($elementos) == 54) {
                try {
                    $editorial = Editorial::where('nombre', $elementos[28])->get()->first();

                    if (is_null($editorial)) {
                        $editorial = Editorial::create([
                            'codigo' => '',
                            'nombre' => $elementos[28],
                            'estado' => 1
                        ]);
                    }

                    $pais = Pais::where('nombre', $elementos[33])->get()->first();

                    if (is_null($pais)) {
                        $pais = Pais::create([
                            'nombre' => $elementos[33],
                            'estado' => 1
                        ]);
                    }

                    $clasificacion = Clasificacion::where('nombre', $elementos[1])->get()->first();  /////////////^a

                    if (is_null($clasificacion)) {
                        $clasificacion = Clasificacion::create([
                            'codigo' => '',
                            'nombre' => $elementos[1],
                            'descripcion' => '',
                            'estado' => 1
                        ]);
                    }

                    $autor = Autor::where('nombre', $elementos[10] )->get()->first();

                    if (is_null($autor)) {
                        $autor = Autor::create([
                            'codigo' => '',
                            'nombre' => $elementos[10],
                            'estado' => 1
                        ]);
                    }

                    $pdf = explode("^", $elementos[6]);
                    if (count($pdf) > 1) {
                        $pdf = substr($pdf[1], 1, strlen($pdf[1]) - 1);
                    } else {
                        $pdf = '';
                    }


                    $idioma = '';

                    if (strlen($elementos[27]) > 2) {
                        $idioma = substr($elementos[27], 2, strlen($elementos[27]) - 2);
                    }

                    $dataMaterial = [
                        'codigo' => $elementos[0],
                        'titulo' => $elementos[11],
                        'resumen' => $elementos[42],
                        'fechaPublicacion' => $elementos[30],
                        'idioma' => $idioma,
                        'observacion' => '',
                        // 'imagen'=>null,//$elementos[9],
                        'editorial_id' => $editorial->Id,
                        'pais_id' => $pais->Id,
                        'clasificacion_id' => $clasificacion->Id,
                        'autor_id' => $autor->Id,
                        'imagen_url' => $elementos[9],
                        'numpaginas' => 0,  //24 pero no es numerico, falta convertir
                        'pdf_url' => $pdf, ////////filtrar ^u
                        'tipomaterial' => $elementos[3],
                    ];

                    $material = Material::create($dataMaterial);


                    $rowsEjemplares = explode("^", $elementos[5]);


                    $ejemplaresData = [];
                    $data = [
                        'codigo' => '',
                        'codRFID' => ''
                    ];

                    foreach ($rowsEjemplares as $r) {
                        if (
                            substr($r, 0, 1) != "a" && substr($r, 0, 1) != "f" && substr($r, 0, 1) != "v" && substr($r, 0, 1) != "t"
                            && substr($r, 0, 1) != "m" && substr($r, 0, 1) != "n" && substr($r, 0, 1) != "r"
                        ) {
                            $data['codigo'] = $r;
                        }

                        if (substr($r, 0, 1) == "r") {
                            $data['codRFID'] = substr($r, 0, strlen($r) - 1);
                            $ejemplaresData[] = $data;
                        }
                    }

                    foreach ($ejemplaresData as $e) {
                        $dataEj = [
                            'codigo' => $e['codigo'], //inicio
                            'CodRFID' => $e['codRFID'], //^r
                            'CodBarras' => $e['codigo'], //inicio
                            'TipoPrestamo' => 1,
                            'Ubicacion' => '',
                            'Material_Id' => $material->Id,
                            'Precio' => 0
                        ];

                        // return $dataEj;

                        Ejemplar::create($dataEj);
                    }
                } catch (PDOException $e) {
                    
                    $cantidad_errores = $cantidad_errores + 1;
                    fputs($log_errors, 'Error al migrar nro: ' . $nro ."\r\n".'Error: ' . MigracionController::accessProtected($e, 'message')."\r\n");
                    fputs($log_errors, "\r\n");
                    fputs($log_errors, "=================================================================================================================\r\n");
                    fputs($log_errors, "\r\n");
                }
            } else {
                $cantidad_errores = $cantidad_errores + 1;
                fputs($log_errors, 'Error al migrar nro: ' . $nro . "\r\n");
                fputs($log_errors, "\r\n");
                fputs($log_errors, "=================================================================================================================\r\n");
                fputs($log_errors, "\r\n");
            }
        }
        fclose($file);
        fclose($log_errors);

        return redirect(route('migracion.material'))->withErrors(['errores' => 'Cantidad de errores al migrar: ' . $cantidad_errores]);
        // return $cantidad_errores;
    }



    public function migracionPersona()
    {
        return view('migracion_persona');
    }

    public function migrarPersonas(Request $request)
    {

        $validated = $request->validate([
            'personas' => ['required', 'file', 'mimes:txt']
        ]);

        $cantidad_errores = 0;
        if ($request->hasFile('personas')) {
            $file = $request->file('personas');
        }

        $file = fopen($file->getRealPath(), 'r');
        $log_errors = fopen('log_errors_p.txt', 'a');
        $nro = 0;

        while (!feof($file)) {
            $nro = $nro + 1;

            $linea = fgets($file);
            $elementos = explode("|", $linea);
            // ANIO	PERIODO	APELLIDOS	NOMBRES	SEXO	CI	ESTUDIANTE	PLAN	carrera	email

            try {

                $apPaterno = '';
                $apMaterno = '';

                $apellidos = explode(" ", $elementos[2]);
                $apPaterno = $apellidos[0];
                if (count($apellidos) > 1) {
                    $apMaterno = $apellidos[1];
                }

                $datosPersona = [
                    'ci' => $elementos[5],
                    'nombres' => $elementos[3],
                    'apPaterno' => $apPaterno,
                    'apMaterno' => $apMaterno,
                    // 'fechaNac'=>null,
                    'Direccion' => '',
                    'Telefono' => '',
                    'CorreoE' => $elementos[9],
                    'Sexo' => 0,
                    // 'Imagen'
                ];

                $persona = Persona::create($datosPersona);


                $carrera = Carrera::where('nombre', $elementos[8])->get()->first();

                if (is_null($carrera)) {
                    $carrera = Carrera::create([
                        'nombre' => $elementos[8],
                        'estado' => 1
                    ]);
                }

                $datosPersonaLector = [
                    'id' => $persona->Id,
                    'codigo' => $elementos[6],
                    'estado' => 1,
                    'carrera_id' => $carrera->Id
                ];

                PersonaLector::create($datosPersonaLector);
            } catch (PDOException $e) {
                $cantidad_errores = $cantidad_errores + 1;

                fputs($log_errors, 'Error al migrar nro: ' . $nro ."\r\n".'Error: ' . MigracionController::accessProtected($e, 'message')."\r\n");
                fputs($log_errors, "\r\n");
                fputs($log_errors, "=================================================================================================================\r\n");
                fputs($log_errors, "\r\n");
            }
        }
        fclose($file);
        fclose($log_errors);

        return redirect(route('migracion.persona'))->withErrors(['errores' => 'Cantidad de errores al migrar: ' . $cantidad_errores]);
        // return $cantidad_errores;
    }
}
