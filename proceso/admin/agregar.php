<?php
// Conexión a la base de datos
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

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $name = $conn->real_escape_string($_POST['name']);
    $codigo = $conn->real_escape_string($_POST['codigo']);
    $grade = $conn->real_escape_string($_POST['grade']);
    $encargado = $conn->real_escape_string($_POST['encargado']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $date = $conn->real_escape_string($_POST['date']);

    // Preparar la consulta SQL
    $sql = "INSERT INTO alumnos (nombre, codigo, grado, encargado, tel, fecha_nac)
            VALUES ('$name', '$codigo', '$grade', '$encargado', '$phone', '$date')";

    // Ejecutar la consulta y verificar si se insertaron los datos correctamente
    if ($conn->query($sql) === TRUE) {
        echo "<script>
        alert('Alumno agregado exitosamente');
        window.location.href = 'alumnos.php';
      </script>";
    } else {
        echo "<script>alert('Error: " . addslashes($sql) . "\\n" . addslashes($conn->error) . "');</script>";
    }

    // Cerrar la conexión
    $conn->close();
}
?>
