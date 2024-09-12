<?php
require 'conexion.php';

if (isset($_POST['curso'])) {
    $idcurso = $mysqli->real_escape_string($_POST['curso']);
    $sql = "SELECT id_actividad, nombre_act FROM actividades WHERE curso = '$idcurso'";
    
    $resultado = $mysqli->query($sql);
    
    $answer = "<option value=''>Seleccionar</option>";
    
    while ($row = $resultado->fetch_assoc()) {
        $answer .= "<option value='" . $row['id_actividad'] . "'>" . $row['nombre_act'] . "</option>";
    }
    
    echo json_encode($answer, JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode("<option value=''>No data</option>", JSON_UNESCAPED_UNICODE);
}
?>
