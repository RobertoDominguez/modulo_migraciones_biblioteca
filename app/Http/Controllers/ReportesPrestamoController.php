<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Models\Prestamo;
use Exception;
use Illuminate\Http\Request;

class ReportesPrestamoController extends Controller
{
    
    public function mensual(Request $request){

        $data=[];
        $data2=[];
        $carreras=[];

        if (is_null($request->month) && is_null($request->year)){
            return view('reportes_prestamo.mensual',compact('carreras','data'),compact('data2'));
        }

        $carreras=Carrera::all();

        /////////SALA
        foreach ($carreras as $c){
            $row=[];
            for ($i=1; $i <=31 ; $i++) { 
                $fecha=$i.'/'.$request->month.'/'.$request->year;

                try{
                    $row[]=Prestamo::join('Personas_Lector','Personas_Lector.Id','Prestamos.Lector_Id')
                    ->where('prestamos.FechaIni',$fecha)
                    ->where('Personas_Lector.Carrera_Id',$c->Id)
                    ->where('prestamos.Estado',1)
                    ->where('prestamos.TipoPrestamo',1)
                    ->get()->count();
                }catch(Exception $e){
                    $row[]=0;
                }
                
            }
            $data[]=$row;
        }


        //////////DOMICILIO
        foreach ($carreras as $c){
            $row=[];
            for ($i=1; $i <=31 ; $i++) { 
                $fecha=$i.'/'.$request->month.'/'.$request->year;

                try{
                    $row[]=Prestamo::join('Personas_Lector','Personas_Lector.Id','Prestamos.Lector_Id')
                    ->where('prestamos.FechaIni',$fecha)
                    ->where('Personas_Lector.Carrera_Id',$c->Id)
                    ->where('prestamos.Estado',1)
                    ->where('prestamos.TipoPrestamo',2)
                    ->get()->count();
                }catch(Exception $e){
                    $row[]=0;
                }
                
            }
            $data2[]=$row;
        }


        return view('reportes_prestamo.mensual',compact('carreras','data'),compact('data2'));
    }

    public function anual(Request $request){

        $data=[];
        $carreras=[];

        if (is_null($request->year)){
            return view('reportes_prestamo.anual',compact('carreras','data'));
        }

        $carreras=Carrera::all();

        /////////SALA
        foreach ($carreras as $c){
            $row=[];
            for ($i=1; $i <=12 ; $i++) { 
                $fecha1='1'.'/'.$i.'/'.$request->year;
                if ($i<12){
                    $fecha2='1'.'/'.($i+1).'/'.$request->year;
                }else{
                    $fecha2='1'.'/'.'1'.'/'.$request->year+1;
                }
                
                try{
                    $row[]=Prestamo::join('Personas_Lector','Personas_Lector.Id','Prestamos.Lector_Id')
                    ->where('prestamos.FechaIni','>=',$fecha1)
                    ->where('prestamos.FechaIni','<',$fecha2)
                    ->where('Personas_Lector.Carrera_Id',$c->Id)
                    ->where('prestamos.Estado',1)
                    ->get()->count();
                }catch(Exception $e){
                    $row[]=0;
                }
                
            }
            $data[]=$row;
        }

        return view('reportes_prestamo.anual',compact('carreras','data'));
    }


    public static function nombreMes($nroMes)
    {
        $nombreMes = '';
        switch ($nroMes) {
            case 1:
                $nombreMes = 'Enero';
                break;
            case 2:
                $nombreMes = 'Febrero';
                break;
            case 3:
                $nombreMes = 'Marzo';
                break;
            case 4:
                $nombreMes = 'Abril';
                break;
            case 5:
                $nombreMes = 'Mayo';
                break;
            case 6:
                $nombreMes = 'Junio';
                break;
            case 7:
                $nombreMes = 'Julio';
                break;
            case 8:
                $nombreMes = 'Agosto';
                break;
            case 9:
                $nombreMes = 'Septiembre';
                break;
            case 10:
                $nombreMes = 'Octubre';
                break;
            case 11:
                $nombreMes = 'Noviembre';
                break;
            case 12:
                $nombreMes = 'Diciembre';
                break;

            default:
                $nombreMes = 'Indefinido';
                break;
        }

        return $nombreMes;
    }
}
