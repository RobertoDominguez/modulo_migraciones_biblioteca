@extends('layouts.template_datatable')

@section('title')
    Materiales Tesis
@endsection

@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Materiales Tesis</title>

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


        <div class="card mb-4">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <i class="fas fa-table mr-1"></i>
                        Materiales Tesis
                    </div>


                </div>


            </div>

            <div class="card-body">
                <div class="table-responsive">
                    {{-- <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"> --}}
                    <table id="example" style="width:100%" class="table table-bordered" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Codigo</th>
                                <th>Titulo</th>
                                <th>FechaPublicacion</th>
                                <th>Idioma</th>
                                <th>Editorial</th>
                                <th>Pais</th>
                                <th>Clasificacion</th>
                                <th>Autor</th>
                                <th>Imagen_URL</th>
                                <th>NumPaginas</th>
                                <th>PDF</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($materiales as $material)
                                <tr>

                                    <td>{{ $material->Id }}</td>
                                    <td>{{ $material->Codigo }}</td>
                                    <td>{{ $material->Titulo }}</td>
                                    <td>{{ $material->FechaPublicacion }}</td>
                                    <td>{{ $material->Idioma }}</td>
                                    <td>{{ $material->Editorial }}</td>
                                    <td>{{ $material->Pais }}</td>
                                    <td>{{ $material->Clasificacion }}</td>
                                    <td>{{ $material->Autor }}</td>
                                    <td>{{ $material->Imagen_Url }}</td>
                                    <td>{{ $material->NumPaginas }}</td>
                                    <td>{{ $material->Pdf_Url }}</td>
                                </tr>
                            @endforeach


                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Codigo</th>
                                <th>Titulo</th>
                                <th>FechaPublicacion</th>
                                <th>Idioma</th>
                                <th>Editorial</th>
                                <th>Pais</th>
                                <th>Clasificacion</th>
                                <th>Autor</th>
                                <th>Imagen_URL</th>
                                <th>NumPaginas</th>
                                <th>PDF</th>
                            </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>







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


            });
        </script>
    </body>

    </html>
@endsection
