<?php
$servidor="localhost";
$usuario="root";
$password="";
$bd="barberia_p";

$conexion=mysqli_connect($servidor,$usuario,$password,$bd);

if (!$conexion) {
  echo"error en la conexion";
}

$consulta="Select * from servicios";
$exec=mysqli_query($conexion,$consulta);

while ($fila = mysqli_fetch_array($exec)) {
    echo "<option value='".$fila['id_servicios']."'>".$fila['servicio']."</option>";
}
?>