

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
								<h1 class="mainTitle">Administrador | Profesores</h1>
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
												<h5 class="panel-title">Agregar profesor</h5>
											</div>
											<div class="panel-body">
												<form role="form" name="book" method="post" action="agregarprof.php">
													<div class="form-group">
														<label for="profname">Nombre</label>
														<input type="text" id="name" name="name" class="form-control" required="required">
														<br>
                                                        <label for="proftel">Teléfono</label>
														<input type="number" id="phone" name="phone" class="form-control" required="required">
														<br>
                                                        <label for="profuser">Usuario</label>
														<input type="text" id="user" name="user" class="form-control" required="required">
														<br>
                                                        <label for="profcode">Codigo</label>
														<input type="text" id="codigo" name="codigo" class="form-control" required="required">
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