@extends('layouts.template')

@section('title')
    Inventarios
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <h3>Error al abrir Inventario</h3>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <i class="fas fa-table mr-1"></i>
                    Inventarios
                </div>

                <div class="col">
                    <form action="{{ route('inventario.store') }}" method="POST">
                        {{ csrf_field() }}
                        <button class="btn btn-primary">Abrir Inventario</button>
                    </form>
                </div>
            </div>


        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Nro</th>
                            <th>Fecha de Inicio</th>
                            <th>Fecha de Cierre</th>
                            <th>Ejemplares Registrados</th>
                            <th>Ejemplares Faltantes</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th>Nro</th>
                            <th>Fecha de Inicio</th>
                            <th>Fecha de Cierre</th>
                            <th>Ejemplares Registrados</th>
                            <th>Ejemplares Faltan
                        </tr>
                    </tfoot>
                    <tbody>






                        @for ($i = 0; $i < count($inventarios); $i++)
                            @php
                                $inventario = $inventarios[$i];
                            @endphp
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $inventario->Id }}</td>
                                <td>{{ $inventario->f_ini }}</td>
                                <td>{{ $inventario->f_fin }}</td>
                                <td>{{ $inventario->cantidad }}</td>
                                <td>{{ $inventario->faltantes }}</td>
                                <td>

                                    @if (is_null($inventario->f_fin))
                                        <form action="{{ route('inventario.cerrar') }}" method="POST">
                                            {{ csrf_field() }}
                                            <button class="btn btn-danger">Cerrar Inventario</button>
                                        </form>
                                        <br>
                                    @endif
                                    <a href="{{ route('inventario.registrados', $inventario->Id) }}"
                                        class="btn btn-primary">Ejemplares Registrados</a>
                                    <a href="{{ route('inventario.faltantes', $inventario->Id) }}"
                                        class="btn btn-warning">Ejemplares Faltantes</a>
                                </td>
                            </tr>
                        @endfor

                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
