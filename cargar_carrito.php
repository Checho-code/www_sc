<?php
include("conexion/conexion.php");
include("escape.php");
session_start();
$id_usuario=@$_SESSION['id_usuario'];
if(isset($_GET['idProducto']) && is_numeric($_GET['idProducto'])){
	$invitado=test_entrada($_COOKIE['Invitado']);
	
	$idProducto=test_entrada($_GET['idProducto']); $estado=1; $fecha=date('Y-m-d'); $cantidad=test_entrada($_GET['cantidad']);
	if(!is_numeric($cantidad)){
		$cantidad=null;
	}
	//Busco el juego de registros de este producto
	$sql_prod="SELECT * FROM productos WHERE idProducto=$idProducto";
	$b_prod=mysqli_query($conexion, $sql_prod);
	$row_producto=mysqli_fetch_assoc($b_prod);
	$idProducto2=$row_producto['idProducto'];
	$precio2=$row_producto['precio'];
	$porcentaje2=$row_producto['porcentaje'];
	$tot_porciento=(($cantidad*$precio2)*$porcentaje2)/100;
	
	
	//Antes de insertar en la tabla, busco si hay un registro de este producto en el carro y lo actualizo
	$buscar_producto=mysqli_query($conexion, "SELECT * FROM carrito WHERE idProducto=$idProducto AND invitado='$invitado'");
	$row_actualizar=@mysqli_fetch_assoc($buscar_producto);
	if(@$row_actualizar['idProducto']!=''){
		$sql_act="UPDATE carrito SET cantidad=?, porcentaje=? WHERE idProducto=? AND invitado=?";
		$stmt_act=$conexion->prepare($sql_act);
		$stmt_act->bind_param('ddis',$cantidad, $tot_porciento, $idProducto, $invitado);
		$stmt_act->execute();
		$stmt_act->close();
	}
	
	
	else{
	//registro en la tabla carrito
	$sql_carrito="INSERT INTO carrito (id_usuario, idProducto, fecha, invitado, cantidad, precio_costo, porcentaje, estado) VALUES (?,?,?,?,?,?,?,?)";
	$stmt_carrito=$conexion->prepare($sql_carrito);
	$stmt_carrito->bind_param('iissdddi', $id_usuario, $idProducto2, $fecha, $invitado, $cantidad, $precio2, $tot_porciento, $estado);
	$stmt_carrito->execute();
	$stmt_carrito->close();
}
	//Buscamos la cantidad de elementos que tiene el carrito
	$b_carrito=mysqli_query($conexion, "SELECT id_registro FROM carrito WHERE idCliente IS NULL AND  invitado='$invitado'");
	$row_carrito=@mysqli_fetch_assoc($b_carrito);
	$filas=@mysqli_num_rows($b_carrito);
	echo $filas;
}
else{
	echo "<script type='text/javascript'>
	alert('Enlace corrupto');
	window.location='index.php';
	</script>";
}
?>