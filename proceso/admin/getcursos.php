<?php
$servidor = "localhost";
$usuario = "root";
$password = "";
$bd = "san-andres";

$conexion = mysqli_connect($servidor, $usuario, $password, $bd);

if (!$conexion) {
    die("Error en la conexión: " . mysqli_connect_error());
}

$profesor_id = $_GET['profesor_id'] ?? '';

$sql = "SELECT C.id_curso, C.nombre_curso, G.nombre_grado
        FROM curso C
        INNER JOIN grados G ON C.grado = G.id_grado
        WHERE C.profesor = ?";

$stmt = $conexion->prepare($sql);
$stmt->bind_param('i', $profesor_id);
$stmt->execute();
$result = $stmt->get_result();

$cursos = [];
while ($row = $result->fetch_assoc()) {
    $cursos[] = $row;
}

header('Content-Type: application/json');
echo json_encode(['cursos' => $cursos]);

mysqli_close($conexion);
?>
