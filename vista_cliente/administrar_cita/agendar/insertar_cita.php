<?php
session_start();
include('../../../connection/connection.php');

$id_paciente = $_SESSION['id_paciente'];
$fecha_hora = $_POST['fecha_hora'];
$motivo = $_POST['motivo'];
$comentarios = $_POST['comentarios'];

$stmt = $conn->prepare("INSERT INTO citas (id_paciente, fecha_hora, motivo, comentarios) VALUES (?, ?, ?, ?)");
$stmt->bind_param("isss", $id_paciente, $fecha_hora, $motivo, $comentarios);

if ($stmt->execute()) {
    header("Location: ./index.php"); // Redirigir a la página de citas del usuario
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
