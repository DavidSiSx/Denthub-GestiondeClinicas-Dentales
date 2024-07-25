<?php
session_start();
include('../../connection/connection.php');

$id_cita = $_GET['id_cita'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $monto_total = $_POST['monto_total'];
    $concepto = $_POST['concepto'];

    $stmt = $conn->prepare("INSERT INTO pagos (id_paciente, id_cita, fecha_pago, monto_total, estado, concepto) VALUES ((SELECT id_paciente FROM citas WHERE id_cita = ?), ?, NOW(), ?, 'Pendiente', ?)");
    $stmt->bind_param("iids", $id_cita, $id_cita, $monto_total, $concepto);

    if ($stmt->execute()) {
        header("Location: ../../vista_admin/control_de_pagos/index.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Pago</title>
    <link rel="stylesheet" href="../../vista_cliente/administrar_cita/style.css">
</head>
<body>
    <header>
        <nav>
            <div class="arriba">
                <a class="navbar-brand" href="#">
                    <img src="../../img/logo.png" width="100" height="50" alt="">
                </a>
                <div class="navbar_items">
                    <li><a href="../../prueba.php">Home</a></li>
                    <li><a href="../../info/index.html">Informacion</a></li>
                    <li><a href="#">Citas</a></li>
                    <li><a href="../../servicios/index.html">Servicios</a></li>
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
    <section class="form">
        <div class="container">
            <h2>Registrar Pago</h2>
            <form action="" method="post">
                <label for="monto_total">Monto Total:</label>
                <input type="number" name="monto_total" id="monto_total" step="0.01" required><br>
                <label for="concepto">Concepto:</label>
                <input type="text" name="concepto" id="concepto" required><br>
                <button type="submit" class="cta">Registrar Pago</button>
            </form>
        </div>
    </section>
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
