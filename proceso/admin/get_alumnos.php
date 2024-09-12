<?php
$servidor = "localhost";
$usuario = "root";
$password = "";
$bd = "san-andres";

$conexion = mysqli_connect($servidor, $usuario, $password, $bd);

if (!$conexion) {
    die("Error en la conexión: " . mysqli_connect_error());
}

if (isset($_POST['grado_id'])) {
    $grado_id = $_POST['grado_id'];
    
    // Corrige la consulta, asegurándote de que 'grado' sea el nombre correcto de la columna
    $consulta = "SELECT * FROM alumnos WHERE grado = '$grado_id'";
    $resultado = mysqli_query($conexion, $consulta);

    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_assoc($resultado)) {
            echo "<option value='" . $fila['id_alumno'] . "'>" . $fila['nombre'] . "</option>";
        }
    } else {
        echo "<option value=''>No se encontraron alumnos</option>";
    }
}

mysqli_close($conexion);
?>
