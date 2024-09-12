<?php
require 'conexion.php';

if (isset($_POST['curso'])) {
    $idcurso = $mysqli->real_escape_string($_POST['curso']);
    
    $sql = "SELECT A.id_alumno, A.nombre 
            FROM curso C 
            INNER JOIN grados G ON C.grado = G.id_grado 
            INNER JOIN alumnos A ON A.grado = G.id_grado 
            WHERE C.id_curso = ?";
    
    $stmt = $mysqli->prepare($sql);
    if ($stmt === false) {
        die('Prepare failed: ' . $mysqli->error);
    }

    $stmt->bind_param('i', $idcurso); // 'i' indica que el parámetro es un entero
    $stmt->execute();
    $result = $stmt->get_result();

    $answer = "<option value=''>Seleccionar Alumno</option>";
    
    while ($row = $result->fetch_assoc()) {
        $answer .= "<option value='" . $row['id_alumno'] . "'>" . $row['nombre'] . "</option>";
    }
    
    echo json_encode($answer, JSON_UNESCAPED_UNICODE);
    
    $stmt->close();
} else {
    echo json_encode("<option value=''>No data</option>", JSON_UNESCAPED_UNICODE);
}
?>
