<?php
require('fpdf.php');

// Configurar la zona horaria correcta
date_default_timezone_set('America/Guatemala');

class PDF extends FPDF
{
    // Pie de página
    function Footer()
    {
        // Posición a 1.5 cm del final
        $this->SetY(-15);
        // Establecer la fuente
        $this->SetFont('Arial', 'I', 8);
        // Fecha y hora actual
        $fecha = date('d/m/Y');
        $hora = date('H:i:s');
        $this->Cell(0, 10, 'Generado el: ' . $fecha . ' a las ' . $hora, 0, 0, 'C');
    }
}

// Conexión a la base de datos
$servidor = "localhost";
$usuario = "root";
$password = "";
$bd = "san-andres";

$conexion = mysqli_connect($servidor, $usuario, $password, $bd);

if (!$conexion) {
    die("Error en la conexión: " . mysqli_connect_error());
}

// Obtener los parámetros desde la URL
$curso = $_GET['curso'] ?? '';
$alumno = $_GET['alumno'] ?? '';
$bimestre = $_GET['bimestre'] ?? '';

// Preparar la consulta SQL con los filtros
$sql = "SELECT A.nombre as alumno, G.nombre_grado as grado, C.nombre_curso as curso, CF.promedio 
        FROM calificaciones CF
        JOIN alumnos A ON CF.id_alumno = A.id_alumno
        JOIN grados G ON A.grado = G.id_grado
        JOIN curso C ON CF.id_curso = C.id_curso
        WHERE A.grado = ? AND A.id_alumno = ? AND CF.id_bimestre = ?
        ORDER BY C.nombre_curso ASC";

// Preparar y ejecutar la consulta
$stmt = $conexion->prepare($sql);
$stmt->bind_param('iis', $curso, $alumno, $bimestre);
$stmt->execute();
$result = $stmt->get_result();

// Obtener resultados
$rows = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
}

// Crear PDF usando la clase PDF personalizada
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

// Logo de la empresa
$pdf->Image('../images/logo.jpg', 185, 5, 20);

// Título principal
$pdf->SetFont('Arial', 'B', 19);
$pdf->Cell(45);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(110, 15, utf8_decode('INEB SAN ANDRES VILLA SECA'), 0, 1, 'C', 0);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(50);
$pdf->Cell(100, 10, utf8_decode("Instituto Nacional de Educacion Basica Por Cooperativa San Andres Villa Seca"), 0, 1, 'C');
$pdf->Ln(1);
$pdf->Ln(3);

// Mostrar los resultados del alumno, grado y cursos
if (!empty($rows)) {
    $row = $rows[0]; // Para obtener datos del alumno y grado
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 5, 'Alumno: ' . $row['alumno'], 0, 1, 'L');
    $pdf->Cell(0, 5, 'Grado: ' . $row['grado'], 0, 1, 'L');
    $pdf->Ln(4);
} else {
    $pdf->Cell(0, 10, 'No se encontraron resultados', 1, 1, 'C');
}

// Subtítulo de la tabla
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(50);
$pdf->SetFont('Arial', 'B', 15);
$pdf->Cell(100, 10, utf8_decode("BOLETA DE CALIFICACIONES"), 0, 1, 'C', 0);
$pdf->Ln(7);

$pdf->SetFont('Arial', 'B', 12);
// Encabezado de la tabla
$pdf->Cell(60, 10, 'Curso', 1);
$pdf->Cell(30, 10, 'Nota', 1);
$pdf->Ln();

// Desplegar los cursos y notas
if (!empty($rows)) {
    foreach ($rows as $row) {
        $pdf->Cell(60, 10, utf8_decode($row['curso']), 1);
        $pdf->Cell(30, 10, $row['promedio'], 1);
        $pdf->Ln();
    }
} else {
    $pdf->Cell(0, 10, 'No se encontraron resultados', 1, 1, 'C');
}

// Pie de página con el nombre del director
$pdf->Ln(20);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(50);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(100, 10, utf8_decode("(Vo.Bo.)__________________________"), 0, 1, 'C');
$pdf->Ln(1);
$pdf->Cell(50);
$pdf->Cell(100, 10, utf8_decode("JORGE LUIS SÁNCHEZ WERNER"), 0, 1, 'C');
$pdf->Ln(1);
$pdf->Cell(50);
$pdf->Cell(100, 10, utf8_decode("Director"), 0, 1, 'C');
$pdf->Ln(1);

$pdf->Output();
?>
