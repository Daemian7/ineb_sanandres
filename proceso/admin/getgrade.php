<?php
$servidor = "localhost";
$usuario = "root";
$password = "";
$bd = "san-andres";

$conexion = mysqli_connect($servidor, $usuario, $password, $bd);

if (!$conexion) {
    die("Error en la conexión: " . mysqli_connect_error());
}

$consulta = "SELECT * FROM grados";
$resultado = mysqli_query($conexion, $consulta);

if (mysqli_num_rows($resultado) > 0) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        echo "<option value='" . $fila['id_grado'] . "'>" . $fila['nombre_grado'] . "</option>";
    }
} else {
    echo "<option value=''>No se encontraron grados</option>";
}

mysqli_close($conexion);
?>
