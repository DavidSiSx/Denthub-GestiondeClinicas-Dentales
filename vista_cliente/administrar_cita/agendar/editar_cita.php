<?php
include('../../../connection/connection.php');

if (isset($_GET['id_cita'])) {
    $id_cita = $_GET['id_cita'];

    // Obtener datos de la cita
    $stmt = $conn->prepare("SELECT fecha_hora FROM citas WHERE id_cita = ?");
    $stmt->bind_param("i", $id_cita);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $cita = $result->fetch_assoc();
    } else {
        echo "Cita no encontrada.";
        exit();
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cita</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <h2>Editar Cita</h2>
    <form action="./actualizar_cita.php" method="post">
        <label for="fecha_hora">Fecha y Hora:</label>
        <input type="datetime-local" name="fecha_hora" id="fecha_hora" value="<?= htmlspecialchars($cita['fecha_hora']) ?>" required><br>
        
        <input type="hidden" name="id_cita" value="<?= $id_cita ?>">
        <input type="submit" value="Actualizar Cita">
    </form>
</body>
</html>
