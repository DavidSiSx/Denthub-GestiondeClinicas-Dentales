<?php
include('../../../connection/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_cita = $_POST['id_cita'];
    $fecha_hora = $_POST['fecha_hora'];

    // Actualizar la cita
    $stmt = $conn->prepare("UPDATE citas SET fecha_hora = ? WHERE id_cita = ?");
    $stmt->bind_param("si", $fecha_hora, $id_cita);

    if ($stmt->execute()) {
        header("Location: ./index.php"); // Redirigir a la página de citas después de actualizar
    } else {
        echo "Error al actualizar la cita: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
