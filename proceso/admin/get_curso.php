<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "san-andres";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$id_curso = $_GET['id_curso'];

$sql = "SELECT C.id_curso, C.nombre_curso, G.nombre_grado, P.nombre 
        FROM curso C 
        INNER JOIN grados G ON G.id_grado = C.grado
        INNER JOIN profesor P ON P.id_prof = C.profesor
        WHERE C.id_curso = $id_curso";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode([]);
}

$conn->close();
?>
