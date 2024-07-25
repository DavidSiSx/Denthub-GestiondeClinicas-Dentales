<?php
session_start();
include('../connection/connection.php');

if (!isset($_SESSION['id_paciente'])) {
    die("No se encontró el usuario.");
}

$user_id = $_SESSION['id_paciente'];

// Obtener datos actuales del usuario
$stmt = $conn->prepare("SELECT correo, telefono, usuario FROM pacientes WHERE id_paciente = ?");
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $usuario = $_POST['usuario'];

    $update_stmt = $conn->prepare("UPDATE pacientes SET correo = ?, telefono = ?, usuario = ? WHERE id_paciente = ?");
    $update_stmt->bind_param("sssi", $correo, $telefono, $usuario, $user_id);

    if ($update_stmt->execute()) {
        header("Location: prueba.php"); // Redirigir al perfil del usuario
    } else {
        echo "Error: " . $update_stmt->error;
    }

    $update_stmt->close();
    $conn->close();
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Perfil</title>
    <link rel="stylesheet" href="../style/normalize.css">
    <link rel="stylesheet" href="./actua.css">
</head>
<body>
<header>
        <nav>
            <div class="arriba">
                <a class="navbar-brand" href="#">
                    <img src="../img/logo.png" width="100" height="50" alt="">
                </a>
                <div class="navbar_items">
                    <li><a href="./prueba.php">Home</a></li>
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
    <div class="update-profile-card">
        <h2>Actualizar Perfil</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="correo">Correo</label>
                <input type="email" name="correo" id="correo" value="<?= htmlspecialchars($user['correo']) ?>" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="tel" name="telefono" id="telefono" value="<?= htmlspecialchars($user['telefono']) ?>" required>
            </div>
            <div class="form-group">
                <label for="usuario">Usuario</label>
                <input type="text" name="usuario" id="usuario" value="<?= htmlspecialchars($user['usuario']) ?>" required>
            </div>
            <button type="submit" class="btn-primary">Actualizar</button>
        </form>
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
