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
    $grade = $conn->real_escape_string($_POST['grade']);
    $prof = $conn->real_escape_string($_POST['prof']);
 

    // Preparar la consulta SQL
    $sql = "INSERT INTO curso (nombre_curso, grado, profesor)
            VALUES ('$name', '$grade', '$prof')";

    // Ejecutar la consulta y verificar si se insertaron los datos correctamente
    if ($conn->query($sql) === TRUE) {
        echo "<script>
        alert('Curso agregado exitosamente');
        window.location.href = 'cursos.php';
      </script>";
    } else {
        echo "<script>alert('Error: " . addslashes($sql) . "\\n" . addslashes($conn->error) . "');</script>";
    }

    // Cerrar la conexión
    $conn->close();
}
?>
