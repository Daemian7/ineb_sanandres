<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_prof'])) {
    header("Location: login.php");
    exit();
}
$id_prof = $_SESSION['id_prof'];

require 'include/conexion.php';

// Preparar la consulta con INNER JOIN
$stmt = $mysqli->prepare("SELECT C.id_curso, C.nombre_curso, G.id_grado, G.nombre_grado 
                          FROM curso C
                          INNER JOIN grados G ON C.grado = G.id_grado
                          WHERE C.profesor = ?");
if($stmt === false) {
    die('Prepare failed: ' . $mysqli->error);
}

// Vincula la variable
$stmt->bind_param('i', $id_prof); // 'i' indica que el parámetro es un entero

// Ejecuta la consulta
$stmt->execute();

// Obtener los resultados de la consulta
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>INEB SAN ANDRES</title>
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/plugins.css">
    <link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />
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
                                <h1 class="mainTitle">Profesor | Actividades</h1>
                            </div>
                            <ol class="breadcrumb">
                                <li>
                                    <span>Profesor</span>
                                </li>
                                <li class="active">
                                    <span>Actividades</span>
                                </li>
                            </ol>
                    </section>
                    <div class="container-fluid container-fullw bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row margin-top-30">
                                    <div class="col-lg-8 col-md-12">
                                        <div class="panel panel-white">
                                            <div class="panel-heading">
                                                <h1 class="panel-title">Agregar Nota</h1>
                                            </div>
                                            <div class="panel-body">
                                                <form role="form" name="book" method="post" action="add_note.php">
                                                    <div class="form-group">
                                                        <label for="curso">Curso</label>
                                                        <select name="curso" class="form-control" id="curso" required="required">
                                                            <option value="">Selecciona Curso</option>
                                                            <?php 
                                                            if ($result->num_rows > 0) {
                                                                while($row = $result->fetch_assoc()) { ?>
                                                                    <option value="<?php echo $row["id_curso"]; ?>">
                                                                        <?php echo $row["nombre_curso"] . " - " . $row["nombre_grado"]; ?>
                                                                    </option>
                                                                <?php }
                                                            }
                                                            $stmt->close();
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <br>
                                                    <div class="form-group">
                                                        <label for="act">Actividad</label>
                                                        <select name="act" class="form-control" id="act" required="required">
                                                            <option value="">Selecciona Actividad</option>
                                                        </select>
                                                    </div>
                                                    <br>
                                                    <div class="form-group">
                                                        <label for="alumno">Alumno</label>
                                                        <select name="alumno" class="form-control" id="alumno" required="required">
                                                            <option value="">Selecciona Alumno</option>
                                                        </select>
                                                    </div>
                                                    <br>
                                                    <label for="profname">Nota</label>
                                                    <input type="number" id="nota" name="nota" class="form-control" required="required">
                                                    <br>
                                                    <button type="submit" name="submit" class="btn btn-o btn-primary">Agregar</button>
                                                </form>
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
    </div>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <!-- <script src="js/peticion.js"></script>
    <script src="js/peticion2.js"></script> -->
    <script src="peticion.js"></script>
    <?php include('include/footer.php'); ?>
</body>
</html>
