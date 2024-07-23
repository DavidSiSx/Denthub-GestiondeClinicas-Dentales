<?php
// print_r($_POST);
session_start();

if (isset($_POST['correo']) && isset($_POST['contrasena'])) {
    echo "Entrando al bloque de autenticación<br>";
    require_once './connection.php';

    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    echo "correo: $correo, Contraseña: $contrasena<br>";

    $sql = "SELECT id_paciente, nombre, apellido_paterno, apellido_materno, correo, contrasena, fecha_nacimiento, estado
            FROM pacientes
            WHERE correo = '$correo' AND contrasena = '$contrasena'";

    $result = $conn->query($sql);

    if (!$result) {
        die("Error en la consulta SQL: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        echo "Usuario encontrado<br>";
        $row = $result->fetch_assoc();
        if ($row['estado'] == 'Inactivo') {
            $_SESSION['correo'] = $row['correo'];
            $_SESSION['contrasena'] = $row['contrasena'];
            $_SESSION['id_paciente'] = $row['id_paciente'];
            $_SESSION['nombre'] = $row['nombre'];
            $_SESSION['apellido_paterno'] = $row['apellido_paterno'];
            $_SESSION['apellido_materno'] = $row['apellido_materno'];
            $_SESSION['fecha_nacimiento'] = $row['fecha_nacimiento'];
            header("Location: ../vista_cliente/prueba.php");
            exit;
        } else if ($row['estado'] == 'Activo') {
            $_SESSION['error'] = "El usuario ya inició sesión";
            header("Location: ./registro_usr/index.html");
            exit;
        }
    } else {
        echo "No se encontraron usuarios con esas credenciales<br>";
        $_SESSION['error'] = "El usuario o contraseña son incorrectos";
        header("Location: ../index.html");
        exit;
    }
}
?>



    