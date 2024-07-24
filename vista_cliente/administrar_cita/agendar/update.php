<?php
include('../../../conexion.php');  // Asegúrate de que la ruta a conexion.php es correcta

$id_cita = $_POST['id_cita'];
$fecha_hora = $_POST['fecha_hora'];
$motivo = $_POST['motivo'];
$comentarios = $_POST['comentarios'];

$stmt = $conn->prepare("UPDATE citas SET fecha_hora = ?, motivo = ?, comentarios = ? WHERE id_cita = ?");
$stmt->bind_param("sssi", $fecha_hora, $motivo, $comentarios, $id_cita);

if ($stmt->execute()) {
    header("Location: ../index.php"); // Redirige de vuelta a la página principal después de la actualización
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
