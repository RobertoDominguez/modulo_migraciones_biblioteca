@extends('layouts.template')

@section('title')
    Nuevo Ejemplar de {{$material->Titulo}}
@endsection

@section('content')
    <div class="card mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <i class="fas fa-table mr-1"></i>
                    Nuevo ejemplar
                </div>


            </div>


        </div>

        <div class="card-body">
            <form action="{{route('administracion.ejemplares.store')}}" method="POST">
                {{ csrf_field() }}

                <input type="text" name="Material_Id" value="{{$material->Id}}" hidden>

                <div class="form-group">
                    <label class="small mb-1" for="Codigo">Codigo de Ejemplar</label>
                    <input name="Codigo"
                        class="form-control py-4" id="Codigo" type="text" 
                        placeholder="Introduce el Codigo del Ejemplar (Cod Inventario)" required/>
                </div>

                <div class="form-group">
                    <label class="small mb-1" for="CodRFID">Codigo RFID</label>
                    <input name="CodRFID"
                        class="form-control py-4" id="CodRFID" type="text" 
                        placeholder="Introduce el Codigo RFID del Ejemplar" required/>
                </div>

                <div class="form-group">
                    <label class="small mb-1" for="Ubicacion">Ubicacion</label>
                    <input name="Ubicacion"
                        class="form-control py-4" id="Ubicacion" type="text" 
                        placeholder="Introduce la Ubicacion del Ejemplar (Clasificacion)" required/>
                </div>

                <button class="btn btn-primary btn-block">Crear Ejemplar</button>
            </form>
        </div>
    </div>
@endsection
