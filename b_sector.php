<?php 
require('conexion/conexion.php');
require('conexion/acceso.php');
include_once('escape.php');
$respuesta='';
if(isset($_GET['sector'])){
	$sector=test_entrada($_GET['sector']);
	
	$sql="SELECT nombre_sector FROM sectores WHERE nombre_sector='$sector'";
	$b_sector=mysqli_query($conexion, $sql);
	$row_sector=mysqli_fetch_assoc($b_sector);
	if(@$row_sector['nombre_sector']!=''){
		$respuesta= "El sector ".$row_sector['nombre_sector']." Ya ha sido registrado";
	}
	echo $respuesta;
}
?>