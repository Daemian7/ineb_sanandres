<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "san-andres";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$id_curso = $_POST['id_curso'];
$nombre_curso = $_POST['nombre_curso'];
$nombre_grado = $_POST['nombre_grado'];
$nombre_profesor = $_POST['nombre_profesor'];

// Primero obtener los ids del grado y del profesor basados en sus nombres
$sql_grado = "SELECT id_grado FROM grados WHERE nombre_grado='$nombre_grado'";
$result_grado = $conn->query($sql_grado);
$id_grado = $result_grado->fetch_assoc()['id_grado'];

$sql_profesor = "SELECT id_prof FROM profesor WHERE nombre='$nombre_profesor'";
$result_profesor = $conn->query($sql_profesor);
$id_profesor = $result_profesor->fetch_assoc()['id_prof'];

$sql = "UPDATE curso SET nombre_curso='$nombre_curso', grado='$id_grado', profesor='$id_profesor' WHERE id_curso='$id_curso'";

if ($conn->query($sql) === TRUE) {
    echo "<script>
    alert('Curso actualizado exitosamente');
    window.location.href = 'cursos.php';
  </script>";
} else {
    echo "Error actualizando el registro: " . $conn->error;
}

$conn->close();
?>
