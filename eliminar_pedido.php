<?php 
require('conexion/conexion.php');
include('crear_cookie.php');
include('conexion/acceso.php');
include('escape.php');
/*if($_COOKIE['Invitado'] == ''){
	header('Location: http://localhost/tesoro');
	}*/
if(isset($_GET['idPedido']) && is_numeric($_GET['idPedido'])){
	
	$idPedido=test_entrada($_GET['idPedido']);
	$inv=test_entrada($_GET['invitado']);
	
	$sql_pedido="DELETE FROM pedidos WHERE idPedido=?";
	$stmt_pedido=$conexion->prepare($sql_pedido);
	$stmt_pedido->bind_param('i',$idPedido);
	$stmt_pedido->execute();
	$stmt_pedido->close();
	
	//Borrar detalles del pedido
	$sql_detalles="DELETE FROM carrito WHERE invitado=?";
	$stmt_det=$conexion->prepare($sql_detalles);
	$stmt_det->bind_param('s', $inv);
	$stmt_det->execute();
	$stmt_det->close();
	header('Location: pedidos_nuevos');
	
	//Borrar los a bonos al pedido
	mysqli_query($conexion, "DELETE FROM abono_pedidos WHERE idPedido=$idPedido");
	
}
?>