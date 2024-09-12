<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "san-andres";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if (isset($_POST['curso_id'])) {
    $curso_id = $_POST['curso_id'];

    // Obtener las actividades relacionadas al curso seleccionado
    $stmt = $conn->prepare("SELECT id_actividad, nombre_act FROM actividades WHERE curso = ?");
    if ($stmt === false) {
        die('Error en la consulta de actividades: ' . $conn->error);
    }
    $stmt->bind_param('i', $curso_id);
    $stmt->execute();
    $result_actividades = $stmt->get_result();

    // Obtener los alumnos relacionados al grado del curso seleccionado
    $stmt = $conn->prepare("SELECT A.id_alumno, A.nombre FROM alumnos A 
                            INNER JOIN grados G ON A.grado = G.id_grado 
                            INNER JOIN curso C ON C.grado = G.id_grado 
                            WHERE C.id_curso = ?");
    if ($stmt === false) {
        die('Error en la consulta de alumnos: ' . $conn->error);
    }
    $stmt->bind_param('i', $curso_id);
    $stmt->execute();
    $result_alumnos = $stmt->get_result();

    // Preparar los datos para ser enviados como JSON
    $actividades = [];
    while ($row = $result_actividades->fetch_assoc()) {
        $actividades[] = $row;
    }

    $alumnos = [];
    while ($row = $result_alumnos->fetch_assoc()) {
        $alumnos[] = $row;
    }

    // Enviar datos como JSON
    echo json_encode(['actividades' => $actividades, 'alumnos' => $alumnos]);

    // Cerrar el statement
    $stmt->close();
}

// Cerrar la conexión
$conn->close();

?>
