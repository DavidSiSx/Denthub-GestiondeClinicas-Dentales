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
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="../style/style.css"> <!-- Asegúrate de enlazar correctamente tu archivo CSS -->
</head>
<body>
<header>
    <!-- Aquí va tu código de header -->
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
                                    <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600">Información</h6>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <p class="m-b-10 f-w-600">Ocupación</p>
                                            <h6 class="text-muted f-w-400">Estudiante</h6>
                                        </div>
                                        <!-- Agrega más campos aquí si es necesario -->
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
</body>
</html>
