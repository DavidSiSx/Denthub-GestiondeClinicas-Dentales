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
                <li><a href="./info/index.html">Informacion</a></li>
                <li><a href="./administrar_cita/agendar/index.php">Citas</a></li>
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
                                        <img src="../img/usuario.png" class="img-radius" alt="User-Profile-Image">
                                    </div>
                                    <h1 class="fw-bold text-center p-4">Bienvenido <?php echo htmlspecialchars($user['nombre']); ?></h1>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="card-block">
                                    <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Información</h6>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <p class="m-b-10 f-w-600">Nombre</p>
                                            <h6 class="text-muted f-w-400"><?php echo htmlspecialchars($user['nombre']); ?></h6>
                                        </div>
                                        <div class="col-sm-6">
                                            <p class="m-b-10 f-w-600">Apellido Paterno</p>
                                            <h6 class="text-muted f-w-400"><?php echo htmlspecialchars($user['apellido_paterno']); ?></h6>
                                        </div>
                                        <div class="col-sm-6">
                                            <p class="m-b-10 f-w-600">Apellido Materno</p>
                                            <h6 class="text-muted f-w-400"><?php echo htmlspecialchars($user['apellido_materno']); ?></h6>
                                        </div>
                                        <div class="col-sm-6">
                                            <p class="m-b-10 f-w-600">Usuario</p>
                                            <h6 class="text-muted f-w-400"><?php echo htmlspecialchars($user['usuario']); ?></h6>
                                        </div>
                                        <div class="col-sm-6">
                                            <p class="m-b-10 f-w-600">Correo</p>
                                            <h6 class="text-muted f-w-400"><?php echo htmlspecialchars($user['correo']); ?></h6>
                                        </div>
                                        <div class="col-sm-6">
                                            <p class="m-b-10 f-w-600">Teléfono</p>
                                            <h6 class="text-muted f-w-400"><?php echo htmlspecialchars($user['telefono']); ?></h6>
                                        </div>
                                        <div class="col-sm-6">
                                            <p class="m-b-10 f-w-600">Fecha de Nacimiento</p>
                                            <h6 class="text-muted f-w-400"><?php echo htmlspecialchars($user['fecha_nacimiento']); ?></h6>
                                        </div>
                                    </div>
                                    <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600">Citas</h6>
                                    <div class="row">
                                        <?php if (!empty($citas)): ?>
                                            <?php foreach ($citas as $cita): ?>
                                                <div class="col-sm-6">
                                                    <p class="m-b-10 f-w-600">Cita</p>
                                                    <h6 class="text-muted f-w-400"><?php echo date('d/m/Y H:i', strtotime($cita['fecha_hora'])) . ' - ' . htmlspecialchars($cita['motivo']); ?></h6>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div class="col-sm-12">
                                                <h6 class="text-muted f-w-400">No tienes citas agendadas.</h6>
                                            </div>
                                        <?php endif; ?>
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
</body>
</html>
