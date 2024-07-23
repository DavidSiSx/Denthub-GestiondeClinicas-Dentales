<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "denthub";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$nombre = $_POST['nombre'];
$apellido_paterno = $_POST['apellido_paterno'];
$apellido_materno = $_POST['apellido_materno'];
$correo = $_POST['correo'];
$contrasena = password_hash($_POST['contrasena'], PASSWORD_BCRYPT);

$stmt = $conn->prepare("CALL CrearAdministrador(?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $nombre, $apellido_paterno, $apellido_materno, $correo, $contrasena);

if ($stmt->execute()) {
    header("Location: index.html"); // Ajusta la ruta según sea necesario
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
