<?php
session_start();

$servidor = "localhost";
$usuario = "root";
$password = "";
$bd = "barberia_p";

$conexion = new mysqli($servidor, $usuario, $password, $bd);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $code = trim($_POST['code']);

    $stmt = $conexion->prepare("SELECT id_empleado, code FROM empleados WHERE code = ?");
    $stmt->bind_param("s", $code);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id_empleado, $code);
        $stmt->fetch();
        
        $_SESSION['id_empleado'] = $id_empleado;
        
        header("Location: dashboard.php?id=" . $id_empleado);
        exit(); // Terminar el script después de la redirección
    } else {
        header("Location: login.php?error=1");
    }

    $stmt->close();
}

$conexion->close();
?>
