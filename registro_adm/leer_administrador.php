<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "denthub";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$result = $conn->query("CALL LeerAdministradores()");

$administradores = array();
while($row = $result->fetch_assoc()) {
    $administradores[] = $row;
}

echo json_encode($administradores);

$result->close();
$conn->close();
?>
