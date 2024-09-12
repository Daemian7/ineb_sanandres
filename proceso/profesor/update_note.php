<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_prof'])) {
    header("Location: login.php");
    exit();
}

$id_prof = $_SESSION['id_prof'];

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "san-andres";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$id = $_POST['id'];
$actividad = $_POST['actividad'];
$nota = $_POST['nota'];

// Actualizar la nota
$sql = "UPDATE notas SET nombre_act = ?, nota = ? WHERE id_nota = ? AND id_prof = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('siii', $actividad, $nota, $id, $id_prof);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Nota actualizada con éxito";
} else {
    echo "Error al actualizar la nota";
}

$stmt->close();
$conn->close();
?>
