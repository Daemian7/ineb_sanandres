<?php
session_start();

if (!isset($_SESSION['id_prof'])) {
    header("Location: login.php");
    exit();
}

$id_prof = $_SESSION['id_prof'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "san-andres";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$id_actividad = $_POST['id_actividad'];
$nombre_act = $_POST['nombre_act'];

$sql = "UPDATE actividades SET nombre_act=? WHERE id_actividad=? AND curso IN (SELECT id_curso FROM curso WHERE profesor=?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sii", $nombre_act, $id_actividad, $id_prof);

if ($stmt->execute()) {
    echo "Actividad actualizada correctamente";
} else {
    echo "Error al actualizar la actividad: " . $stmt->error;
}

$conn->close();
?>
