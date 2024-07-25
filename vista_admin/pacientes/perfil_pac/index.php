<?php
session_start();
include('../../../connection/connection.php');

$id_paciente = $_GET['id_paciente'];

// Consulta para obtener los datos del paciente
$sql_paciente = "SELECT nombre, apellido_paterno, apellido_materno, fecha_nacimiento, telefono, correo FROM pacientes WHERE id_paciente = ?";
$stmt_paciente = $conn->prepare($sql_paciente);
$stmt_paciente->bind_param("i", $id_paciente);
$stmt_paciente->execute();
$result_paciente = $stmt_paciente->get_result();

if ($result_paciente->num_rows > 0) {
    $paciente = $result_paciente->fetch_assoc();
} else {
    echo "No se encontraron datos del paciente.";
    exit();
}

// Consulta para obtener el historial de citas del paciente
$sql_citas = "SELECT fecha_hora, motivo FROM citas WHERE id_paciente = ? ORDER BY fecha_hora DESC";
$stmt_citas = $conn->prepare($sql_citas);
$stmt_citas->bind_param("i", $id_paciente);
$stmt_citas->execute();
$result_citas = $stmt_citas->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil del Paciente</title>
    <link rel="preload" href="../../../style/style.css">
    <link rel="preload" href="../../../style/normalize.css">
    <link rel="stylesheet" href="../../../style/style.css">
    <link rel="stylesheet" href="../../../style/normalize.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
</head>
<body>
<header>
    <nav>
        <div class="arriba">
            <a class="navbar-brand" href="#">
                <img src="/img/logo.png" width="100" height="50" alt="">
            </a>
            <div class="navbar_items">
                <li><a href="../../index.php">Home</a></li>
                <li><a href="../../calendario_admin/index.php">Mis Citas</a></li>
                <li><a href="../index.php">Pacientes</a></li>
                <li><a href="../../control_de_pagos/index.php">Control de pagos</a></li>
                <div class="contenedor_icons">
                    <a class="navbar-brand" href="../registro/index.html">
                        <img src="../../../img/usuario (1).png" alt="" width="30" height="24">
                    </a>
                    <a class="navbar-brand" href="https://www.google.com.mx/maps/preview">
                        <img src="../../../img/marcador (2).png" alt="" width="30" height="24">
                    </a>
                    <a class="navbar-brand" href="#">
                        <img src="../../../img/hogar (2).png" alt="" width="30" height="24">
                    </a>
                </div>
            </div>
        </div>
    </nav>
</header>

<div class="card-grid">
    <div class="card1">
        <h2>Datos personales</h2>
        <div class="card-bodye">
            <p><strong>Nombre:</strong> <?= htmlspecialchars($paciente['nombre'] . ' ' . $paciente['apellido_paterno'] . ' ' . $paciente['apellido_materno']) ?></p>
            <p><strong>Fecha de nacimiento:</strong> <?= htmlspecialchars($paciente['fecha_nacimiento']) ?></p>
            <p><strong>Teléfono:</strong> <?= htmlspecialchars($paciente['telefono']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($paciente['correo']) ?></p>
        </div>
    </div>

    <div class="card1">
        <h2>Historial dental</h2>
        <div class="card-bodye">
            <?php if ($result_citas->num_rows > 0): ?>
                <?php while($cita = $result_citas->fetch_assoc()): ?>
                    <p><strong>Fecha:</strong> <?= (new DateTime($cita['fecha_hora']))->format('Y-m-d') ?></p>
                    <p><strong>Hora:</strong> <?= (new DateTime($cita['fecha_hora']))->format('H:i') ?></p>
                    <p><strong>Motivo:</strong> <?= htmlspecialchars($cita['motivo']) ?></p>
                    <hr>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No hay citas registradas.</p>
            <?php endif; ?>
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

<?php
$stmt_paciente->close();
$stmt_citas->close();
$conn->close();
?>
