<?php 
require('conexion/conexion.php');
require('conexion/acceso.php');
include('escape.php');

//Capturo el parametro y confirmo que sea numerico
if(isset($_GET['id_sector']) && is_numeric($_GET['id_sector'])){
	$id_sector=test_entrada($_GET['id_sector']);
	$sql="DELETE FROM sectores WHERE id_sector=?";
	$stmt=$conexion->prepare($sql);
	$stmt->bind_param('i', $id_sector);
	$stmt->execute();
	header('Location: crear_sector.php');
}
else{
	header('Location: crear_sector.php');
}

?>