<?php
session_start();

$servidor = "localhost";
$usuario = "root";
$password = "";
$bd = "san-andres";

$conexion = new mysqli($servidor, $usuario, $password, $bd);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $code = trim($_POST['code']);

    $stmt = $conexion->prepare("SELECT id, code FROM usuarios WHERE code = ?");
    $stmt->bind_param("s", $code);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $code);
        $stmt->fetch();
        
        $_SESSION['id'] = $id;
        
        header("Location: dashboard.php?id=" . $id);
        exit(); // Terminar el script después de la redirección
    } else {
        header("Location: login.php?error=1");
    }

    $stmt->close();
}

$conexion->close();
?>
