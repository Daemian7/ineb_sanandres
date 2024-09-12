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

$result = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $profesor_id = $_POST['prof'] ?? '';
    $curso_id = $_POST['curso'] ?? '';
    $alumno_id = $_POST['alumno'] ?? '';
    $bimestre_id = $_POST['bimestre'] ?? '';

    $sql = "SELECT A.nombre AS alumno, MAX(CF.promedio) AS promedio, C.nombre_curso AS curso, G.nombre_grado AS grado
        FROM notas N
        INNER JOIN alumnos A ON N.id_alumno = A.id_alumno
        INNER JOIN curso C ON N.id_curso = C.id_curso
        INNER JOIN grados G ON G.id_grado = C.grado
        INNER JOIN calificaciones CF ON CF.id_alumno = A.id_alumno
        INNER JOIN actividades AC ON AC.curso = C.id_curso
        INNER JOIN bimestre B ON B.id_bimestre = AC.bimestre
        WHERE 1=1";

// Asegúrate de inicializar las variables antes de usarlas
$types = '';
$params = [];

if ($alumno_id) {
    $sql .= " AND A.id_alumno = ?";
    $params[] = $alumno_id;
    $types .= 'i';  // Agrega 'i' para indicar un entero
}

if ($curso_id) {
    $sql .= " AND C.id_curso = ?";
    $params[] = $curso_id;
    $types .= 'i';  // Agrega 'i' para indicar un entero
}

if ($bimestre_id) {
    $sql .= " AND B.id_bimestre = ?";
    $params[] = $bimestre_id;
    $types .= 'i';  // Agrega 'i' para indicar un entero
}


// Añadir GROUP BY para agrupar por curso
$sql .= " GROUP BY C.id_curso";

// Puedes ordenar los resultados si es necesario
$sql .= " ORDER BY C.nombre_curso ASC";

    $stmt = $conexion->prepare($sql);
if (!$stmt) {
    die("Error en la preparación de la consulta: " . $conexion->error);
}

if (!empty($types) && !empty($params)) {
    // echo "Types: $types\n";
    // print_r($params);
    $stmt->bind_param($types, ...$params);
}

if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        // Mostrar resultados
    } else {
        echo "<p>No se encontraron resultados</p>";
    }
} else {
    die("Error en la ejecución de la consulta: " . $stmt->error);
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
                        <form role="form" name="book" method="post" action="notas.php">
                            <div class="form-group">
                                <br><br>
                                <label for="prof">Profesor</label>
                                <select name="prof" class="form-control" id="prof" required="required" onchange="cargarCursos(this.value)">
                                    <option value="">Selecciona Profesor</option>
                                    <?php
                                    $consulta = "SELECT id_prof, nombre FROM profesor";
                                    $exec = mysqli_query($conexion, $consulta);

                                    while ($fila = mysqli_fetch_array($exec)) {
                                        echo "<option value='" . $fila['id_prof'] . "'>" . $fila['nombre'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="curso">Curso y Grado</label>
                                <select name="curso" class="form-control" id="curso" required="required" onchange="cargarAlumnos(this.value)">
                                    <option value="">Selecciona Curso y Grado</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="alumno">Alumno</label>
                                <select name="alumno" class="form-control" id="alumno">
                                    <option value="">Selecciona Alumno</option>
                                </select>
                            </div>
                            <div class="form-group">
    <label for="bimestre">Bimestre</label>
    <select name="bimestre" class="form-control" id="bimestre" required="required">
        <option value="">Selecciona Bimestre</option>
        <?php
        $consultaBimestre = "SELECT id_bimestre, bimestre FROM bimestre";
        $execBimestre = mysqli_query($conexion, $consultaBimestre);

        while ($fila = mysqli_fetch_array($execBimestre)) {
            echo "<option value='" . $fila['id_bimestre'] . "'>" . $fila['bimestre'] . "</option>";
        }
        ?>
    </select>
</div>
                            <button type="submit" name="submit" class="btn btn-primary">Filtrar</button>
                        </form>
                    </div>

                    <?php if ($result): ?>
                        <div class="container">
                            <br>
                            <br>
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
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>
                                                    <td>{$row['alumno']}</td>
                                                    <td>{$row['curso']}</td>
                                                    <td>{$row['grado']}</td>
                                                    <td>{$row['promedio']}</td>
                                                  </tr>";
                                        }
                                        
                                    } else {
                                        echo "<tr><td colspan='5'>No se encontraron resultados</td></tr>";
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
        <tr>
        <td colspan="2">Generar boleta</td>
        <td colspan="2"><a href="fpdf/PruebaV.php" target="_blank" class='btn btn-success'><i class='bi bi-file-earmark-pdf-fill'></i></a></td>
            
        </tr>
    </tfoot>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    </div>

    <script>
    function cargarCursos(profesorId) {
    if (profesorId !== "") {
        fetch('getcursos.php?profesor_id=' + profesorId)
            .then(response => response.json())
            .then(data => {
                let cursoSelect = document.getElementById('curso');
                cursoSelect.innerHTML = '<option value="">Selecciona Curso y Grado</option>';
                data.cursos.forEach(curso => {
                    let option = document.createElement('option');
                    option.value = curso.id_curso;
                    option.text = curso.nombre_curso + ' - ' + curso.nombre_grado;
                    cursoSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error al cargar cursos:', error));
    }
}

function cargarAlumnos(cursoId) {
    if (cursoId !== "") {
        fetch('getalumnos.php?curso_id=' + cursoId)
            .then(response => response.json())
            .then(data => {
                let alumnoSelect = document.getElementById('alumno');
                alumnoSelect.innerHTML = '<option value="">Selecciona Alumno</option>';
                data.alumnos.forEach(alumno => {
                    let option = document.createElement('option');
                    option.value = alumno.id_alumno;
                    option.text = alumno.nombre;
                    alumnoSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error al cargar alumnos:', error));
    }
}

    </script>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>   
    
    <?php include('include/footer.php'); ?> 

    <?php 
    // Cerrar la conexión
if ($stmt) {
    $stmt->close();
}
if ($conexion) {
    mysqli_close($conexion);
}

    ?>
</body>
</html>
