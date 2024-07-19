<?php
print_r($_POST);
session_start();

if (isset($_POST['correo']) && isset($_POST['contraseña'])) {
    require_once './connection.php';
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];

 

    $sql = "SELECT id_paciente,correo,contraseña,nombre,ap_paterno ap_materno,estado
            FROM pacientes";
           

           

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if($row['estado'] == 'Activo'){
            $_SESSION['error'] = "El usuario ya inicio sesión";
            header("Location:../../../index.html");
            exit();
        }
        
    

        $sql = "UPDATE pacientes SET estado = 'Activo' WHERE id_paciente = ".$row['id_paciente'];

        $conn->query($sql);

        $_SESSION['correo'] = $row['correo'];
        $_SESSION['contraseña'] = $row['contraseña'];
        $_SESSION['id_paciente'] = $row['id_paciente'];
        $_SESSION['nombre'] = $row['nombre'];
        $_SESSION['ap_paterno'] = $row['ap_paterno'];
        $_SESSION['ap_materno'] = $row['ap_materno'];
        header("Location: ../../../proyecto/vista_cliente/index.html");
    } else {
        $_SESSION['error'] = "El correo o contraseña son incorrectos";
        header("Location:../../../proyecto/registro_usr/index.html");
    }
} else {
    $_SESSION['error'] = "Completa todos los campos";
    header("Location:../../../proyecto/registro_usr/index.html");
}
?>