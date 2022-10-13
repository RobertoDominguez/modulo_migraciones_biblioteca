<?php

namespace App\Http\Controllers;

use App\Models\Autor;
use App\Models\Carrera;
use App\Models\Clasificacion;
use App\Models\Editorial;
use App\Models\Ejemplar;
use App\Models\Material;
use App\Models\MaterialesLibro;
use App\Models\Pais;
use App\Models\Persona;
use App\Models\PersonaLector;
use App\Models\Usuario;
use Illuminate\Http\Request;
use PDO;
use PDOException;
use ReflectionClass;

use function PHPSTORM_META\map;

class MigracionController extends Controller
{

    public function migracionMaterial()
    {
        return view('migracion.migracion_material');
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

                    $nombrePais = str_replace("^a", "", $elementos[33]);
                    $pais = Pais::where('nombre', $nombrePais)->get()->first();

                    if (is_null($pais)) {
                        $pais = Pais::create([
                            'nombre' => $nombrePais,
                            'estado' => 1
                        ]);
                    }

                    //////////////////////////////CLASIFICACIONES/////////////////////////////////////



                    $clasificaciones = explode("^", $elementos[40]);


                    //SOLO OCUPA UNA CLASIFICACION
                    // foreach ($clasificaciones as $clasificacion) {
                    // }
                    if (count($clasificaciones)>1 && $clasificaciones[0]==''){
                        $nombreClasificacion=substr($clasificaciones[1],1,strlen($clasificaciones[1])-1);
                    }else{
                        $nombreClasificacion=$clasificaciones[0];
                    }
                    

                    $ubicacion=str_replace(array("^a","^b","^c")," ",$elementos[1]);

                    $clasificacion = Clasificacion::where('nombre', $ubicacion)->get()->first();  /////////////^a

                    if (is_null($clasificacion)) {
                        $clasificacion = Clasificacion::create([
                            'codigo' => '',
                            'nombre' => $ubicacion,
                            'descripcion' => '',
                            'estado' => 1
                        ]);
                    }


                    //HAY VARIOS AUTORES SEPARADOS POR COMAS, creo que seria mejor poner varios autores (tabla libro autor)
                    // $autores = explode(",", $elementos[10]);
                    // foreach ($autores as $a) {
                    // }

                    $nombreAutor = $elementos[10];
                    if (strlen($nombreAutor) > 100) {
                        $nombreAutor = substr($nombreAutor, 0, 100);
                    }

                    $autor = Autor::where('nombre', $nombreAutor)->get()->first();

                    if (is_null($autor)) {
                        $autor = Autor::create([
                            'codigo' => '',
                            'nombre' => $nombreAutor,
                            'estado' => 1
                        ]);
                    }

                    ////////////////////////////////////////////////MATERIAL//////////////////////////////////////////
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


                    $existeMaterial = Material::where('codigo', $elementos[0])->where('tipomaterial', $elementos[3])->get()->first();


                    if (is_null($existeMaterial)) {
                        $dataMaterial = [
                            'codigo' => $elementos[0],
                            'titulo' => $elementos[11],
                            'resumen' => $elementos[42],
                            //'fechaPublicacion' => $elementos[30],
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

                        if ($elementos[30] != 's.f') {
                            $dataMaterial['fechaPublicacion'] = $elementos[30];
                        }

                        $material = Material::create($dataMaterial);

                        $materialesLibro = MaterialesLibro::create([
                            'Id' => $material->Id,
                            'ISBN' => $elementos[34],
                            'Edicion' => $elementos[29]
                        ]);


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
                                $rfid = substr($r, 1, strlen($r) - 1);;

                                $rfid_arr = explode("&", $rfid);
                                if (count($rfid_arr) > 0) {
                                    $rfid = $rfid_arr[0];
                                }

                                $data['codRFID'] = $rfid;
                                $ejemplaresData[] = $data;
                            }
                        }

                        
                        foreach ($ejemplaresData as $e) {
                            $dataEj = [
                                'codigo' => $e['codigo'], //inicio
                                'CodRFID' => $e['codRFID'], //^r
                                'CodBarras' => $e['codigo'], //inicio
                                'TipoPrestamo' => 2,
                                'Ubicacion' => $ubicacion,
                                'Material_Id' => $material->Id,
                                'Precio' => 0
                            ];

                            // return $dataEj;

                            Ejemplar::create($dataEj);
                        }
                    }
                } catch (PDOException $e) {

                    $cantidad_errores = $cantidad_errores + 1;
                    fputs($log_errors, 'Error al migrar nro: ' . $nro . "\r\n" . 'Error: ' . MigracionController::accessProtected($e, 'message') . "\r\n");
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
        return view('migracion.migracion_persona');
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

                $existePersona = Persona::where('ci', $elementos[5])->get()->first();

                if (is_null($existePersona)) {
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

                    $personaLector = PersonaLector::create($datosPersonaLector);

                    $datosUsuario = [
                        'Nombre' => $personaLector->codigo,
                        'Clave' => md5($persona->ci),
                        'Rol_Id' => 3,
                        'Estado' => 1,
                        'Persona_Id' => $persona->Id
                    ];

                    $usuario = Usuario::create($datosUsuario);
                }
            } catch (PDOException $e) {
                $cantidad_errores = $cantidad_errores + 1;

                fputs($log_errors, 'Error al migrar nro: ' . $nro . "\r\n" . 'Error: ' . MigracionController::accessProtected($e, 'message') . "\r\n");
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
