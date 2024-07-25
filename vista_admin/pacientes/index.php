<?php
session_start();
include('../../connection/connection.php');

// Consulta para obtener todos los pacientes
$sql = "SELECT id_paciente, nombre, apellido_paterno, apellido_materno, fecha_nacimiento, telefono, correo FROM pacientes";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="preload" href="../../style/style.css">
    <link rel="preload" href="../../style/normalize.css">
    <link rel="stylesheet" href="../../vista_cliente/administrar_cita/style.css">
    <link rel="stylesheet" href="../../style/normalize.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
</head>

<body class="pacientes">
    <header>
        <nav>
            <div class="arriba">
                <a class="navbar-brand" href="#">
                    <img src="../../img/logo.png" width="100" height="50" alt="">
                </a>
                <div class="navbar_items">
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="../../vista_admin/calendario_admin/index.php">Mis citas</a></li>
                    <li><a href="#">Pacientes</a></li>
                    <li><a href="../control_de_pagos/index.php">Control de pagos</a></li>
                    <div class="contenedor_icons">
                        <a class="navbar-brand" href="../registro/index.html">
                            <img src="../../img/usuario (1).png" alt="" width="30" height="24">
                        </a>
                        <a class="navbar-brand" href="https://www.google.com.mx/maps/preview">
                            <img src="../../img/marcador (2).png" alt="" width="30" height="24">
                        </a>
                        <a class="navbar-brand" href="#">
                            <img src="../../img/hogar (2).png" alt="" width="30" height="24">
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <div class="container">
        <h2 class="h2pac">Pacientes</h2>
        <table class="patients-table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Fecha de nacimiento</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nombre']) ?></td>
                        <td><?= htmlspecialchars($row['apellido_paterno']) ?></td>
                        <td><?= htmlspecialchars($row['apellido_materno']) ?></td>
                        <td><?= htmlspecialchars($row['fecha_nacimiento']) ?></td>
                        <td><?= htmlspecialchars($row['telefono']) ?></td>
                        <td><?= htmlspecialchars($row['correo']) ?></td>
                        <td>
                            <a href="../Pacientes/perfil_pac/index.php?id_paciente=<?= $row['id_paciente'] ?>" class="btn btn-primary">Ver perfil</a>
                         
                            <a href="eliminar_paciente.php?id_paciente=<?= $row['id_paciente'] ?>" class="btn btn-danger">Eliminar</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No se encontraron pacientes.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="pagination">
            <ul>
                <li><a href="#" class="btn btn-primary">Anterior</a></li>
                <li><a href="#" class="btn btn-primary">1</a></li>
                <li><a href="#" class="btn btn-primary">2</a></li>
                <li><a href="#" class="btn btn-primary">3</a></li>
                <li><a href="#" class="btn btn-primary">Siguiente</a></li>
            </ul>
        </div>
    </div>
    <footer>
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
$conn->close();
?>
