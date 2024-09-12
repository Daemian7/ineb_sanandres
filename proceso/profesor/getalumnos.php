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

$sql = "SELECT A.id_alumno, A.nombre 
        FROM alumnos A 
        INNER JOIN grados G ON A.grado = G.id_grado 
        INNER JOIN curso C ON C.grado = G.id_grado 
        WHERE C.id_curso = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $curso_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    echo "<option value='" . $row['id_alumno'] . "'>" . $row['nombre'] . "</option>";
}

$stmt->close();
$conn->close();
?>
