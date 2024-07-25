<?php
include('../../connection/connection.php');

if (isset($_GET['id_paciente'])) {
    $id_paciente = $_GET['id_paciente'];

    // Eliminar el paciente
    $stmt = $conn->prepare("DELETE FROM pacientes WHERE id_paciente = ?");
    $stmt->bind_param("i", $id_paciente);
    if ($stmt->execute()) {
        header("Location: ./index.php"); // Redirigir a la página de pacientes después de eliminar
    } else {
        echo "Error al eliminar el paciente: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
