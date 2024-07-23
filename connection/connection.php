<?php
$dbhost= "localhost";
$dbuser= "root";
$dbpass= "";
$dbname= "denthub";

$conn= new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if ($conexion ->connect_error){
    die("la conexion fallo: ". $conexion->connect_error);
}

?>
