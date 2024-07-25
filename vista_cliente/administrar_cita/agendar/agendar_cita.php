<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda tu Cita</title>
    <link rel="stylesheet" href="./style.css">
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
                    <li><a href="./administrar_cita/index.html">Citas</a></li>
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
    <section class="form">
        <div class="container">
            <h2>Agenda tu cita</h2>
            <p>Rellena el formulario para agendar tu cita.</p>
            <form action="./insertar_cita.php" method="post">

                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" required><br>

                <label for="telefono">Teléfono:</label>
                <input type="tel" name="telefono" id="telefono" required><br>

                <label for="fecha_hora">Fecha y Hora:</label>
                <input type="datetime-local" name="fecha_hora" id="fecha_hora" required><br>

                <label for="motivo">Motivo:</label>
                <input type="text" name="motivo" id="motivo" required><br>

                <label for="comentarios">Comentarios:</label>
                <input type="text" name="comentarios" id="comentarios"><br>
                
                <input type="hidden" name="id_paciente" value="<?= $_SESSION['id_paciente']; ?>"> <!-- Asumimos que el id_paciente está en la sesión -->
                <button type="submit" class="cta">Agendar Cita</button>
            </form>
        </div>
    </section>
    <section class="services">
        <div class="container">
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
        </div>
    </section>
</body>
</html>
