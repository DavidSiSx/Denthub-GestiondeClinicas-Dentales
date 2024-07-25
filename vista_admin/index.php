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
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil del Administrador</title>
    <link rel="stylesheet" href="../style/normalize.css">
    <link rel="stylesheet" href="./style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>

<body>
<header>
        <nav>
            <div class="arriba">
                <a class="navbar-brand" href="#">
                    <img src="../img/logo.png" width="100" height="50" alt="">
                </a>
                <div class="navbar_items">
                    <li><a href="./index.php">Home</a></li>
                    <li><a href="./calendario_admin/index.php">Mis citas</a></li>
                    <li><a href="./pacientes/index.php">Pacientes</a></li>
                    <li><a href="./control_de_pagos/index.php">Control de pagos</a></li>
                    <div class="contenedor_icons">
                        <a class="navbar-brand" href="#">
                            <img src="../img/usuario (1).png" alt="" width="30" height="24">
                        </a>
                        <a class="navbar-brand" href="https://www.google.com.mx/maps/preview">
                            <img src="../img/marcador (2).png" alt="" width="30" height="24">
                        </a>
                        <a class="navbar-brand" href="../index.html">
                            <img src="../img/hogar (2).png" alt="" width="30" height="24">
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <div class="container">
        <div class="profile-card">
            <div class="profile-header">
                <img src="../img/usuario (1).png" alt="User Image" class="profile-img">
                <h2>Bienvenid@</h2>
                <p>Doctora <?= htmlspecialchars($admin['nombre']) . ' ' . htmlspecialchars($admin['apellido_paterno']) . ' ' . htmlspecialchars($admin['apellido_materno']); ?></p>
            </div>
            <div class="profile-info">
                <h3>Información</h3>
                <div class="info-item">
                    <p>Correo</p>
                    <span><?= htmlspecialchars($admin['correo']) ?></span>
                </div>
                <div class="info-item">
                    <p>Teléfono</p>
                    <span><?= htmlspecialchars($admin['telefono']) ?></span>
                </div>
                <h3>Información Adicional</h3>
                <div class="info-item">
                    <p>Ocupación</p>
                    <span>Doctora dental</span>
                </div>
                <div class="info-item">
                    <p>Pendientes</p>
                    <?php foreach ($citas as $cita): ?>
                        <span><?= htmlspecialchars($cita['paciente_nombre']) . ' ' . htmlspecialchars($cita['paciente_apellido']) ?> - Cita <?= date('d/m/Y H:i', strtotime($cita['fecha_hora'])) . ' - ' . htmlspecialchars($cita['motivo']); ?></span><br>
                    <?php endforeach; ?>
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
</body>

</html>
