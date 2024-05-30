<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_empleado'])) {
    header("Location: login.php");
    exit();
}

$id_empleado = $_SESSION['id_empleado'];

?>


<!DOCTYPE html>
<html lang="en">

<head>
	<title>User | Book Appointment</title>
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
                                <h1 class="mainTitle">Barbero | Citas</h1>
                            </div>
                            <ol class="breadcrumb">
                                <li>
                                    <span>Barbero</span>
                                </li>
                                <li class="active">
                                    <span>Citas</span>
                                </li>
                            </ol>
                    </section>
                    <div class="container-fluid container-fullw bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row margin-top-30">
                                    <div class="col-lg-8 col-md-12">
                                        <div class="panel panel-white">
                                            <div class="container">
        <h2>Citas reservadas</h2>
      

        <?php
            $servidor = "localhost";
            $usuario = "root";
            $password = "";
            $bd = "barberia_p";

            $conexion = new mysqli($servidor, $usuario, $password, $bd);

            if ($conexion->connect_error) {
                die("Conexión fallida: " . $conexion->connect_error);
            }


                    $sql = "SELECT C.id_cita, C.cliente, C.tel, C.email, S.servicio, C.fecha, C.hora 
                            FROM Cita C 
                            INNER JOIN servicios S ON S.id_servicios = C.id_servicio 
                            INNER JOIN empleados E ON E.id_empleado = C.id_empleado 
                            WHERE C.id_empleado = $id_empleado"; 

            $result = $conexion->query($sql);

            if ($result && $result->num_rows > 0) {
                echo "<table class='table'>
                        <thead>
                            <tr>
                                <th scope='col'>No</th>
                                <th scope='col'>Cliente</th>
                                <th scope='col'>Teléfono</th>
                                <th scope='col'>Email</th>
                                <th scope='col'>Servicio</th>
                                <th scope='col'>Fecha</th>
                                <th scope='col'>Hora</th>
                                <th scope='col'>Acción</th>
                            </tr>
                        </thead>
                        <tbody>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row["id_cita"] . "</td>
                            <td>" . $row["cliente"] . "</td>
                            <td>" . $row["tel"] . "</td>
                            <td>" . $row["email"] . "</td>
                            <td>" . $row["servicio"] . "</td>
                            <td>" . $row["fecha"] . "</td>
                            <td>" . $row["hora"] . "</td>
                            <td>
                                <form method='POST' action='' onsubmit='return confirm(\"¿Seguro que quieres borrar esta cita?\");'>
                                    <input type='hidden' name='delete_id' value='" . $row["id_cita"] . "'>
                                    <button type='submit' class='btn btn-danger'>Borrar</button>
                                </form>
                            </td>
                        </tr>";
                }

                echo "</tbody>
                    </table>";
            } else {
                echo "<p>No se encontraron resultados.</p>";
            }

            $conexion->close();
        

        // Manejo de la eliminación de citas
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
            $delete_id = $_POST['delete_id'];

            $servidor = "localhost";
            $usuario = "root";
            $password = "";
            $bd = "barberia_p";

            $conexion = new mysqli($servidor, $usuario, $password, $bd);

            if ($conexion->connect_error) {
                die("Conexión fallida: " . $conexion->connect_error);
            }

            $sql_delete = "DELETE FROM Cita WHERE id_cita = ?";
            $stmt = $conexion->prepare($sql_delete);
            $stmt->bind_param("i", $delete_id);

            if ($stmt->execute()) {
                echo "<p>Cita borrada exitosamente.</p>";
            } else {
                echo "<p>Error al borrar la cita: " . $conexion->error . "</p>";
            }

            $stmt->close();
            $conexion->close();
        }
        ?>
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
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

</body>

</html>