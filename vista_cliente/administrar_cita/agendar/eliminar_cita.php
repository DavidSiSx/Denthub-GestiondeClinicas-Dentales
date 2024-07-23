<?php
include('../../../connection/connection.php');  // Asegúrate de que la ruta a conexion.php es correcta

$id_cita = $_POST['id_cita'];

$stmt = $conn->prepare("DELETE FROM citas WHERE id_cita = ?");
$stmt->bind_param("i", $id_cita);

if ($stmt->execute()) {
    header("Location: ../index.php"); // Redirige de vuelta a la página principal después de la eliminación
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
