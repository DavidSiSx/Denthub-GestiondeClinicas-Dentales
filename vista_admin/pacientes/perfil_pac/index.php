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
    <link rel="stylesheet" href="../../../style/normalize.css">
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
                <img src="../../../img/logo.png" width="100" height="50" alt="">
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

<div class="container">
    <div class="profile-card">
        <div class="profile-header">
            <h2>Perfil del Paciente</h2>
        </div>
        <div class="profile-info">
            <h3>Datos personales</h3>
            <div class="info-item">
                <p><strong>Nombre:</strong> <?= htmlspecialchars($paciente['nombre'] . ' ' . $paciente['apellido_paterno'] . ' ' . $paciente['apellido_materno']) ?></p>
                <p><strong>Fecha de nacimiento:</strong> <?= htmlspecialchars($paciente['fecha_nacimiento']) ?></p>
                <p><strong>Teléfono:</strong> <?= htmlspecialchars($paciente['telefono']) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($paciente['correo']) ?></p>
            </div>
            <h3>Historial dental</h3>
            <div class="info-item">
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
            <h3>Expediente</h3>
            <div class="info-item">
                <?php if (is_array($expediente)): ?>
                    <?php foreach ($expediente as $item): ?>
                        <p><?= htmlspecialchars($item['descripcion']) ?></p>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p><?= htmlspecialchars($expediente) ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<footer class="bg_footer">
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

<?php
$stmt_paciente->close();
$stmt_citas->close();
$conn->close();
?>
