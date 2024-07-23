<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "denthub";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$result = $conn->query("CALL LeerUsuarios()");

$usuarios = array();
while($row = $result->fetch_assoc()) {
    $usuarios[] = $row;
}

echo json_encode($usuarios);

$result->close();
$conn->close();
?>
