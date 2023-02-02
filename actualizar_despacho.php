<?php
include('conexion/conexion.php');
include('conexion/acceso.php');
include('escape.php');
$idPedido=test_entrada($_GET['idPedido']); 
$contador=test_entrada($_GET['contador']);
$invitad=test_entrada($_GET['invitado']);
$cedula=test_entrada($_GET['cedula']);

	//Actualizo el pedido y el carrito 
	mysqli_query($conexion, "UPDATE pedidos SET estado=1 WHERE idPedido=$idPedido");
	//echo "Despachado";

mysqli_query($conexion, "UPDATE carrito SET estado=1 WHERE idPedido=$idPedido");
echo "Despachado";

?>