<?php
include('../../../connection/connection.php');  // Asegúrate de que la ruta a conexion.php es correcta

$result = $conn->query("SELECT id_cita, id_paciente, fecha_hora, motivo, comentarios FROM citas");

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id_cita'] . "</td>";
        echo "<td>" . $row['fecha_hora'] . "</td>";
        echo "<td>" . $row['motivo'] . "</td>";
        echo "<td>" . $row['comentarios'] . "</td>";
        echo '<td><form method="POST" action="editar_cita.php"><input type="hidden" name="id_cita" value="' . $row['id_cita'] . '"><button type="submit">Editar</button></form></td>';
        echo '<td><form method="POST" action="eliminar_cita.php"><input type="hidden" name="id_cita" value="' . $row['id_cita'] . '"><button type="submit">Eliminar</button></form></td>';
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6'>No hay citas agendadas</td></tr>";
}

$conn->close();
?>
