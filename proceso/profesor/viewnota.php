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

// Variables de filtrado
$selected_curso = isset($_POST['curso']) ? $_POST['curso'] : '';
$selected_grado = isset($_POST['grado']) ? $_POST['grado'] : '';
$selected_alumno = isset($_POST['alumno']) ? $_POST['alumno'] : '';

// Consulta para obtener los cursos disponibles con el grado
$cursos_result = $conn->query("
    SELECT DISTINCT C.id_curso, C.nombre_curso, G.nombre_grado
    FROM curso C
    INNER JOIN grados G ON G.id_grado = C.grado
    INNER JOIN profesor P ON P.id_prof = C.profesor
    WHERE P.id_prof = $id_prof
");

// Consulta para obtener los grados disponibles
$grados_result = $conn->query("
    SELECT DISTINCT G.id_grado, G.nombre_grado
    FROM grados G
    INNER JOIN curso C ON G.id_grado = C.grado
    INNER JOIN profesor P ON P.id_prof = C.profesor
    WHERE P.id_prof = $id_prof
");

// Consulta para obtener los alumnos disponibles
$alumnos_result = $conn->query("
    SELECT DISTINCT A.id_alumno, A.nombre
    FROM alumnos A
    INNER JOIN notas N ON A.id_alumno = N.id_alumno
    INNER JOIN curso C ON N.id_curso = C.id_curso
    WHERE C.profesor = $id_prof
");

// Construcción dinámica de la consulta SQL
$sql = "SELECT A.nombre, N.nota, AC.nombre_act, C.nombre_curso, G.nombre_grado
        FROM notas N
        INNER JOIN alumnos A ON N.id_alumno = A.id_alumno
        INNER JOIN curso C ON N.id_curso = C.id_curso
        INNER JOIN actividades AC ON N.id_actividad = AC.id_actividad
        INNER JOIN grados G ON G.id_grado = C.grado
        INNER JOIN profesor P ON P.id_prof = C.profesor
        WHERE P.id_prof = ?";

$params = [$id_prof];
$types = 'i';

if ($selected_curso) {
    $sql .= " AND C.id_curso = ?";
    $params[] = $selected_curso;
    $types .= 'i';
}

if ($selected_grado) {
    $sql .= " AND G.id_grado = ?";
    $params[] = $selected_grado;
    $types .= 'i';
}

if ($selected_alumno) {
    $sql .= " AND A.id_alumno = ?";
    $params[] = $selected_alumno;
    $types .= 'i';
}

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
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

    <script>
$(document).ready(function() {
    // Manejar el clic en el botón de Editar
    $('.btn-warning').click(function() {
        // Obtener los datos de la fila correspondiente
        var row = $(this).closest('tr');
        var alumno = row.find('td:eq(0)').text();
        var curso = row.find('td:eq(1)').text();
        var grado = row.find('td:eq(2)').text();
        var actividad = row.find('td:eq(3)').text();
        var nota = row.find('td:eq(4)').text();
        var id = row.find('td:eq(5)').data('id'); // Supongamos que el ID está en un atributo data-id

        // Rellenar el formulario del modal con los datos de la fila
        $('#edit_id').val(id);
        $('#edit_alumno').val(alumno);
        $('#edit_curso').val(curso);
        $('#edit_grado').val(grado);
        $('#edit_actividad').val(actividad);
        $('#edit_nota').val(nota);

        // Mostrar el modal
        $('#editModal').modal('show');
    });

    // Manejar el envío del formulario del modal
    $('#editForm').submit(function(event) {
        event.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
            url: 'update_note.php', // Archivo PHP que maneja la actualización
            method: 'POST',
            data: formData,
            success: function(response) {
                // Cerrar el modal y recargar la página (o actualizar la tabla)
                $('#editModal').modal('hide');
                location.reload(); // Puedes actualizar solo la tabla si prefieres
            },
            error: function() {
                alert("Error al actualizar la nota");
            }
        });
    });
});
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
                                <h1 class="mainTitle">Profesor | Notas</h1>
                            </div>
                            <ol class="breadcrumb">
                                <li>
                                    <span>Profesor</span>
                                </li>
                                <li class="active">
                                    <span>Notas</span>
                                </li>
                            </ol>
                    </section>
                    <div class="container-fluid bg-white">
                        <br>
                        <h2>Notas</h2>
                        <br>
                        <form method="post" action="">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="curso">Curso:</label>
                                    <select name="curso" class="form-control">
                                        <option value="">Seleccionar Curso</option>
                                        <?php while ($row = $cursos_result->fetch_assoc()) { ?>
                                            <option value="<?php echo $row['id_curso']; ?>" <?php if ($selected_curso == $row['id_curso']) echo 'selected'; ?>>
                                                <?php echo $row['nombre_curso'] . " - " . $row['nombre_grado']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="alumno">Alumno:</label>
                                    <select name="alumno" class="form-control">
                                        <option value="">Seleccionar Alumno</option>
                                        <?php while ($row = $alumnos_result->fetch_assoc()) { ?>
                                            <option value="<?php echo $row['id_alumno']; ?>" <?php if ($selected_alumno == $row['id_alumno']) echo 'selected'; ?>>
                                                <?php echo $row['nombre']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary">Filtrar</button>
                        </form>
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
                                                            <th>Alumno</th>
                                                            <th>Curso</th>
                                                            <th>Grado</th>
                                                            <th>Actividad</th>
                                                            <th>Nota</th>
                                                            <th>Accion</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $total_notas = 0;

                                                        if ($result->num_rows > 0) {
                                                            while ($row = $result->fetch_assoc()) {
                                                                $total_notas += $row["nota"];
                                                                echo "<tr>
                                                                        <td>" . $row["nombre"] . "</td>
                                                                        <td>" . $row["nombre_curso"] . "</td>
                                                                        <td>" . $row["nombre_grado"] . "</td>
                                                                        <td>" . $row["nombre_act"] . "</td>
                                                                        <td>" . $row["nota"] . "</td>
                                                                        <td> <button type='button' class='btn btn-warning'>Editar</button></td>
                                                                      </tr>";
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='5'>No se encontraron resultados</td></tr>";
                                                        }
                                                        ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="5" class="text-right"><strong>Total acumulado:</strong></td>
                                                            <td><?php echo $total_notas; ?></td>
                                                        </tr>
                                                    </tfoot>
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

<!-- Modal para Editar Notas -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar Nota</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="form-group">
                        <label for="edit_alumno">Alumno</label>
                        <input type="text" class="form-control" id="edit_alumno" name="alumno" readonly>
                    </div>
                    <div class="form-group">
                        <label for="edit_curso">Curso</label>
                        <input type="text" class="form-control" id="edit_curso" name="curso" readonly>
                    </div>
                    <div class="form-group">
                        <label for="edit_grado">Grado</label>
                        <input type="text" class="form-control" id="edit_grado" name="grado" readonly>
                    </div>
                    <div class="form-group">
                        <label for="edit_actividad">Actividad</label>
                        <input type="text" class="form-control" id="edit_actividad" name="actividad">
                    </div>
                    <div class="form-group">
                        <label for="edit_nota">Nota</label>
                        <input type="number" class="form-control" id="edit_nota" name="nota">
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
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
$conn->close();
?>
