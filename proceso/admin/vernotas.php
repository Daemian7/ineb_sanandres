<?php
// Conexión a la base de datos
$servidor = "localhost";
$usuario = "root";
$password = "";
$bd = "san-andres";

$conexion = mysqli_connect($servidor, $usuario, $password, $bd);

if (!$conexion) {
    die("Error en la conexión: " . mysqli_connect_error());
}

// Procesar el formulario cuando se envíe
$result = null;
if (isset($_POST['curso']) && isset($_POST['alumno']) && isset($_POST['bimestre'])) {
    $grado = $_POST['curso'];
    $alumno = $_POST['alumno'];
    $bimestre = $_POST['bimestre'];

    // Consulta para obtener las notas filtradas
    $query = "SELECT A.nombre as alumno, G.nombre_grado as grado, C.nombre_curso as curso, CF.promedio 
              FROM calificaciones CF
              JOIN alumnos A ON CF.id_alumno = A.id_alumno
              JOIN grados G ON A.grado = G.id_grado
              JOIN curso C ON CF.id_curso = C.id_curso
              WHERE A.grado = '$grado' AND A.id_alumno = '$alumno' AND CF.id_bimestre = '$bimestre'";

    $result = mysqli_query($conexion, $query);

    if (!$result) {
        echo "Error en la consulta: " . mysqli_error($conexion);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INEB SAN ANDRES</title>
    <!-- Include Bootstrap and other necessary CSS files -->
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/plugins.css">
    <link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>

    <script>
    // Función para cargar los grados mediante AJAX
    $(document).ready(function() {
        cargarGrados();
    });

    function cargarGrados() {
        $.ajax({
            url: 'getgrade.php',
            method: 'GET',
            success: function(data) {
                $('#curso').html('<option value="">Selecciona Grado</option>' + data);
            },
            error: function() {
                alert("Error al cargar los grados");
            }
        });
    }

    // Función para cargar alumnos según el grado seleccionado
    function cargarAlumnos(idGrado) {
        if (idGrado) {
            $.ajax({
                url: 'get_alumnos.php',
                method: 'POST',
                data: { grado_id: idGrado },
                success: function(data) {
                    $('#alumno').html('<option value="">Selecciona Alumno</option>' + data);
                },
                error: function() {
                    alert("Error al cargar los alumnos");
                }
            });
        } else {
            $('#alumno').html('<option value="">Selecciona Alumno</option>');
        }
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
                                <h1 class="mainTitle">Admin | Notas</h1>
                            </div>
                            <ol class="breadcrumb">
                                <li><span>Admin</span></li>
                                <li class="active"><span>Notas</span></li>
                            </ol>
                    </section>
                    <div class="container-fluid bg-white">
                        <form role="form" name="book" method="post" action="#">
                            <br>
                            <div class="form-group">
                                <label for="curso">Grado</label>
                                <select name="curso" class="form-control" id="curso" required="required" onchange="cargarAlumnos(this.value)">
                                    <option value="">Selecciona Grado</option>
                                    <!-- Aquí se cargarán los grados dinámicamente con AJAX -->
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="alumno">Alumno</label>
                                <select name="alumno" class="form-control" id="alumno" required>
                                    <option value="">Selecciona Alumno</option>
                                    <!-- Aquí se cargarán los alumnos dinámicamente con AJAX -->
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="bimestre">Bimestre</label>
                                <select name="bimestre" class="form-control" id="bimestre" required="required">
                                    <option value="1">Bimestre 1</option>
                                    <option value="2">Bimestre 2</option>
                                    <option value="3">Bimestre 3</option>
                                    <option value="4">Bimestre 4</option>
                                </select>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">Filtrar</button>
                        </form>

                        <?php if ($result && mysqli_num_rows($result) > 0): ?>
                            <div class="container">
                                <br><br>
                                <h2>Resultados de Filtrado</h2>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Alumno</th>
                                            <th>Curso</th>
                                            <th>Grado</th>
                                            <th>Nota Final</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                            <tr>
                                                <td><?php echo $row['alumno']; ?></td>
                                                <td><?php echo $row['curso']; ?></td>
                                                <td><?php echo $row['grado']; ?></td>
                                                <td><?php echo $row['promedio']; ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2">Generar boleta</td>
                                            <td colspan="2">
                                            <a href="fpdf/PruebaV.php?curso=<?php echo urlencode($grado); ?>&alumno=<?php echo urlencode($alumno); ?>&bimestre=<?php echo urlencode($bimestre); ?>" target="_blank" class="btn btn-success">
                <i class="bi bi-file-earmark-pdf-fill"></i>
            </a>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        <?php elseif ($result): ?>
                            <div class="container">
                                <h4>No se encontraron resultados</h4>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
        <?php include('include/footer.php'); ?>
    </div>
</body>
</html>
