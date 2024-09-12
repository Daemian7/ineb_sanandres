<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_prof'])) {
    header("Location: login.php");
    exit();
}

$id_prof = $_SESSION['id_prof'];

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "san-andres";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta SQL para obtener los cursos del profesor
$sql = "SELECT C.id_curso, C.nombre_curso, G.nombre_grado 
FROM curso C 
INNER JOIN grados G ON G.id_grado = C.grado
WHERE profesor= ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_prof);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>INEB SAN ANDRES</title>
    <!-- Include Bootstrap and other necessary CSS files -->
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/plugins.css">
    <link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
</head>

<body>
    <div id="app">
        <?php include('include/sidebar.php'); ?>
        <div class="app-content">
            <?php include('include/header.php'); ?>
            <div class="main-content">
                <div class="wrap-content container" id="container">
                    <section id="page-title">
                        <div class="row">
                            <div class="col-sm-8">
                                <h1 class="mainTitle">Profesor | Cursos</h1>
                            </div>
                            <ol class="breadcrumb">
                                <li>
                                    <span>Profesor</span>
                                </li>
                                <li class="active">
                                    <span>Cursos</span>
                                </li>
                            </ol>
                    </section>
                    <div class="container-fluid bg-white">
                        <br>
                        <h2>Mis Cursos</h2>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row margin-top-30">
                                    <div class="col-sm-9 bg-light p-3 border">
                                        <div class="panel panel-white">
                                            <div class="container">
                                                <br>
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Nombre del Curso</th>
                                                            <th>Grado</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if ($result->num_rows > 0) {
                                                            // Salida de datos de cada fila
                                                            while($row = $result->fetch_assoc()) {
                                                                echo "<tr>
                                                                        <td>" . $row["id_curso"] . "</td>
                                                                        <td>" . $row["nombre_curso"] . "</td>
                                                                        <td>" . $row["nombre_grado"] . "</td>
                                                                      </tr>";
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='3'>No se encontraron cursos</td></tr>";
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include('include/footer.php'); ?>
    </div>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Cerrar la conexión a la base de datos
$conn->close();
?>
