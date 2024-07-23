<?php
session_start();
include('../../../connection/connection.php');  // Asegúrate de que la ruta a connection.php es correcta

if (isset($_POST['id_paciente']) && isset($_POST['fecha_hora']) && isset($_POST['motivo']) && isset($_POST['comentarios'])) {
    $id_paciente = $_POST['id_paciente'];
    $fecha_hora = $_POST['fecha_hora'];
    $motivo = $_POST['motivo'];
    $comentarios = $_POST['comentarios'];

    // Verificar que el id_paciente existe en la tabla pacientes
    $verificar_paciente = $conn->prepare("SELECT id_paciente FROM pacientes WHERE id_paciente = ?");
    $verificar_paciente->bind_param("i", $id_paciente);
    $verificar_paciente->execute();
    $resultado = $verificar_paciente->get_result();

    if ($resultado->num_rows == 0) {
        die("Error: el id_paciente no existe en la tabla pacientes.");
    }

    $verificar_paciente->close();

    $stmt = $conn->prepare("INSERT INTO citas (id_paciente, fecha_hora, motivo, comentarios) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $id_paciente, $fecha_hora, $motivo, $comentarios);

    if ($stmt->execute()) {
        header("Location: ../index.php"); // Redirige de vuelta a la página principal después de la inserción
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Todos los campos son requeridos.";
}
?>

