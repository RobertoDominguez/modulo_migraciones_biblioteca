@extends('layouts.template')

@section('title')
    Editar Ejemplar
@endsection

@section('content')
    <div class="card mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <i class="fas fa-table mr-1"></i>
                    Editar Ejemplar
                </div>


            </div>


        </div>

        <div class="card-body">
            <form action="{{route('administracion.ejemplares.update',$ejemplar->Id)}}" method="POST">
                {{ csrf_field() }}

                <div class="form-group">
                    <label class="small mb-1" for="Codigo">Codigo de Ejemplar</label>
                    <input name="Codigo" value="{{$ejemplar->Codigo}}"
                        class="form-control py-4" id="Codigo" type="text" 
                        placeholder="Introduce el Codigo del Ejemplar (Cod Inventario)" required/>
                </div>

                <div class="form-group">
                    <label class="small mb-1" for="CodRFID">Codigo RFID</label>
                    <input name="CodRFID" value="{{$ejemplar->CodRFID}}"
                        class="form-control py-4" id="CodRFID" type="text" 
                        placeholder="Introduce el Codigo RFID del Ejemplar" required/>
                </div>

                <div class="form-group">
                    <label class="small mb-1" for="Ubicacion">Ubicacion</label>
                    <input name="Ubicacion" value="{{$ejemplar->Ubicacion}}"
                        class="form-control py-4" id="Ubicacion" type="text" 
                        placeholder="Introduce la Ubicacion del Ejemplar (Clasificacion)" required/>
                </div>

                <button class="btn btn-primary btn-block">Actualizar Ejemplar</button>
            </form>
        </div>
    </div>
@endsection
