<?php
include('include/config.php');

$query = "SELECT * FROM servicios";
$result = mysqli_query($con, $query);

$servicios = array();

while ($row = mysqli_fetch_assoc($result)) {
	$servicios[] = $row;
}

echo json_encode($servicios);
?>