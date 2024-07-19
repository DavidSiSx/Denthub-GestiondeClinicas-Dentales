<?php
$host= "localhost";
$username="root";
$password="";
$database="denthub";

$conn= new mysqli($hostname, $username, $password,$database);

if($conn->connect_error){
    die("Connection failed:". $conn-> connect_error);
}
?>