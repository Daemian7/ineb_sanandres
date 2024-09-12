

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

    <script type="text/javascript">
function selectgrade(str){
	var conexion;
	if(str==""){
		document.getElementById("txtHint").innerHTML="";
		return;
	}
	if (window.XMLHttpRequest) {
		conexion=new XMLHttpRequest();
	}
	conexion.onreadystatechange=function () {
		if (conexion.readyState==4&&conexion.status==200) {
			document.getElementById("servicio").innerHTML=conexion.responseText;
		}
	}
	conexion.open("get", "select.php?c="+str,true);
	conexion.send();
}
</script>

<script type="text/javascript">
function selectprof(str){
	var conexion;
	if(str==""){
		document.getElementById("txtHint").innerHTML="";
		return;
	}
	if (window.XMLHttpRequest) {
		conexion=new XMLHttpRequest();
	}
	conexion.onreadystatechange=function () {
		if (conexion.readyState==4&&conexion.status==200) {
			document.getElementById("servicio").innerHTML=conexion.responseText;
		}
	}
	conexion.open("get", "select.php?c="+str,true);
	conexion.send();
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
                                <h1 class="mainTitle">Admin | Cursos</h1>
                            </div>
                            <ol class="breadcrumb">
                                <li>
                                    <span>Admin</span>
                                </li>
                                <li class="active">
                                    <span>Cursos</span>
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
												<h5 class="panel-title">Agregar Curso</h5>
											</div>
											<div class="panel-body">
												<form role="form" name="book" method="post" action="agregarcurso.php">
													<div class="form-group">
														<label for="profname">Nombre</label>
														<input type="text" id="name" name="name" class="form-control" required="required">
														<br>
                                                        <div class="form-group">
														<label for="grade">Grado</label>
														<select name="grade" class="form-control" id="grade" required="required" onclick="selectgrade(this.value)">
															<option value="">Selecciona Grado</option>
															<?php include "getgrade.php"?>
														</select>
													</div>
														<br>
                                                        <div class="form-group">
														<label for="prof">Profesor</label>
														<select name="prof" class="form-control" id="prof" required="required" onclick="selectprof(this.value)">
															<option value="">Selecciona Profesor</option>
															<?php include "getprof.php"?>
														</select>
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