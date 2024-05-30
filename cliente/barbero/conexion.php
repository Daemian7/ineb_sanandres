<?php
$servidor="localhost";
$usuario="root";
$password="";
$bd="barberia_p";

$conexion=mysqli_connect($servidor,$usuario,$password,$bd);

if (!$conexion) {
  echo"error en la conexion";
}

?>