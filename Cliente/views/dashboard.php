<?php

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header('Location: ../../index.html');
    exit;
}

$nombre = isset($_SESSION['nombres']) ? $_SESSION['nombres'] : null;
$rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aseguradora Grupo Asistencia</title>

    <!-- Boostrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    
    <!-- Iconos -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />

    <!-- Estilos CSS -->
    <link rel="stylesheet" href="../assets//css/dashboard.css">

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Icono -->
    <link rel="icon" type="png" href="../public/images/icon-page.ico">

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
</head>
<body>
    
    <div class="wrapper">

        <!-- Sidebar -->
        <aside id="sidebar">

            <!-- titulo e icono -->
            <div class="d-flex justify-content-between p-3">
                <div class="sidebar-logo">
                    <!-- <a href="#">Pos</a> -->
                     <img src="../public/images/Logo-Grupo-Asistencia.png" alt="logo pos" style="width: 125px; height: 50px;">
                </div>

                <button class="toggle-btn border-0" type="button">
                    <i id="icon" class='bx bxs-chevrons-right'></i>
                </button>
            </div>

            <!-- Lista de navegación -->
            <ul class="sidebar-nav">

                <!-- Nueva venta / acceso rapido -->
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link plus" data-page="cotizar">
                        <i class='bx bxs-plus-circle'></i>
                        <span>Asegurar Ahora</span>
                    </a>
                </li>
                <br>

                <!-- Home -->
                <li class="sidebar-item ">
                    <a href="#" class="sidebar-link" data-page="dashboard" data-page="dashboard">
                        <i class='bx bxs-home-heart'></i>
                        <span>Home</span>
                    </a>
                </li>

                <!-- Ventas -->
                <li class="sidebar-item"> <!-- Collapse boostrap-->
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                        <i class='bx bx-shield-plus'></i>
                        <span>Asegurar</span>
                    </a>

                    <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link" data-page="cotizar">
                                Asegurar 
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link" data-page="historial">
                                Historial
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Clientes -->
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#multi" aria-expanded="false" aria-controls="multi">
                        <i class='bx bx-user-pin' ></i>
                        <span>Planes</span>
                    </a>

                    <ul id="multi" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link" data-page="new_plan">
                                Añadir Plan
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link" data-page="planes">
                                Planes Activos
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Reportes -->
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link" data-page="not-found">
                        <i class='bx bxs-file-plus'></i>
                        <span>Reportes</span>
                    </a>
                </li>
                <br>

                <!-- Soporte -->
                <li class="sidebar-item">
                    <a href="https://wa.me/573156090468" target="_blank" class="sidebar-link">
                        <i class='bx bxs-chat'></i>
                        <span>Soporte / Chat</span>
                    </a>
                </li>

                <!-- Ajustes -->
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link" data-page="not-found">
                        <i class='bx bxs-cog'></i>
                        <span>Ajustes</span>
                    </a>
                </li>

            </ul>

        </aside>

        <!-- Prinicipal-->
        <div class="main">

            <!-- Navbar menu -->
            <nav class="navbar navbar-expand px-4 py-3">

                

                <!-- Selecciona Sucursal --> <!-- Oculta a moviles -->
                <div class="sidebar-link dropdown d-none d-sm-inline-block ms-3 bg-light p-1 border">
                    <select class="form-select form-select-sm bg-transparent border-0 text-primary" aria-label="Seleccionar sucursal">
                        <option value="" selected>Sucursal principal</option>
                        <option value="" disabled>Proximamente...</option>
                    </select>
                </div>

                <!-- Nombre e imagen usuario -->
                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown d-flex align-items-center">

                            <!-- Nombre empresa -->
                            <span class="me-3"><?= $rol.' '.$nombre?></span>

                            <!-- Icono notificacion -->
                            <div class="dropdown me-4">
                                <a href="#" class="position-relative" data-bs-toggle="dropdown">
                                    <i class='bx bxs-bell-ring' style="color: #1868b8;"></i>
                                    <span class="badge bg-primary rounded-circle ms-2 position-absolute top-0 start-100 translate-middle">2</span>
                                </a>
                                
                                <div class="dropdown-menu dropdown-menu-end rounded-0 border-0 shadow mt-3" style="width: 250px;">
                                    <div class="dropdown-header d-flex justify-content-between align-items-center px-3 py-2 border-bottom">
                                        <h6 class="mb-0 fw-bold">Notificaciones</h6>
                                        <!-- <a href="#" class="text-muted small">Marcar todas como leídas</a> -->
                                    </div>
                                    
                                    
                                    
                                    <!-- Notificación 2 -->
                                    <a href="#" class="dropdown-item d-flex py-3 border-bottom">
                                        <div class="flex-shrink-0">
                                            <i class='bx bxs-cart-download text-success fs-4'></i>
                                        </div>
                                        <div class="ps-3">
                                            <span class="d-block fw-bold">Ase. Activas</span>
                                            <small class="text-muted">2 productos</small>
                                        </div>
                                    </a>
                                    
                                    <!-- Notificación 3 -->
                                    <a href="#" class="dropdown-item d-flex py-3">
                                        <div class="flex-shrink-0">
                                            <i class='bx bxs-error-circle text-danger fs-4'></i>
                                        </div>
                                        <div class="ps-3">
                                            <span class="d-block fw-bold">Ase. Pendientes</span>
                                            <small class="text-muted">2 facturas</small>
                                            <!-- <small class="text-muted">Hace 3 horas</small> -->
                                        </div>
                                    </a>
                                    
                                    <div class="dropdown-footer text-center p-2 border-top">
                                        <a href="#" class="text-decoration-none">Todas las notificaciones</a>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- img, nombre cliente -->
                            <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0">
                                <img src="../public/images/default-user.png" alt="usuario-panel" class="avatar img-fluid">
                            </a>

                            <!-- detalles img, nombre cliente -->
                            <div class="dropdown-menu dropdown-menu-end rounded-0 border-0 shadow mt-3"  style="width: 250px;">
                                <div class="dropdown-header d-flex  align-items-center px-3 py-2 border-bottom">
                                    <img src="../public/images/default-user.png" alt="usuario-panel" class="avatar img-fluid me-2">
                                    <h6 class="mb-0 fw-bold text-center"><?=htmlspecialchars($nombre)?></h6>
                                    <!-- <a href="#" class="text-muted small">Marcar todas como leídas</a> -->
                                </div>

                                <a href="https://www.grupoasistencia.com/Politicas-Privacidad/Aviso_de_Privacidad_Seguros_Grupo_Asistencia_Ltda.pdf" target="_blank" class="dropdown-item ">
                                    <i class='bx bxs-file'></i>
                                    <span>Terminos y condiciones</span>
                                </a>

                                <div class="dropdown-divider"></div>
                                <a href="../../index.html" class="dropdown-item text-danger">
                                    <i class='bx bx-power-off'></i>
                                    <span>Cerrar sesión</span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Pricipal datos -->
            <main class="content px-3 py-4">
                <div class="container-fluid">

                    <div class="mb-3">
                        <h3 class="fw-bold fs-4 mb-3 ">
                            Dashboard - Vista <button type="button" class="btn btn-outline-primary btn-sm ms-2">Semana</button>
                        </h3>

                        <!-- Datos cards -->
                        <div class="row">
                            <div class="col-12 col-md-4 ">  
                                <div class="card cards shadow">
                                    <div class="card-body py-4">
                                        <h6 class="mb-2 fw-bold d-flex align-items-center gap-2">
                                            <animated-icons
                                              src="https://animatedicons.co/get-icon?name=analytics&style=minimalistic&token=2bdff727-9a4f-41a9-8222-312ccd145207"
                                              trigger="loop"
                                              attributes='{"variationThumbColour":"#536DFE","variationName":"Two Tone","variationNumber":2,"numberOfGroups":2,"backgroundIsGroup":false,"strokeWidth":1,"defaultColours":{"group-1":"#000000","group-2":"#536DFE","background":"#FFFFFF"}}'
                                              height="25"
                                              width="25"
                                            ></animated-icons> 
                                            Aseguraciones Totales
                                        </h6>

                                        <p class="mb-2 text-success">
                                            $ 450.000 COP
                                        </p>

                                        <div class="mb-0">
                                            <span class="text-secondary">
                                                15 Facturas emitidas
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="card cards shadow">
                                    <div class="card-body py-4">
                                        <h6 class="mb-2 fw-bold d-flex align-items-center gap-2">
                                            <animated-icons
                                            src="https://animatedicons.co/get-icon?name=Car&style=minimalistic&token=8467715e-7688-4324-a72a-baa5aa8ec02e"
                                            trigger="loop"
                                            attributes='{"variationThumbColour":"#536DFE","variationName":"Two Tone","variationNumber":2,"numberOfGroups":2,"backgroundIsGroup":false,"strokeWidth":1,"defaultColours":{"group-1":"#000000","group-2":"#536DFE","background":"#FFFFFF"}}'
                                            height="25"
                                            width="25"
                                            ></animated-icons>
                                            Vehículos asegurados
                                        </h6>

                                        <p class="mb-2 text-secondary">
                                            1. Panadería Integral (25 uds)
                                        </p>

                                        <div class="mb-0">
                                            <span class="text-secondary">
                                                2. Gaseosa 600ml (20 uds)...
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="card cards shadow">
                                    <div class="card-body py-4">
                                        <h6 class="mb-2 fw-bold d-flex align-items-center gap-2">
                                            <animated-icons
                                                src="https://animatedicons.co/get-icon?name=Podium&style=minimalistic&token=f90800ee-9af0-4a62-ba49-21fa1e12e923"
                                                trigger="loop"
                                                attributes='{"variationThumbColour":"#536DFE","variationName":"Two Tone","variationNumber":2,"numberOfGroups":2,"backgroundIsGroup":false,"strokeWidth":1,"defaultColours":{"group-1":"#000000","group-2":"#536DFE","background":"#FFFFFF"}}'
                                                height="25"
                                                width="25"
                                            ></animated-icons> 
                                            Vehículos Activos
                                        </h6>

                                        <p class="mb-2 text-success">
                                            $ 150.000 COP
                                        </p>

                                        <div class="mb-0">
                                            <span class="text-secondary">
                                                Costo: $300.000 / Utilidad: $450.000
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Datos cards -->
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <div class="card cards shadow">
                                    <div class="card-body py-4">
                                        <h6 class="mb-2 fw-bold d-flex align-items-center gap-2">
                                            <animated-icons
                                                src="https://animatedicons.co/get-icon?name=user%20profile&style=minimalistic&token=9b327b61-1433-451f-a476-148402217e82"
                                                trigger="loop"
                                                attributes='{"variationThumbColour":"#536DFE","variationName":"Two Tone","variationNumber":2,"numberOfGroups":2,"backgroundIsGroup":false,"strokeWidth":1,"defaultColours":{"group-1":"#000000","group-2":"#536DFE","background":"#FFFFFF"}}'
                                                height="25"
                                                width="25"
                                            ></animated-icons>
                                            Clientes Activos
                                        </h6>

                                        <p class="mb-2 text-success">
                                            Aprobadas: 13
                                        </p>

                                        <div class="mb-0">
                                            <span class="text-muted">
                                                Pendientes: 0 
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="card cards shadow">
                                    <div class="card-body py-4">
                                        <h6 class="mb-2 fw-bold d-flex align-items-center gap-2">
                                            <animated-icons
                                            src="https://animatedicons.co/get-icon?name=Archive&style=minimalistic&token=0c93ad53-7a21-4237-831d-5173da67987d"
                                            trigger="loop"
                                            attributes='{"variationThumbColour":"#536DFE","variationName":"Two Tone","variationNumber":2,"numberOfGroups":2,"backgroundIsGroup":false,"strokeWidth":1,"defaultColours":{"group-1":"#000000","group-2":"#536DFE","background":"#FFFFFF"}}'
                                            height="25"
                                            width="25"
                                            ></animated-icons>
                                            Cuentas por cobrar
                                        </h6>

                                        <p class="mb-2 text-success">
                                            Créditos activos
                                        </p>

                                        <div class="mb-0">
                                            <span class="text-muted">
                                                $1.000.000 por cobrar
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="card cards shadow">
                                    <div class="card-body py-4">
                                        <h6 class="mb-2 fw-bold d-flex align-items-center gap-2">
                                            <animated-icons
                                                src="https://animatedicons.co/get-icon?name=search&style=minimalistic&token=12e9ffab-e7da-417f-a9d9-d7f67b64d808"
                                                trigger="loop"
                                                attributes='{"variationThumbColour":"#536DFE","variationName":"Two Tone","variationNumber":2,"numberOfGroups":2,"backgroundIsGroup":false,"strokeWidth":1,"defaultColours":{"group-1":"#000000","group-2":"#536DFE","background":"#FFFFFF"}}'
                                                height="25"
                                                width="25"
                                            ></animated-icons>
                                            Aseguraciones en Revisión
                                        </h6>

                                        <p class="mb-2 text-success">
                                            Total en caja: $330.000
                                        </p>

                                        <div class="mb-0">
                                            <!-- <span class="bagde text-success me-2">
                                                +9.0%
                                            </span> -->
                                            <span class="text-muted">
                                                Turnos sin cerrar: 1
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Datos cards -->
                        <div class="row">
                            <div class="col-12 col-md-7">
                                <h3 class="fw-bold fs-4 my-3 ">Sucursales</h3>

                                <!-- tabla de datos -->
                                <table class="table table-striped">
                                    <thead>
                                        <tr class="destacar">
                                            <th scope="col">#</th>
                                            <th scope="col">Usuario</th>
                                            <th scope="col">Sucursal</th>
                                            <th scope="col">Estado turno</th>
                                            <th scope="col">Hora</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>Marcar O.</td>
                                            <td>Principal</td>
                                            <td>🟢 Abierto</td>
                                            <td>10:00 AM</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">2</th>
                                            <td>Jacob T.</td>
                                            <td>Norte	</td>
                                            <td>🟢 Abierto</td>
                                            <td>10:00 AM</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">3</th>
                                            <td >Larry Pájaro</td>
                                            <td>Express</td>
                                            <td>🔴 Cerrado</td>
                                            <td>10:00 AM</td>
                                        </tr>
                                      </tbody>
                                </table>
                            
                            </div>

                            <div class="col-12 col-md-5">
                                <h3 class="fw-bold fs-4 my-3">
                                    Reportes generales
                                </h3>

                                <!-- Graficas chart.js-->
                                <canvas id="bar-chart-horizontal" width="800" height="450"></canvas>
                            </div>

                        </div>

                    </div>

                </div>
            </main>
            

            

        </div>

    </div>

    <!-- Js general -->
    <script src="../assets/utils/script.js"></script>

    <!-- Chart.js, graficas-->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- iconos animados  -->
    <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>

    <!-- Boostrap 5-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>
</html>