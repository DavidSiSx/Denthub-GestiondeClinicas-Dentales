<?php
session_start();
include('../../../connection/connection.php');  // Asegúrate de que la ruta a conexion.php es correcta

$id_cita = $_POST['id_cita'];
$result = $conn->query("SELECT * FROM citas WHERE id_cita = $id_cita");
$cita = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cita</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
<header>
    <!-- Aquí va tu código de header -->
</header>

<section class="form">
    <div class="container">
        <form action="update.php" method="post">
            <h2>Editar Cita</h2>
            <input type="hidden" name="id_cita" value="<?php echo $cita['id_cita']; ?>">
            <label for="fecha">Fecha y hora preferida para la cita</label>
            <input type="datetime-local" id="fecha" name="fecha_hora" value="<?php echo $cita['fecha_hora']; ?>" required>
            <label for="motivo">Motivo</label>
            <input type="text" id="motivo" name="motivo" value="<?php echo $cita['motivo']; ?>" required>
            <label for="comentarios">Comentarios o preguntas adicionales</label>
            <textarea id="comentarios" name="comentarios" rows="4"><?php echo $cita['comentarios']; ?></textarea>
            <button type="submit" class="cta">Actualizar Cita</button>
        </form>
    </div>
</section>

<footer>
    <!-- Aquí va tu código de footer -->
</footer>
</body>
</html>

<?php
$conn->close();
?>
