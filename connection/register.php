<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost"; // Cambia esto si tu servidor es diferente
$username = "root"; // Cambia esto si tu usuario es diferente
$password = ""; // Cambia esto si tu contraseña es diferente
$dbname = "denthub"; // Cambia esto al nombre de tu base de datos

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los datos del formulario
$nombre = $_POST['nombre'];
$apellido_paterno = $_POST['apellido_paterno'];
$apellido_materno = $_POST['apellido_materno'];
$usuario = $_POST['usuario'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];
$contrasena = password_hash($_POST['contrasena'], PASSWORD_BCRYPT); // Encriptar la contraseña
$fecha_nacimiento = $_POST['fecha_nacimiento'];

// Verificar que todos los campos estén llenos
if (empty($nombre) || empty($apellido_paterno) || empty($usuario) || empty($correo) || empty($telefono) || empty($contrasena) || empty($fecha_nacimiento)) {
    die("Todos los campos son obligatorios.");
}

// Insertar los datos en la base de datos
$sql = "INSERT INTO pacientes (nombre, apellido_paterno, apellido_materno, usuario, correo, telefono, contrasena, fecha_nacimiento, estado)
        VALUES ('$nombre', '$apellido_paterno', '$apellido_materno', '$usuario', '$correo', '$telefono', '$contrasena', '$fecha_nacimiento', 'Inactivo')";

if ($conn->query($sql) === TRUE) {
    echo "Registro exitoso";
} else {
    echo "Error: " . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>


