<?php
include('include/config.php');
if(!empty($_POST["specilizationid"])) 
{

 $sql=mysqli_query($con,"select nombre,id_empleado from empleados");?>
 <option selected="selected">Seleccione Barbero </option>
 <?php
 while($row=mysqli_fetch_array($sql))
 	{?>
  <option value="<?php echo htmlentities($row['id']); ?>"><?php echo htmlentities($row['nombre']); ?></option>
  <?php
}
}


if(!empty($_POST["barber"])) 
{

 $sql=mysqli_query($con,"select precio from servicios where id='".$_POST['BarberoSpecialization']."'");
 while($row=mysqli_fetch_array($sql))
 	{?>
  <?php
}
}

?>

