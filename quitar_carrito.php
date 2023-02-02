<?php 
require('conexion/conexion.php');
include('crear_cookie.php');
include('escape.php');
if($_COOKIE['Invitado'] == ''){
	header('Location: index');
	}

if(isset($_GET['reg']) && is_numeric($_GET['reg'])){
	$id_registro=test_entrada($_GET['reg']);
	$sql="DELETE FROM carrito WHERE id_registro=?";
	$stmt_borrar=$conexion->prepare($sql);
	$stmt_borrar->bind_param('i',$id_registro);
	$stmt_borrar->execute();
	$stmt_borrar->close();
	header('Location: carrito');
}
?>