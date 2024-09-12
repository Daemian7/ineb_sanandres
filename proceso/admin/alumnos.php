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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

    <script type="text/javascript">
    function selectgrade(str) {
        var conexion;
        if (str == "") {
            document.getElementById("txtHint").innerHTML = "";
            return;
        }
        if (window.XMLHttpRequest) {
            conexion = new XMLHttpRequest();
        }
        conexion.onreadystatechange = function() {
            if (conexion.readyState == 4 && conexion.status == 200) {
                document.getElementById("servicio").innerHTML = conexion.responseText;
            }
        }
        conexion.open("get", "select.php?c=" + str, true);
        conexion.send();
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
                                <h1 class="mainTitle">Administrador | Alumnos</h1>
                            </div>
                            <ol class="breadcrumb">
                                <li>
                                    <span>Admin</span>
                                </li>
                                <li class="active">
                                    <span>Alumnos</span>
                                </li>
                            </ol>
                    </section>

                    <div class="container-fluid bg-white">
                        <br>
                        <br>
                        <button onclick="window.location.href='addalumno.php';" type="button"
                            class="btn btn-success">Agregar Alumnos</button>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="row margin-top-30">
                                    <div class="col-sm-9 bg-light p-3 border">
                                        <div class="panel panel-white">
                                            <div class="container">
                                                <br>
                                                <h2>Alumnos</h2>
                                                <form method="POST" action="">
                                                    <div class="form-group">
                                                        <label for="opcion">Filtrar por grado:</label>
                                                        <select class="form-control" id="opcion" name="opcion"
                                                            autocomplete="off">
                                                            <option value="todo">Todo</option>
                                                            <option value="primero">Primeros</option>
                                                            <option value="1A">1A</option>
                                                            <option value="1B">1B</option>
                                                            <option value="1C">1C</option>
                                                            <option value="1D">1D</option>
                                                            <option value="segundo">Segundos</option>
                                                            <option value="2A">2A</option>
                                                            <option value="2B">2B</option>
                                                            <option value="2C">2C</option>
                                                            <option value="tercero">Terceros</option>
                                                            <option value="3A">3A</option>
                                                            <option value="3B">3B</option>
                                                            <option value="3C">3C</option>
                                                        </select>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Mostrar</button>
                                                </form>

                                                <!-- Tabla de Alumnos -->
                                                <br>
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Nombre</th>
                                                            <th>Codigo</th>
                                                            <th>Grado</th>
                                                            <th>Encargado</th>
                                                            <th>Telefono</th>
                                                            <th>Promedio</th>
                                                            <th>Accion</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                            $opcion = $_POST['opcion'];
                                                            $query = "SELECT A.id_alumno,A.nombre, A.codigo, G.nombre_grado, A.encargado, A.tel
                                                                        FROM alumnos A
                                                                        INNER JOIN grados G ON G.id_grado = A.grado";

                                                            switch ($opcion) {
                                                                case "primero":
                                                                    $query .= " WHERE G.nombre_grado=1";
                                                                    break;
                                                                case "segundo":
                                                                    $query .= " WHERE G.nombre_grado=2";
                                                                    break;
                                                                case "tercero":
                                                                    $query .= " WHERE G.nombre_grado=3";
                                                                    break;
                                                                case "1A":
                                                                    $query .= " WHERE G.nombre_grado ='1A'";
                                                                    break;
                                                                case "1B":
                                                                    $query .= " WHERE G.nombre_grado ='1B'";
                                                                    break;
                                                                case "1C":
                                                                    $query .= " WHERE G.nombre_grado ='1C'";
                                                                    break;
                                                                case "1D":
                                                                    $query .= " WHERE G.nombre_grado ='1D'";
                                                                    break;
                                                                case "2A":
                                                                    $query .= " WHERE G.nombre_grado ='2A'";
                                                                    break;
                                                                case "2B":
                                                                    $query .= " WHERE G.nombre_grado ='2B'";
                                                                    break;
                                                                case "2C":
                                                                    $query .= " WHERE G.nombre_grado ='2C'";
                                                                    break;
                                                                case "3A":
                                                                    $query .= " WHERE G.nombre_grado ='3A'";
                                                                    break;
                                                                case "3B":
                                                                    $query .= " WHERE G.nombre_grado ='3B'";
                                                                    break;
                                                                case "3C":
                                                                    $query .= " WHERE G.nombre_grado ='3C'";
                                                                    break;
                                                                case "todo":
                                                                    $query;
                                                                    break;
                                                                default:
                                                                    // No filtro
                                                                    break;
                                                            }

                                                            // Conectar a la base de datos
                                                            $conn = new mysqli("localhost", "root", "", "san-andres");

                                                            if ($conn->connect_error) {
                                                                die("Conexión fallida: " . $conn->connect_error);
                                                            }

                                                            $result = $conn->query($query);

                                                            if ($result->num_rows > 0) {
                                                                while ($row = $result->fetch_assoc()) {
                                                                    echo "<tr>";
                                                                    echo "<td>" . $row["id_alumno"] . "</td>";
                                                                    echo "<td>" . $row["nombre"] . "</td>";
                                                                    echo "<td>" . $row["codigo"] . "</td>";
                                                                    echo "<td>" . $row["nombre_grado"] . "</td>";
                                                                    echo "<td>" . $row["encargado"] . "</td>";
                                                                    echo "<td>" . $row["tel"] . "</td>";
                                                                    echo "<td>" . $row["promedio"] . "</td>";
                                                                    echo "<td>   <button type='button' class='btn btn-warning' onclick='openModal(" . $row["id_alumno"] . ")'>Modificar</button> </td>";
                                                                    echo "</tr>";
                                                                }
                                                            } else {
                                                                echo "<tr><td colspan='8'>No se encontraron resultados</td></tr>";
                                                            }

                                                            $conn->close();
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                <!-- Fin de la tabla -->

                                                <!-- Modal para editar -->
                                                <div class="modal fade" id="editModal" tabindex="-1" role="dialog"
                                                    aria-labelledby="editModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="editModalLabel">Editar
                                                                    Alumno</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="POST" action="update_alumno.php">
                                                                    <div class="form-group">
                                                                        <label for="editId">ID</label>
                                                                        <input type="text" class="form-control"
                                                                            id="editId" name="id_alumno" readonly
                                                                            autocomplete="off">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="editNombre">Nombre</label>
                                                                        <input type="text" class="form-control"
                                                                            id="editNombre" name="nombre"
                                                                            autocomplete="name" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="editCodigo">Código</label>
                                                                        <input type="text" class="form-control"
                                                                            id="editCodigo" name="codigo"
                                                                            autocomplete="off" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="editGrado">Grado</label>
                                                                        <input type="text" class="form-control"
                                                                            id="editGrado" name="grado"
                                                                            autocomplete="off" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="editEncargado">Encargado</label>
                                                                        <input type="text" class="form-control"
                                                                            id="editEncargado" name="encargado"
                                                                            autocomplete="name" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="editTelefono">Teléfono</label>
                                                                        <input type="text" class="form-control"
                                                                            id="editTelefono" name="tel"
                                                                            autocomplete="tel" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="editPromedio">Promedio</label>
                                                                        <input type="text" class="form-control"
                                                                            id="editPromedio" name="promedio"
                                                                            autocomplete="off" required>
                                                                    </div>
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Guardar Cambios</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Fin del Modal -->

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
    <script>
    function openModal(id) {
        $.ajax({
            url: 'get_alumno.php',
            type: 'POST',
            data: {
                id_alumno: id
            },
            success: function(response) {
                var data = JSON.parse(response);
                $('#editId').val(data.id_alumno);
                $('#editNombre').val(data.nombre);
                $('#editCodigo').val(data.codigo);
                $('#editGrado').val(data.grado);
                $('#editEncargado').val(data.encargado);
                $('#editTelefono').val(data.tel);
                $('#editPromedio').val(data.promedio);
                $('#editModal').modal('show');
            }
        });
    }
    </script>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

</body>

</html>