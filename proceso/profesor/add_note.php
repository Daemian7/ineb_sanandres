<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_prof'])) {
    header("Location: login.php");
    exit();
}

$id_prof = $_SESSION['id_prof'];

require 'include/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_curso = $_POST['curso'];
    $id_actividad = $_POST['act'];
    $id_alumno = $_POST['alumno'];
    $nota = $_POST['nota'];
    $fecha = date('Y-m-d H:i:s'); // Fecha actual

    // Iniciar transacción
    $mysqli->begin_transaction();

    try {
        // Verificar si ya existe una nota para el alumno y la actividad
        $stmt_check = $mysqli->prepare("SELECT COUNT(*) as count FROM notas WHERE id_curso = ? AND id_alumno = ? AND id_actividad = ?");
        if ($stmt_check === false) {
            throw new Exception('Prepare failed: ' . $mysqli->error);
        }
        $stmt_check->bind_param('iii', $id_curso, $id_alumno, $id_actividad);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        $check_row = $result_check->fetch_assoc();
        $count = $check_row['count'];
        $stmt_check->close();

        if ($count > 0) {
            throw new Exception('Ya existe una nota para este alumno en esta actividad.');
        }

        // Preparar la consulta de inserción en la tabla `notas`
        $stmt = $mysqli->prepare("INSERT INTO notas (id_curso, id_alumno, id_actividad, nota, fecha) VALUES (?, ?, ?, ?, ?)");
        if ($stmt === false) {
            throw new Exception('Prepare failed: ' . $mysqli->error);
        }

        // Vincular los parámetros
        $stmt->bind_param('iiiis', $id_curso, $id_alumno, $id_actividad, $nota, $fecha);

        // Ejecutar la consulta
        if (!$stmt->execute()) {
            throw new Exception('Execute failed: ' . $stmt->error);
        }

        // Obtener el bimestre de la actividad
        $stmt_bimestre = $mysqli->prepare("SELECT bimestre FROM actividades WHERE id_actividad = ?");
        if ($stmt_bimestre === false) {
            throw new Exception('Prepare failed: ' . $mysqli->error);
        }
        $stmt_bimestre->bind_param('i', $id_actividad);
        $stmt_bimestre->execute();
        $result_bimestre = $stmt_bimestre->get_result();
        $bimestre_row = $result_bimestre->fetch_assoc();
        $id_bimestre = $bimestre_row['bimestre'];
        $stmt_bimestre->close();

        // Calcular el total acumulado de las notas del alumno para el curso y bimestre
        $stmt_sum = $mysqli->prepare("SELECT SUM(nota) as total_notas FROM notas WHERE id_curso = ? AND id_alumno = ? AND id_actividad IN (SELECT id_actividad FROM actividades WHERE bimestre = ?)");
        if ($stmt_sum === false) {
            throw new Exception('Prepare failed: ' . $mysqli->error);
        }
        $stmt_sum->bind_param('iii', $id_curso, $id_alumno, $id_bimestre);
        $stmt_sum->execute();
        $result_sum = $stmt_sum->get_result();
        $sum_row = $result_sum->fetch_assoc();
        $total_notas = $sum_row['total_notas'];
        $stmt_sum->close();

        // Verificar si el total de notas del bimestre alcanza o supera 100
        if ($total_notas > 100) {
            throw new Exception('El total de notas para este bimestre ha alcanzado el límite de 100.');
        }

        // Verificar si ya existe una entrada en `calificaciones` para este alumno, curso y bimestre
        $stmt_check_calificaciones = $mysqli->prepare("SELECT COUNT(*) as count FROM calificaciones WHERE id_alumno = ? AND id_curso = ? AND id_bimestre = ?");
        if ($stmt_check_calificaciones === false) {
            throw new Exception('Prepare failed: ' . $mysqli->error);
        }
        $stmt_check_calificaciones->bind_param('iii', $id_alumno, $id_curso, $id_bimestre);
        $stmt_check_calificaciones->execute();
        $result_check_calificaciones = $stmt_check_calificaciones->get_result();
        $check_row_calificaciones = $result_check_calificaciones->fetch_assoc();
        $count_calificaciones = $check_row_calificaciones['count'];
        $stmt_check_calificaciones->close();

        if ($count_calificaciones > 0) {
            // Actualizar la entrada existente en `calificaciones`
            $stmt_update = $mysqli->prepare("UPDATE calificaciones SET promedio = ? WHERE id_alumno = ? AND id_curso = ? AND id_bimestre = ?");
            if ($stmt_update === false) {
                throw new Exception('Prepare failed: ' . $mysqli->error);
            }
            $stmt_update->bind_param('diii', $total_notas, $id_alumno, $id_curso, $id_bimestre);
            $stmt_update->execute();
            $stmt_update->close();
        } else {
            // Insertar una nueva entrada en `calificaciones`
            $stmt_insert = $mysqli->prepare("INSERT INTO calificaciones (id_alumno, id_curso, id_bimestre, promedio) VALUES (?, ?, ?, ?)");
            if ($stmt_insert === false) {
                throw new Exception('Prepare failed: ' . $mysqli->error);
            }
            $stmt_insert->bind_param('iiid', $id_alumno, $id_curso, $id_bimestre, $total_notas);
            $stmt_insert->execute();
            $stmt_insert->close();
        }

        // Confirmar la transacción
        $mysqli->commit();

        echo "<script>
            alert('Nota agregada exitosamente');
            window.location.href = 'vernotas.php';
          </script>";
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $mysqli->rollback();
        echo "<script>
            alert('Error: " . $e->getMessage() . "');
            window.location.href = 'vernotas.php';
          </script>";
    }

    // Cerrar la declaración
    $stmt->close();
}

// Cerrar la conexión
$mysqli->close();
?>
