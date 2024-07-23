<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "denthub";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$id = $_POST['id'];

$stmt = $conn->prepare("CALL EliminarUsuario(?)");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "Eliminación exitosa";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
