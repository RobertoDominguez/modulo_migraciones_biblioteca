@extends('layouts.template_datatable')

@section('title')
    Reporte de Prestamos Mensuales
@endsection

@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reporte de Prestamos Mensuales</title>

        <!-- DOCUMENTACION DE TABLAS -->
        <!-- https://datatables.net/extensions/buttons/examples/print/simple.html -->

        <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">

        {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css"> --}}

        <!-- <style>
                    table.dataTable thead tr {
                        background-color: green;
                    }
                </style> -->
        <style>
            table tfoot {
                display: table-row-group;
            }
        </style>
    </head>

    <body>

        <br>
        <form action="{{ route('reporte.prestamo.mensual') }}" method="GET">
            {{ csrf_field() }}

            <!-- <input name="cpry" value="" placeholder="Codigo De Proyecto"> -->

            <select name="year">

                @for ($i = 2020; $i < 2060; $i++)
                    <option value="{{$i}}">{{$i}}</option>
                @endfor

            </select>

            <select name="month">
                <option value="1">ENERO</option>
                <option value="2">FEBRERO</option>
                <option value="3">MARZO</option>
                <option value="4">ABRIL</option>
                <option value="5">MAYO</option>
                <option value="6">JUNIO</option>
                <option value="7">JULIO</option>
                <option value="8">AGOSTO</option>
                <option value="9">SEPTIEMBRE</option>
                <option value="10">OCTUBRE</option>
                <option value="11">NOVIEMBRE</option>
                <option value="12">DICIEMBRE</option>
            </select>

            {{-- <input name="year" value="" placeholder="AÑO"> --}}
            {{-- <input name="month" value="" placeholder="MES"> --}}

            <button class="btn btn-primary">Generar Reporte</button>

        </form>
        <br>




        <div class="center">
            <h2>SALA</h2>
        </div>
        {{-- <table id="example" class="display" style="width:100%"> --}}
        <table id="example" class="cell-border" style="width:100%">
            <thead>
                <tr>
                    <th>Carrera/Dia</th>
                    @for ($i = 1; $i <= 31; $i++)
                        <th>{{ $i }}</th>
                    @endfor
                    <th>Total</th>
                </tr>

            </thead>
            <tbody>
                @php
                    $total = 0;
                    $totales = [];
                    for ($i = 0; $i < 31; $i++) {
                        $totales[] = 0;
                    }
                    $i = 0;
                @endphp
                @foreach ($carreras as $carrera)
                    <tr>

                        <td>{{ $carrera->Nombre }} </td>
                        @for ($j = 0; $j < 31; $j++)
                            <td>{{ $data[$i][$j] }}</td>
                            @php
                                $total = $total + $data[$i][$j];
                                $totales[$i] = $totales[$i] + $data[$i][$j];
                            @endphp
                        @endfor
                        <td>{{ $total }} </td>
                    </tr>

                    @php
                        $i = $i + 1;
                        $total = 0;
                    @endphp
                @endforeach



                @php
                    $total = 0;
                @endphp
                <tr>

                    <td>TOTAL SALA</td>
                    @for ($j = 0; $j < 31; $j++)
                        <td>{{ $totales[$j] }}</td>
                        @php
                            $total = $total + $totales[$j];
                        @endphp
                    @endfor
                    <td>{{ $total }} </td>
                </tr>


            </tbody>
            {{-- <tfoot>
            <tr>
                <th>Carreras/Fecha</th>
            </tr>
        </tfoot> --}}
        </table>













        <div class="center">
            <h2>DOMICILIO</h2>
        </div>
        {{-- <table id="example" class="display" style="width:100%"> --}}
        <table id="example2" class="cell-border" style="width:100%">
            <thead>
                <tr>
                    <th>Carrera/Dia</th>
                    @for ($i = 1; $i <= 31; $i++)
                        <th>{{ $i }}</th>
                    @endfor
                    <th>Total</th>
                </tr>

            </thead>
            <tbody>
                @php
                    $total = 0;
                    $totales = [];
                    for ($i = 0; $i < 31; $i++) {
                        $totales[] = 0;
                    }
                    $i = 0;
                @endphp
                @foreach ($carreras as $carrera)
                    <tr>

                        <td>{{ $carrera->Nombre }} </td>
                        @for ($j = 0; $j < 31; $j++)
                            <td>{{ $data2[$i][$j] }}</td>
                            @php
                                $total = $total + $data2[$i][$j];
                                $totales[$i] = $totales[$i] + $data2[$i][$j];
                            @endphp
                        @endfor
                        <td>{{ $total }} </td>
                    </tr>

                    @php
                        $i = $i + 1;
                        $total = 0;
                    @endphp
                @endforeach



                @php
                    $total = 0;
                @endphp
                <tr>

                    <td>TOTAL DOMICILIO</td>
                    @for ($j = 0; $j < 31; $j++)
                        <td>{{ $totales[$j] }}</td>
                        @php
                            $total = $total + $totales[$j];
                        @endphp
                    @endfor
                    <td>{{ $total }} </td>
                </tr>


            </tbody>
            {{-- <tfoot>
            <tr>
                <th>Carreras/Fecha</th>
            </tr>
        </tfoot> --}}
        </table>




        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

        <script src="https://cdn.datatables.net/plug-ins/1.12.1/api/sum().js"></script>
        <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
        </script> -->
        <!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
        </script> -->

        <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
        </script> -->

        <script>
            $(document).ready(function() {

                var t = $('#example').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        // {
                        //     extend: 'print',
                        //     //header: false,
                        //     footer: true,
                        //     text: 'Imprimir',
                        //     title: '',
                        //     messageTop: '',
                        //     customize: function(win) {

                        //     },

                        // },
                        'excel',
                        'csv',
                    ],

                });



                var u = $('#example2').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        // {
                        //     extend: 'print',
                        //     //header: false,
                        //     footer: true,
                        //     text: 'Imprimir',
                        //     title: '',
                        //     messageTop: '',
                        //     customize: function(win) {

                        //     },

                        // },
                        'excel',
                        'csv',
                    ],

                });


            });
        </script>
    </body>

    </html>
@endsection
