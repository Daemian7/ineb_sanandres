<?php
$servidor="localhost";
$usuario="root";
$password="";
$bd="san-andres";

$conexion=mysqli_connect($servidor,$usuario,$password,$bd);

if (!$conexion) {
  echo"error en la conexion";
}

?>