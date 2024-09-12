<?php
$servidor = "localhost";
$usuario = "root";
$password = "";
$bd = "san-andres";

$conexion = mysqli_connect($servidor, $usuario, $password, $bd);

if (!$conexion) {
    die("Error en la conexión: " . mysqli_connect_error());
}

$curso_id = $_GET['curso_id'] ?? '';

$sql = "SELECT A.id_alumno, A.nombre
        FROM alumnos A
        INNER JOIN grados G ON A.grado= G.id_grado
        INNER JOIN curso C ON G.id_grado = C.grado
        WHERE C.id_curso =?";

$stmt = $conexion->prepare($sql);
$stmt->bind_param('i', $curso_id);
$stmt->execute();
$result = $stmt->get_result();

$alumnos = [];
while ($row = $result->fetch_assoc()) {
    $alumnos[] = $row;
}

header('Content-Type: application/json');
echo json_encode(['alumnos' => $alumnos]);

mysqli_close($conexion);
?>
