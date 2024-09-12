<?php


$mysqli = new mysqli("localhost", "root", "", "san-andres");

// Verificar la conexión
if ($mysqli->connect_error) {

    echo"Conexión fallida: " . $conn->connect_error;
    exit;
}
?>