<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "san-andres";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$id_prof = $_POST['id_prof'];
$nombre = $_POST['nombre'];
$telefono = $_POST['telefono'];
$usuario = $_POST['usuario'];
$codigo = $_POST['codigo'];

$sql = "UPDATE profesor SET nombre='$nombre', telefono='$telefono', usuario='$usuario', codigo='$codigo' WHERE id_prof='$id_prof'";

if ($conn->query($sql) === TRUE) {
    echo "Registro actualizado correctamente";
} else {
    echo "Error actualizando el registro: " . $conn->error;
}

$conn->close();
header("Location: tu_pagina_de_profesores.php"); // Redirige de nuevo a la página de profesores
exit();
?>
