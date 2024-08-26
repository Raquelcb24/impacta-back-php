<?php

//variables de mi base de datos
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'impacta';

$conn = new mysqli($servername, $username, $password, $dbname);

//verifico la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
