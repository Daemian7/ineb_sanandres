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
    $codigo = trim($_POST['codigo']);

    $stmt = $conexion->prepare("SELECT id_prof, codigo FROM profesor WHERE codigo = ?");
    $stmt->bind_param("s", $codigo);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id_prof, $codigo);
        $stmt->fetch();
        
        $_SESSION['id_prof'] = $id_prof;
        
        header("Location: dashboard.php?id=" . $id_prof);
        exit(); // Terminar el script después de la redirección
    } else {
        header("Location: login.php?error=1");
    }

    $stmt->close();
}

$conexion->close();
?>
