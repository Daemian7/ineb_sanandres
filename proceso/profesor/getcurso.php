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

$sql = "SELECT C.id_curso, C.nombre_curso, G.id_grado, G.nombre_grado 
        FROM curso C
        INNER JOIN grados G ON C.grado = G.id_grado
        WHERE C.profesor = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_prof);
$stmt->execute();
$result = $stmt->get_result();

while ($fila = $result->fetch_assoc()) {
    echo "<option value='" . $fila['id_curso'] . "'>" . $fila['nombre_curso'] . " - " . $fila['nombre_grado'] . "</option>";
}

$stmt->close();
$conn->close();
?>
