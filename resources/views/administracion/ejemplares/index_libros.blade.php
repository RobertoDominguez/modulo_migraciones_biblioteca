@extends('layouts.template')

@section('title')
    Ejemplares de Libros
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <div class="row">
            <div class="col">
                <i class="fas fa-table mr-1"></i>
                Ejemplares de Libros
            </div>


        </div>


    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            {{-- <table id="example" style="width:100%" class="table table-bordered" cellspacing="0"> --}}
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Codigo</th>
                        <th>RFID</th>
                        <th>Titulo</th>
                        <th>Ubicacion</th>
                        <th>Tipo Material</th>
                        <th>Accion</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($ejemplares as $ejemplar)
                        <tr>
                                <td>{{ $ejemplar->Id }}</td>
                                <td>
                                    <p>{{ $ejemplar->Codigo }}</p>
                                    {{-- <input class="form-control py-4" name="Codigo" type="text" value="{{ $ejemplar->Codigo }}" /> --}}
                                </td>
                                <td>
                                    <p>{{ $ejemplar->CodRFID }}</p>
                                    {{-- <input class="form-control py-4" style="width: 250px" name="CodRFID" type="text" value="{{ $ejemplar->CodRFID }}" /> --}}
                                </td>
                                <td>{{ $ejemplar->Titulo }}</td>
                                <td>
                                    <p >{{ $ejemplar->Ubicacion }}</p>
                                    {{-- <input class="form-control py-4" name="Ubicacion" type="text" value="{{ $ejemplar->Ubicacion }}" /> --}}
                                </td>
                                <td>{{ $ejemplar->TipoMaterial }}</td>
                                <td>
                                    <a href="{{route('administracion.ejemplares.edit', $ejemplar->Id)}}" class="btn btn-primary">Actualizar</a>

                                    <a href="{{route('administracion.ejemplares.delete', $ejemplar->Id)}}" class="btn btn-danger confirmation">Eliminar</a>
                                </td>
                            
                        </tr>
                    @endforeach



                </tbody>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Codigo</th>
                        <th>RFID</th>
                        <th>Titulo</th>
                        <th>Ubicacion</th>
                        <th>Tipo Material</th>
                        <th>Accion</th>
                    </tr>
                </tfoot>
            </table>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript">
    $('.confirmation').on('click', function () {
            return confirm('Estas seguro?');
        });
</script>
@endsection
