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
    $curso = $conn->real_escape_string($_POST['curso']);
    $bim = $conn->real_escape_string($_POST['bim']);


    // Preparar la consulta SQL
    $sql = "INSERT INTO actividades (nombre_act, curso, bimestre)
            VALUES ('$name', '$curso', '$bim')";

    // Ejecutar la consulta y verificar si se insertaron los datos correctamente
    if ($conn->query($sql) === TRUE) {
        echo "<script>
            alert('Actividad agregada exitosamente');
            window.location.href = 'actividades.php';
          </script>";
    } else {
        echo "<script>alert('Error: " . addslashes($sql) . "\\n" . addslashes($conn->error) . "');</script>";
    }

    // Cerrar la conexión
    $conn->close();
}
?>
