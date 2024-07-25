<?php
session_start();
include('../../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_cita = $_POST['id_cita'];

    // Consulta para eliminar la cita
    $stmt = $conn->prepare("DELETE FROM citas WHERE id_cita = ?");
    $stmt->bind_param("i", $id_cita);

    if ($stmt->execute()) {
        header("Location: ../../vista_admin/index.php"); // Redirigir después de la eliminación
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    exit();
}
?>
