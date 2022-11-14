<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Sistema de Biblioteca</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet"
        crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="index.html">Sistema de Biblioteca</a><button
            class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i
                class="fas fa-bars"></i></button><!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            {{-- <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search"
                    aria-describedby="basic-addon2" />
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                </div>
            </div> --}}
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                        class="fas fa-user fa-fw"></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    {{-- <a class="dropdown-item" href="#">Settings</a>
                    <a class="dropdown-item" href="#">Activity Log</a> --}}
                    {{-- <div class="dropdown-divider"></div> --}}
                    <form action="{{ route('logout.form') }}" method="POST">
                        {{ csrf_field() }}
                        <button class="dropdown-item">Cerrar Sesion</button>
                    </form>
                </div>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Modulo de inventario</div>
                        <a class="nav-link" href="{{ route('inventario.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Inventarios
                        </a>


                        <div class="sb-sidenav-menu-heading">Modulo de migraciones</div>
                        <a class="nav-link collapsed" href="#" data-toggle="collapse"
                            data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Migraciones
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                            data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ route('migracion.material') }}">Migrar Materiales</a>
                                <a class="nav-link" href="{{ route('migracion.persona') }}">Migrar Personas</a>
                            </nav>
                        </div>


                        <div class="sb-sidenav-menu-heading">Modulo de Reportes</div>
                        <a class="nav-link collapsed" href="#" data-toggle="collapse"
                            data-target="#collapseLayouts2" aria-expanded="false" aria-controls="collapseLayouts2">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Prestamos
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts2" aria-labelledby="headingOne"
                            data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ route('reporte.prestamo.mensual') }}">Prestamos mensuales</a>
                                <a class="nav-link" href="{{ route('reporte.prestamo.anual') }}">Prestamos anuales</a>
                            </nav>
                        </div>


                        <div class="sb-sidenav-menu-heading">Modulo de Exportacion</div>
                        <a class="nav-link collapsed" href="#" data-toggle="collapse"
                            data-target="#collapseLayouts3" aria-expanded="false" aria-controls="collapseLayouts3">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Exportar Ejemplares
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts3" aria-labelledby="headingOne"
                            data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ route('exportacion.ejemplares.libros') }}">Libros</a>
                                <a class="nav-link" href="{{ route('exportacion.ejemplares.revistas') }}">Revistas</a>
                                <a class="nav-link" href="{{ route('exportacion.ejemplares.tesis') }}">Tesis</a>
                            </nav>
                        </div>

                       <a class="nav-link collapsed" href="#" data-toggle="collapse"
                            data-target="#collapseLayouts4" aria-expanded="false" aria-controls="collapseLayouts4">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Exportar Materiales
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts4" aria-labelledby="headingOne"
                            data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ route('exportacion.materiales.libros') }}">Libros</a>
                                <a class="nav-link" href="{{ route('exportacion.materiales.revistas') }}">Revistas</a>
                                <a class="nav-link" href="{{ route('exportacion.materiales.tesis') }}">Tesis</a>
                            </nav>
                        </div>

                        <div class="sb-sidenav-menu-heading">Modulo de Administracion</div>
                        <a class="nav-link collapsed" href="#" data-toggle="collapse"
                            data-target="#collapseLayouts5" aria-expanded="false" aria-controls="collapseLayouts5">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Ejemplares
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts5" aria-labelledby="headingOne"
                            data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ route('administracion.ejemplares.materiales') }}">Nuevo Ejemplar</a>
                                <a class="nav-link" href="{{ route('administracion.ejemplares.index_libros') }}">Libros</a>
                                <a class="nav-link" href="{{ route('administracion.ejemplares.index_revistas') }}">Revistas</a>
                                <a class="nav-link" href="{{ route('administracion.ejemplares.index_tesis') }}">Tesis</a>                                
                            </nav>
                        </div>

                        
                        {{-- <div class="sb-sidenav-menu-heading">Addons</div>
                        <a class="nav-link" href="charts.html">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Charts
                        </a><a class="nav-link" href="tables.html">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Tables
                        </a> --}}


                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Registrado como:</div>
                    Administrator
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">@yield('title')</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">@yield('title')</li>
                    </ol>



                    @yield('content')

                </div>
            </main>
            {{-- <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2019</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer> --}}
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('assets/demo/chart-bar-demo.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/demo/datatables-demo.js') }}"></script>
</body>

</html>
