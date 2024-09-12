

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
								<h1 class="mainTitle">Administrador | Alumnos</h1>
							</div>
							<ol class="breadcrumb">
								<li>
									<span>Admin</span>
								</li>
								<li class="active">
									<span>Agregar</span>
								</li>
							</ol>
					</section>
					<div class="container-fluid container-fullw bg-white">
						<div class="row">
							<div class="col-md-12">
								<div class="row margin-top-30">
									<div class="col-lg-8 col-md-12">
										<div class="panel panel-white">
											<div class="panel-heading">
												<h5 class="panel-title">Agregar alumno</h5>
											</div>
											<div class="panel-body">
												<form role="form" name="book" method="post" action="agregar.php">
													<div class="form-group">
														<label for="studentname">Nombre Completo</label>
														<input type="text" id="name" name="name" class="form-control" required="required">
														<br>
                                                        <label for="studentcode">Codigo</label>
														<input type="text" id="codigo" name="codigo" class="form-control" required="required">
														<br>
														<div class="form-group">
														<label for="grade">Grado</label>
														<select name="grade" class="form-control" id="grade" required="required" onclick="selectgrade(this.value)">
															<option value="">Selecciona Grado</option>
															<?php include "getgrade.php"?>
														</select>
													</div>
														<br>
                                                        <label for="studentenc">Nombre de Encargado</label>
														<input type="text" id="encargado" name="encargado" class="form-control" required="required">
														<br>
														<label for="clientenum">Teléfono</label>
														<input type="number" id="phone" name="phone" class="form-control" required="required">
														<br>
													<div class="form-group">
														<label for="AppointmentDate">Fecha de Nacimiento</label>
														<input class="form-control datepicker" type="date" name="date" required="required" data-date-format="yyyy-mm-dd">
													</div>
                                                    <br>
													<button type="submit" name="submit" class="btn btn-o btn-primary">Agregar</button>
												</form>
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
	<script src="vendor/jquery/jquery.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>

</body>

</html>