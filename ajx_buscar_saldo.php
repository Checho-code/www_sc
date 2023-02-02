<?php 
require('conexion/conexion.php');
include('conexion/acceso.php');
include('crear_cookie.php');
include('escape.php');

if(isset($_GET['cedula_cliente'])){
	$cedula_cliente=test_entrada($_GET['cedula_cliente']);
	$b_cliente=mysqli_query($conexion, "SELECT idCliente, nombre FROM clientes WHERE cedula='$cedula_cliente'");
	$row_cliente=mysqli_fetch_assoc($b_cliente);
	$idCliente=@$row_cliente['idCliente']; $nombre=@$row_cliente['nombre'];
	$total_compras=0; $saldo=0; $respuesta='';
	//Busco los registros de compras en el  carrito
	$b_carro=mysqli_query($conexion, "SELECT cantidad, precio_costo FROM carrito WHERE idCliente=$idCliente");
	//$row_carro=mysqli_fetch_assoc($b_carro);
	while($row_carro=@mysqli_fetch_assoc($b_carro)){
		$total_compras+=(@$row_carro['cantidad']*@$row_carro['precio_costo']);
	}
	//Busco los registros de los abonos
	$b_abonos=mysqli_query($conexion, "SELECT SUM(total) AS abonos FROM abono_pedidos WHERE idCliente=$idCliente");
	$row_abonos=@mysqli_fetch_assoc($b_abonos);
	$saldo=$total_compras-@$row_abonos['abonos'];
	
	if($saldo>0){
		$respuesta="El cliente $nombre tiene un saldo pendiente de ".number_format($saldo);
	}
	echo $respuesta;
}

?>