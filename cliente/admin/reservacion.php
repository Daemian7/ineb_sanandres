<?php
$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$servicio = $_POST['servicio'];
$barber = $_POST['barber'];
$date = $_POST['date'];
$time = $_POST['time'];

$servidor = "localhost";
$usuario = "root";
$password = "";
$bd = "barberia_p";

$conexion = mysqli_connect($servidor, $usuario, $password, $bd);

if (!$conexion) {
    echo "Error en la conexión";
} else {
    // Verificar si ya existe una cita con la misma fecha y hora
    $stmt_check = $conexion->prepare("SELECT * FROM cita WHERE fecha = ? AND hora = ? AND id_empleado = ?");
    $stmt_check->bind_param("sss", $date, $time, $barber);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows > 0) {
        // Ya existe una cita con la misma fecha y hora para el mismo barbero
        echo "<script>alert('Ya existe una cita con la misma fecha y hora para el barbero seleccionado.'); window.history.back();</script>";    } else {
        // No existe una cita con la misma fecha y hora, se puede proceder a insertar la nueva cita
        $stmt = $conexion->prepare("INSERT INTO cita (id_cita, cliente, tel, email, id_servicio, id_empleado, fecha, hora, estado) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $name, $phone, $email, $servicio, $barber, $date, $time, $estado);
        $estado = '1'; // El estado '1' se asigna aquí
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $last_id = mysqli_insert_id($conexion);
            echo "Reservación realizada con éxito. El ID de su cita es: " . $last_id;
            header("Location: exito.php?id=" . $last_id);
            exit(); // Terminar el script después de la redirección
        } else {
            echo "Error al realizar la reservación";
        }

        $stmt->close();
    }

    $stmt_check->close();
}

$conexion->close();
?>
