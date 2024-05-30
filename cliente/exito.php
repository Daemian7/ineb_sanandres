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
								<h1 class="mainTitle">¡Tu Reservación ha sido registrada!</h1>
								<br>
								<br>
								<br>
								<h3>Datos de facturación:</h3>
								<br>
								<table class="table">
									<thead>
										<tr>
											<th scope="col">#</th>
											<th scope="col">Nombre</th>
											<th scope="col">Teléfono</th>
											<th scope="col">Email</th>
											<th scope="col">Servicio</th>
											<th scope="col">Empleado</th>
											<th scope="col">Fecha</th>
											<th scope="col">Hora</th>
											<th scope="col">Costo</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$servidor = "localhost";
										$usuario = "root";
										$password = "";
										$bd = "barberia_p";

										$conexion = new mysqli($servidor, $usuario, $password, $bd);

										if ($conexion->connect_error) {
											die("Conexión fallida: " . $conexion->connect_error);
										}

										// Aquí asumimos que el ID de la cita se pasa a través de la URL como parámetro 'id'
										$last_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

										$sql = "SELECT C.id_cita, C.cliente, C.tel, C.email, S.servicio, E.nombre, C.fecha, C.hora, S.precio 
										FROM servicios S
										INNER JOIN Cita C ON S.id_servicios = C.id_servicio
										INNER JOIN empleados E ON E.id_empleado = C.id_empleado
										WHERE C.id_cita = $last_id";

										$result = $conexion->query($sql);


										
										if ($result && $result->num_rows > 0) {
											while ($row = $result->fetch_assoc()) {
												echo "<tr>
													<td>" . $row["id_cita"] . "</td>
													<td>" . $row["cliente"] . "</td>
													<td>" . $row["tel"] . "</td>
													<td>" . $row["email"] . "</td>
													<td>" . $row["servicio"] . "</td>
													<td>" . $row["nombre"] . "</td>
													<td>" . $row["fecha"] . "</td>
													<td>" . $row["hora"] . "</td>
													<td>Q" . $row["precio"] . ".00</td>
												</tr>";
											}
										} else {
											echo "<tr><td colspan='9'>No se encontraron datos.</td></tr>";
										}

										$conexion->close();
										?>
									</tbody>
								</table>

								<h4><a href="../index.html">Volver a la página de inicio</a></h4>
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
		<?php include('include/footer.php'); ?>
	</div>
	<script src="vendor/jquery/jquery.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
