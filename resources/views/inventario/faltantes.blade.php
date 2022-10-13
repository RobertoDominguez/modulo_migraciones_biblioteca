@extends('layouts.template')

@section('title')
    Ejemplares Faltantes
@endsection

@section('content')
    <div class="card mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <i class="fas fa-table mr-1"></i>
                    Ejemplares sin registrar
                </div>


            </div>


        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Codigo</th>
                            <th>Titulo</th>
                            <th>Clasificacion</th>
                            <th>Tipo Material</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Codigo</th>
                            <th>Titulo</th>
                            <th>Clasificacion</th>
                            <th>Tipo Material</th>
                        </tr>
                    </tfoot>
                    <tbody>

                        @foreach ($ejemplares as $ejemplar)
                            <tr>

                                <td>{{ $ejemplar->Id }}</td>
                                <td>{{ $ejemplar->Codigo }}</td>
                                <td>{{ $ejemplar->Titulo }}</td>
                                <td>{{ $ejemplar->Nombre }}</td>
                                <td>{{ $ejemplar->TipoMaterial }}</td>
                            </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
