<?php
// print_r($_POST);
session_start();

if (isset($_POST['correo']) && isset($_POST['contrasena'])) {
    echo "Entrando al bloque de autenticación<br>";
    require_once './connection.php';

    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    echo "correo: $correo, Contraseña: $contrasena<br>";

    $sql = "SELECT id_administrador, nombre, apellido_paterno, apellido_materno, correo, contrasena
            FROM administradores
            WHERE correo = '$correo' AND contrasena = '$contrasena'";

    $result = $conn->query($sql);

    if (!$result) {
        die("Error en la consulta SQL: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        echo "Usuario encontrado<br>";
        $row = $result->fetch_assoc();
        
            $_SESSION['correo'] = $row['correo'];
            $_SESSION['contrasena'] = $row['contrasena'];
            $_SESSION['id_administrador'] = $row['id_administrador'];
            $_SESSION['nombre'] = $row['nombre'];
            $_SESSION['apellido_paterno'] = $row['apellido_paterno'];
            $_SESSION['apellido_materno'] = $row['apellido_materno'];
            header("Location: ../vista_admin/index.php");
            exit;
        } else if ($row['estado'] == 'Activo') {
            $_SESSION['error'] = "El usuario ya inició sesión";
            header("Location: ../registro_adm/index.html");
            exit;
        }
    } //else {
        //echo "No se encontraron usuarios con esas credenciales<br>";
        //$_SESSION['error'] = "El usuario o contraseña son incorrectos";
        //header("Location: ../index.html");
        exit;
    

?>

