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
                                <h1 class="mainTitle">Admin | Profesores</h1>
                            </div>
                            <ol class="breadcrumb">
                                <li>
                                    <span>Admin</span>
                                </li>
                                <li class="active">
                                    <span>Profesores</span>
                                </li>
                            </ol>
                    </section>
                    <div class="container-fluid  bg-white">
                        <br>
                        <br>
                        <button onclick="window.location.href='addprofesor.php';" type="button"
                            class="btn btn-success">Agregar Profesor</button>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="row margin-top-30">
                                    <div class="col-sm-9 bg-light p-3 border">
                                        <div class="panel panel-white">
                                            <div class="container">
                                                <br>
                                                <h2>Profesores</h2>
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
                                                $sql = "SELECT * FROM profesor";
                                                $result = $conn->query($sql);
                                                ?>

                                                <div class="container">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Nombre</th>
                                                                <th>Telefono</th>
                                                                <th>Usuario</th>
                                                                <th>Codigo</th>
                                                                <th>Accion</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            if ($result->num_rows > 0) {
                                                                // Salida de datos de cada fila
                                                                while($row = $result->fetch_assoc()) {
                                                                    echo "<tr>
                                                                        <td>" . $row["id_prof"]. "</td>
                                                                        <td>" . $row["nombre"]. "</td>
                                                                        <td>" . $row["telefono"]. "</td>
                                                                        <td>" . $row["usuario"]. "</td>
                                                                        <td>" . $row["codigo"]. "</td>
                                                                        <td><button type='button' class='btn btn-warning' onclick='openModal(" . $row["id_prof"] . ")'>Modificar</button></td>
                                                                      </tr>";
                                                                }
                                                            } else {
                                                                echo "<tr><td colspan='6'>No se encontraron datos</td></tr>";
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

    <!-- Modal para editar -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Profesor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="POST" action="update_profesor.php">
                        <div class="form-group">
                            <label for="editId">ID</label>
                            <input type="text" class="form-control" id="editId" name="id_prof" readonly>
                        </div>
                        <div class="form-group">
                            <label for="editNombre">Nombre</label>
                            <input type="text" class="form-control" id="editNombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="editTelefono">Teléfono</label>
                            <input type="text" class="form-control" id="editTelefono" name="telefono" required>
                        </div>
                        <div class="form-group">
                            <label for="editUsuario">Usuario</label>
                            <input type="text" class="form-control" id="editUsuario" name="usuario" required>
                        </div>
                        <div class="form-group">
                            <label for="editCodigo">Código</label>
                            <input type="text" class="form-control" id="editCodigo" name="codigo" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openModal(id) {
            $.ajax({
                url: 'get_profesor.php',
                type: 'POST',
                data: { id_prof: id },
                success: function (response) {
                    var data = JSON.parse(response);
                    $('#editId').val(data.id_prof);
                    $('#editNombre').val(data.nombre);
                    $('#editTelefono').val(data.telefono);
                    $('#editUsuario').val(data.usuario);
                    $('#editCodigo').val(data.codigo);
                    $('#editModal').modal('show');
                }
            });
        }
    </script>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

</body>

</html>
