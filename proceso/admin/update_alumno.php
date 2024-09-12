<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "san-andres";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$id_alumno = $_POST['id_alumno'];
$nombre = $_POST['nombre'];
$codigo = $_POST['codigo'];
$grado = $_POST['grado'];
$encargado = $_POST['encargado'];
$tel = $_POST['tel'];
$promedio = $_POST['promedio'];

$sql = "UPDATE alumnos SET nombre='$nombre', codigo='$codigo', grado='$grado', encargado='$encargado', tel='$tel', promedio='$promedio' WHERE id_alumno=$id_alumno";

if ($conn->query($sql) === TRUE) {
    echo "Registro actualizado correctamente";
} else {
    echo "Error actualizando el registro: " . $conn->error;
}

$conn->close();
?>
