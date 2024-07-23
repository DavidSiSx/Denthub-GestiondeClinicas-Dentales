<?php

include './conexion.php';

// Asumiendo que los datos se envían a través de un formulario HTML con método POST
$id_paciente = $_POST['id_paciente'];
$fecha_hora = $_POST['fecha_hora'];
$motivo = $_POST['motivo'];
$comentarios = $_POST['comentarios'];

// Consulta para insertar datos en la tabla cita
$query = "INSERT INTO cita (id_paciente, fecha_hora, motivo, comentarios) VALUES ('$id_paciente', '$fecha_hora', '$motivo', '$comentarios')";

// Ejecutar la consulta
$insert = $conexion->query($query);

// Redirigir a la página principal
header('Location: ./index.php');

?>
