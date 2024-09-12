<?php
$curso_id = $_GET['curso_id'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "san-andres";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT id_actividad, nombre_actividad FROM actividades WHERE curso_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $curso_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    echo "<option value='" . $row['id_actividad'] . "'>" . $row['nombre_actividad'] . "</option>";
}

$stmt->close();
$conn->close();
?>
