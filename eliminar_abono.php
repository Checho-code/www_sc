<?php 
require('conexion/conexion.php');
require('conexion/acceso.php');
include('crear_cookie.php');
include('escape.php');
//Capturo el parametro para eliminar el abono
if(isset($_GET['id_abono_pedido']) && is_numeric($_GET['id_abono_pedido'])){
	$id_abono_pedido=test_entrada($_GET['id_abono_pedido']);
	$inv=test_entrada($_GET['inv']);
	//Busco el id del pedido para redireccionar
	/*$b_pedido=mysqli_query($conexion, "SELECT idPedido FROM abono_pedidos WHERE id_abono_pedido=$id_abono_pedido");
	$row_pedido=mysqli_fetch_assoc($b_pedido);
	$idPedido=$row_pedido['idPedido'];*/
	$sql="DELETE FROM abono_pedidos WHERE id_abono_pedido=?";
	$stmt=$conexion->prepare($sql);
	$stmt->bind_param('i', $id_abono_pedido);
	$stmt->execute();
	$stmt->close();
	
	
	header('Location: detalle_pedido.php?invitado='.$inv);
	
}
else{
	
}
?>