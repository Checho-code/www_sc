<?php 
require('conexion/conexion.php');
require('conexion/acceso.php');
include('escape.php');
if(isset($_GET['id_usuario']) && is_numeric($_GET['id_usuario'])){
	$id_usuario=test_entrada($_GET['id_usuario']);
	$sql="DELETE FROM usuarios WHERE id_usuario=?";
	$stmt=$conexion->prepare($sql);
	$stmt->bind_param('i',$id_usuario);
	$stmt->execute();
	$stmt->close();
	
	header('Location: f_nuevo_usuario.php');
}
else{
	header('Location: f_nuevo_usuario.php');
}

?>