<?php
session_start();
include('../../../connection/connection.php');

// Obtener el id del paciente desde la sesión
$id_paciente = $_SESSION['id_paciente'];

// Consulta para obtener las citas del paciente con los pagos
$sql = "SELECT citas.id_cita, citas.fecha_hora, citas.motivo, citas.comentarios, 
               IFNULL(pagos.monto_total, 'No asignado') as monto_total,
               IF(pagos.monto_total IS NOT NULL, 'Pagado', 'Pendiente') as estado_pago
        FROM citas
        LEFT JOIN pagos ON citas.id_cita = pagos.id_cita
        WHERE citas.id_paciente = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_paciente);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Citas</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
        <nav>
            <div class="arriba">
                <a class="navbar-brand" href="#">
                    <img src="../../../img/logo.png" width="100" height="50" alt="">
                </a>
                <div class="navbar_items">
                    <li><a href="../../prueba.php">Home</a></li>
                    <li><a href="../../info/index.html">Informacion</a></li>
                    <li><a href="#">Citas</a></li>
                    <li><a href="../../servicios/index.html">Servicios</a></li>
                    <div class="contenedor_icons">
                        <a class="navbar-brand" href="../../../registro_usr/index.html">
                            <img src="../../../img/usuario (1).png" alt="" width="30" height="24">
                        </a>
                        <a class="navbar-brand" href="https://www.google.com.mx/maps/preview">
                            <img src="../../../img/marcador (2).png" alt="" width="30" height="24">
                        </a>
                        <a class="navbar-brand" href="#">
                            <img src="../../../img/hogar (2).png" alt="" width="30" height="24">
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <div class="xd">
        <h1>Administrar Citas</h1>
    </div>
    <main>
        <section class="appointment-list">
            <h2>Mis Citas</h2>
            <table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Motivo</th>
                        <th>Comentarios</th>
                        <th>Monto Total</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): 
                        $fecha_hora = new DateTime($row['fecha_hora']);
                    ?>
                    <tr>
                        <td><?= $fecha_hora->format('Y-m-d') ?></td>
                        <td><?= $fecha_hora->format('H:i') ?></td>
                        <td><?= htmlspecialchars($row['motivo']) ?></td>
                        <td><?= htmlspecialchars($row['comentarios']) ?></td>
                        <td><?= htmlspecialchars($row['monto_total']) ?></td>
                        <td><?= htmlspecialchars($row['estado_pago']) ?></td>
                        <td>
                            <?php if ($row['estado_pago'] === 'Pendiente'): ?>
                                <form action="eliminar_cita.php" method="post" style="display:inline;">
                                    <input type="hidden" name="id_cita" value="<?= $row['id_cita'] ?>">
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                                <form action="editar_cita.php" method="get" style="display:inline;">
                                    <input type="hidden" name="id_cita" value="<?= $row['id_cita'] ?>">
                                    <button type="submit" class="btn btn-secondary">Editar</button>
                                </form>
                            <?php else: ?>
                                <span>No se puede modificar</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>
    </main>
    <div class="citabtn">
        <a href="./agendar_cita.php"><button class="cancel-btn">Agendar nueva cita</button></a>
    </div>
    <footer class="bg_footer">
        <div class="footer-container">
            <ul>
                <li><a href="#aviso-privacidad">Aviso de privacidad</a></li>
                <li><a href="#terminos-y-condiciones">Términos y condiciones</a></li>
                <li><a href="#mapa-de-sitio">Mapa de sitio</a></li>
            </ul>
            <p>&copy; 2023 Dentavida. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
