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
                                <h1 class="mainTitle">Admin | Cursos</h1>
                            </div>
                            <ol class="breadcrumb">
                                <li>
                                    <span>Admin</span>
                                </li>
                                <li class="active">
                                    <span>Cursos</span>
                                </li>
                            </ol>
                    </section>
                    <div class="container-fluid bg-white">
                        <br>
                        <br>
                        <button onclick="window.location.href='addcurso.php';" type="button" class="btn btn-success">Agregar Curso</button>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="row margin-top-30">
                                    <div class="col-sm-9 bg-light p-3 border">
                                        <div class="panel panel-white">
                                            <div class="container">
                                                <br>
                                                <h2>Cursos</h2>
                                                <br>
                                                <?php
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

                                                // Consulta SQL para obtener los datos
                                                $sql = "SELECT C.id_curso, C.nombre_curso, G.nombre_grado, P.nombre 
                                                        FROM curso C 
                                                        INNER JOIN grados G ON G.id_grado = C.grado
                                                        INNER JOIN profesor P ON P.id_prof = C.profesor";
                                                $result = $conn->query($sql);

                                                // Manejo de errores en la consulta SQL
                                                if (!$result) {
                                                    die("Error en la consulta: " . $conn->error);
                                                }
                                                ?>
                                                <div class="container">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Nombre</th>
                                                                <th>Grado</th>
                                                                <th>Profesor</th>
                                                                <th>Accion</th>
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
                                                                        <td>" . $row["nombre"] . "</td>
                                                                        <td><button type='button' class='btn btn-warning' onclick='openModal(". $row["id_curso"] .")'>Modificar</button></td>
                                                                    </tr>";
                                                                }
                                                            } else {
                                                                echo "<tr><td colspan='5'>No se encontraron datos</td></tr>";
                                                            }
                                                            $conn->close();
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
        </div>
        <?php include('include/footer.php'); ?>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="editForm" method="POST" action="update_curso.php">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Modificar Curso</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="editId" name="id_curso">
                        <div class="form-group">
                            <label for="editNombreCurso">Nombre del Curso</label>
                            <input type="text" class="form-control" id="editNombreCurso" name="nombre_curso" required>
                        </div>
                        <div class="form-group">
                            <label for="editNombreGrado">Grado</label>
                            <input type="text" class="form-control" id="editNombreGrado" name="nombre_grado" required>
                        </div>
                        <div class="form-group">
                            <label for="editNombreProfesor">Profesor</label>
                            <input type="text" class="form-control" id="editNombreProfesor" name="nombre_profesor" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script>
        function openModal(id) {
            // Obtener datos del curso usando AJAX
            $.ajax({
                url: 'get_curso.php',
                type: 'GET',
                data: { id_curso: id },
                success: function(data) {
                    var curso = JSON.parse(data);
                    $('#editId').val(curso.id_curso);
                    $('#editNombreCurso').val(curso.nombre_curso);
                    $('#editNombreGrado').val(curso.nombre_grado);
                    $('#editNombreProfesor').val(curso.nombre);
                    $('#editModal').modal('show');
                }
            });
        }
    </script>

    
</body>
</html>
