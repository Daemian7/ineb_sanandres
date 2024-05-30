

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

<script type="text/javascript">
function selectserv(str){
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
function selectbarber(str){
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
								<h1 class="mainTitle">Usuario | Reservación</h1>
							</div>
							<ol class="breadcrumb">
								<li>
									<span>User</span>
								</li>
								<li class="active">
									<span>Reservación</span>
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
												<h5 class="panel-title">Reservación</h5>
											</div>
											<div class="panel-body">
												<form role="form" name="book" method="post" action="reservacion.php">
													<div class="form-group">
														<label for="Clientename">Nombre y Apellido</label>
														<input type="text" id="name" name="name" class="form-control" required="required">
														<br>
														<label for="clientenum">Teléfono</label>
														<input type="number" id="phone" name="phone" class="form-control" required="required">
														<br>
														<label for="clientemail">Correo Electrónico</label>
														<input type="email" id="email" name="email" class="form-control" required="required">
														<br>
														<label for="servicio">Servicio</label>
														<select name="servicio" id="servicio" class="form-control" required="required" onclick="selectserv(this.value)">
															<option value="">Selecciona un Servicio</option>
															<?php include "barberserv.php"?>
														</select>
													</div>
													<div class="form-group">
														<label for="barber">Barberos</label>
														<select name="barber" class="form-control" id="barber" required="required" onclick="selectbarber(this.value)">
															<option value="">Selecciona Barberos</option>
															<?php include "getbarber.php"?>
														</select>
													</div>
													<div class="form-group">
														<label for="AppointmentDate">Fecha</label>
														<input class="form-control datepicker" type="date" name="date" required="required" data-date-format="yyyy-mm-dd">
													</div>
													<div class="form-group">
														<label for="Appointmenttime">Hora</label>
														<input class="form-control" type="time" name="time" id="time" value="09:00" max="18:00" step="1800" required="required">
														<p id="message"></p>
													</div>
													<button type="submit" name="submit" class="btn btn-o btn-primary">Continuar</button>
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
		<?php include('include/footer.php'); ?>
	</div>
	<script>
        const timeInput = document.getElementById('time');
        const message = document.getElementById('message');

        timeInput.addEventListener('input', () => {
            const timeValue = timeInput.value;
            const [hour, minute] = timeValue.split(':').map(Number);

            if ((minute % 30 !== 0) || (hour < 9 || (hour === 18 && minute > 0) || hour > 18)) {
                message.textContent = 'Porfavor seleccione una hora cada 30 minutos entre 09:00 and 18:00.';
                timeInput.setCustomValidity('Invalid time');
            } else {
                message.textContent = '';
                timeInput.setCustomValidity('');
            }
        });
    </script>
	<script src="vendor/jquery/jquery.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>

	<!-- <script src="vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
	<script src="vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script> -->
	<!-- <script src="assets/js/main.js"></script>
    <script src="assets/js/form-elements.js"></script> -->

</body>

</html>