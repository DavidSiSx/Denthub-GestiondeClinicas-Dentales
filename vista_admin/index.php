<?php
session_start();
include('../connection/connection.php');

$id_administrador = $_SESSION['id_administrador'];

$stmt = $conn->prepare("SELECT nombre, apellido_paterno, apellido_materno, correo, telefono FROM administradores WHERE id_administrador = ?");
$stmt->bind_param("i", $id_administrador);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $admin = $result->fetch_assoc();
} else {
    echo "No se encontraron datos del administrador.";
    exit();
}

$stmt->close();

// Obtener citas pendientes con nombre de paciente
$citas_stmt = $conn->prepare(" SELECT c.fecha_hora, c.motivo, p.nombre AS paciente_nombre, p.apellido_paterno AS paciente_apellido
    FROM citas c
    JOIN pacientes p ON c.id_paciente = p.id_paciente
    WHERE c.estado = 'Pendiente'
    ORDER BY c.fecha_hora
   
");
$citas_stmt->execute();
$citas_result = $citas_stmt->get_result();

$citas = [];
if ($citas_result->num_rows > 0) {
    while ($row = $citas_result->fetch_assoc()) {
        $citas[] = $row;
    }
}

$citas_stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil del Administrador</title>
    <link rel="preload" href="../style/style.css">
    <link rel="preload" href="../style/normalize.css">
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/normalize.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <nav>
            <div class="arriba">
                <a class="navbar-brand" href="#">
                    <img src="../img/logo.png" width="100" height="50" alt="">
                </a>
                <div class="navbar_items">
                    <li><a href="../index.html">Home</a></li>
                    <li><a href="./calendario_admin/index.php">Mis citas</a></li>
                    <li><a href="./Pacientes/index.php">Pacientes</a></li>
                    <li><a href="./control_de_pagos/index.php">Control de pagos</a></li>
                    <div class="contenedor_icons">
                        <a class="navbar-brand" href="../registro/index.html">
                            <img src="../img/usuario (1).png" alt="" width="30" height="24">
                        </a>
                        <a class="navbar-brand" href="https://www.google.com.mx/maps/preview">
                            <img src="../img/marcador (2).png" alt="" width="30" height="24">
                        </a>
                        <a class="navbar-brand" href="#">
                            <img src="../img/hogar (2).png" alt="" width="30" height="24">
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <div class="cardbody">
        <div class="page-content page-container" id="page-content">
            <div class="padding">
                <div class="row container d-flex justify-content-center">
                    <div class="col-xl-6 col-md-12">
                        <div class="card user-card-full">
                            <div class="row m-l-0 m-r-0">
                                <div class="col-sm-4 bg-c-lite-green user-profile">
                                    <div class="card-block text-center text-white">
                                        <div class="m-b-25">
                                            <img src="../img/usuario (1).png" class="img-radius" alt="User-Profile-Image">
                                        </div>
                                        <div class="nombre">
                                            <h6 class="f-w-600">Bienvenid@</h6>
                                            <p>Doctora <?= htmlspecialchars($admin['nombre']) . ' ' . htmlspecialchars($admin['apellido_paterno']) . ' ' . htmlspecialchars($admin['apellido_materno']); ?></p>
                                            <i class=" mdi mdi-square-edit-outline feather icon-edit m-t-10 f-16"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="card-block">
                                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Información</h6>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p class="m-b-10 f-w-600">Correo</p>
                                                <h6 class="text-muted f-w-400"><?= htmlspecialchars($admin['correo']) ?></h6>
                                            </div>
                                            <div class="col-sm-6">
                                                <p class="m-b-10 f-w-600">Teléfono</p>
                                                <h6 class="text-muted f-w-400"><?= htmlspecialchars($admin['telefono']) ?></h6>
                                            </div>
                                        </div>
                                        <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600">Información Adicional</h6>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p class="m-b-10 f-w-600">Ocupación</p>
                                                <h6 class="text-muted f-w-400">Doctora dental</h6>
                                            </div>
                                            <div class="col-sm-6">
                                                <p class="m-b-10 f-w-600">Pendientes</p>
                                                <?php foreach ($citas as $cita): ?>
                                                    <h6 class="text-muted f-w-400">
                                                        <?= htmlspecialchars($cita['paciente_nombre']) . ' ' . htmlspecialchars($cita['paciente_apellido']) ?> - Cita <?= date('d/m/Y H:i', strtotime($cita['fecha_hora'])) . ' - ' . htmlspecialchars($cita['motivo']); ?>
                                                    </h6>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <div class="footer-container">
            <ul>
                <li><a href="#aviso-privacidad">Aviso de privacidad</a></li>
                <li><a href="#terminos-y-condiciones">Términos y condiciones</a></li>
                <li><a href="#mapa-de-sitio">Mapa de sitio</a></li>
            </ul>
            <p>&copy; 2023 Dentavida. Todos los derechos reservados.</p>
        </div>
    </footer>

    <!-- Contenido de Aviso de privacidad -->
    <div id="aviso-privacidad">
        <h2>Aviso de privacidad</h2>
        <p>Este sitio web utiliza cookies para mejorar su experiencia. Al continuar navegando, acepta nuestra política de privacidad.</p>
    </div>

    <!-- Contenido de Términos y condiciones -->
    <div id="terminos-y-condiciones">
        <h2>Términos y condiciones</h2>
        <p>Al utilizar este sitio web, acepta nuestros términos y condiciones.</p>
    </div>

    <!-- Contenido de Mapa de sitio -->
    <div id="mapa-de-sitio">
        <h2>Mapa de sitio</h2>
        <ul>
            <li><a href="#">Inicio</a></li>
            <li><a href="#">Servicios</a></li>
            <li><a href="#">Acerca de</a></li>
            <li><a href="#">Contacto</a></li>
        </ul>
    </div>
</body>

</html>
