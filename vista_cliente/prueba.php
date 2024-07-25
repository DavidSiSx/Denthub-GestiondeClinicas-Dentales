<?php
session_start();

if (!isset($_SESSION['id_paciente'])) {
    die("No se encontró el usuario.");
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "denthub";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$user_id = $_SESSION['id_paciente'];

// Obtener datos del usuario
$stmt = $conn->prepare("SELECT nombre, apellido_paterno, apellido_materno, usuario, correo, telefono, fecha_nacimiento FROM pacientes WHERE id_paciente = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "No se encontró el usuario.";
    exit();
}

$stmt->close();

// Obtener citas del usuario
$citas_stmt = $conn->prepare("SELECT fecha_hora, motivo FROM citas WHERE id_paciente = ?");
$citas_stmt->bind_param("i", $user_id);
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
    <title>Perfil de Usuario</title>
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
                    <li><a href="#">Home</a></li>
                    <li><a href="./info/index.html">Informacion</a></li>
                    <li><a href="../vista_cliente/administrar_cita/agendar/index.php">Citas</a></li>
                    <li><a href="./servicios/index.html">Servicios</a></li>
                    <div class="contenedor_icons">
                        <a class="navbar-brand" href="../registro_usr/index.html">
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

<div class="container">
    <div class="profile-card">
        <div class="profile-header">
            <img src="../img/usuario (1).png" alt="User Image" class="profile-img">
            <h2>Bienvenid@</h2>
            <p><?= htmlspecialchars($user['nombre']) . ' ' . htmlspecialchars($user['apellido_paterno']) . ' ' . htmlspecialchars($user['apellido_materno']); ?></p>
        </div>
        <div class="profile-info">
            <h3>Información</h3>
            <div class="info-item">
                <p>Correo</p>
                <span><?= htmlspecialchars($user['correo']) ?></span>
            </div>
            <div class="info-item">
                <p>Teléfono</p>
                <span><?= htmlspecialchars($user['telefono']) ?></span>
            </div>
            <div class="info-item">
                <p>Fecha de Nacimiento</p>
                <span><?= htmlspecialchars($user['fecha_nacimiento']) ?></span>
            </div>
            <div class="info-item">
                <p>Usuario</p>
                <span><?= htmlspecialchars($user['usuario']) ?></span>
            </div>
            <h3>Citas</h3>
            <?php if (!empty($citas)): ?>
                <?php foreach ($citas as $cita): ?>
                    <div class="info-item">
                        <p>Cita</p>
                        <span><?= date('d/m/Y H:i', strtotime($cita['fecha_hora'])) . ' - ' . htmlspecialchars($cita['motivo']); ?></span>
                    </div>
                <?php endforeach; ?>
                <div class="update-profile">
                <a href="actualizar_perfil.php" class="btn-primary">Actualizar Perfil</a>
            </div>
            <?php else: ?>
                <div class="info-item">
                    <span>No tienes citas agendadas.</span>
                </div>
            <?php endif; ?>
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
