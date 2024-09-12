<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_prof'])) {
    header("Location: login.php");
    exit();
}

$id_prof = $_SESSION['id_prof'];

require 'include/conexion.php';

// Consulta SQL para obtener los cursos del profesor
$sql = "SELECT A.id_actividad, A.nombre_act, C.nombre_curso, G.nombre_grado , B.bimestre
FROM actividades A 
INNER JOIN curso C ON C.id_curso = A.curso
INNER JOIN bimestre B ON B.id_bimestre = A.bimestre
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

    <!-- Script para abrir el modal y cargar datos de la actividad seleccionada -->
    <script type="text/javascript">
        function openEditModal(id_actividad, nombre_act, nombre_curso, nombre_grado, bimestre) {
            // Aquí puedes llenar los campos del formulario del modal con los datos de la actividad
            document.getElementById('edit_id_actividad').value = id_actividad;
            document.getElementById('edit_nombre_act').value = nombre_act;
            document.getElementById('edit_nombre_curso').value = nombre_curso;
            document.getElementById('edit_nombre_grado').value = nombre_grado;
            document.getElementById('edit_bimestre').value = bimestre;

            // Abrir el modal
            $('#editModal').modal('show');
        }
    </script>
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
                    <div class="container-fluid bg-white">
                        <br>
                        <h2>Mis Actividades</h2>
                        <br>
                        <button onclick="window.location.href='addactividad.php';" type="button"
                            class="btn btn-success">Agregar Actividad</button>
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
                                                            <th>Actividad</th>
                                                            <th>Curso</th>
                                                            <th>Grado</th>
                                                            <th>Bimestre</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if ($result->num_rows > 0) {
                                                            // Salida de datos de cada fila
                                                            while ($row = $result->fetch_assoc()) {
                                                                echo "<tr>
                                                                        <td>" . $row["id_actividad"] . "</td>
                                                                        <td>" . $row["nombre_act"] . "</td>
                                                                        <td>" . $row["nombre_curso"] . "</td>
                                                                        <td>" . $row["nombre_grado"] . "</td>
                                                                        <td>" . $row["bimestre"] . "</td>
                                                                        <td>
                                                                            <button type='button' class='btn btn-warning' onclick='openEditModal(" . $row["id_actividad"] . ", \"" . $row["nombre_act"] . "\", \"" . $row["nombre_curso"] . "\", \"" . $row["nombre_grado"] . "\", \"" . $row["bimestre"] . "\")'>Modificar</button>
                                                                        </td>
                                                                      </tr>";
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='6'>No se encontraron actividades</td></tr>";
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

    <!-- Modal para editar actividad -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Modificar Actividad</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" name="editForm" method="post" action="modificaractividad.php">
                        <div class="form-group">
                            <label for="edit_nombre_act">Nombre de la Actividad</label>
                            <input type="text" id="edit_nombre_act" name="edit_nombre_act" class="form-control"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="edit_nombre_curso">Curso</label>
                            <input type="text" id="edit_nombre_curso" name="edit_nombre_curso" class="form-control"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="edit_nombre_grado">Grado</label>
                            <input type="text" id="edit_nombre_grado" name="edit_nombre_grado" class="form-control"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="edit_bimestre">Bimestre</label>
                            <input type="text" id="edit_bimestre" name="edit_bimestre" class="form-control" required>
                        </div>
                        <!-- Campo oculto para enviar el ID de la actividad a modificar -->
                        <input type="hidden" id="edit_id_actividad" name="edit_id_actividad">

                        <button type="submit" name="submit" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>

<?php
// Cerrar la conexión a la base de datos
$conn->close();
?>
