<?php 
require('conexion/conexion.php');
include('crear_cookie.php');
include('conexion/acceso.php');
include('escape.php');
$invitado=$_COOKIE['Invitado'];

if(isset($_GET['id_registro']) && is_numeric($_GET['id_registro'])){
	$id_registro=test_entrada($_GET['id_registro']);
	$cantidad=test_entrada($_GET['cantidad']);
	
	
	if(is_numeric($id_registro) && is_numeric($cantidad)){
		$sql="UPDATE carrito SET cantidad=? WHERE id_registro=?";
		$stmt=$conexion->prepare($sql);
		$stmt->bind_param('di', $cantidad,$id_registro);
		$stmt->execute();
		$stmt->close();
		$total=0;
		
		//Busco el registro de lo  que hay y le coloco en el total de la tabla
$sql_carrito="SELECT cantidad, precio_costo FROM carrito WHERE invitado=?";
		$stmt_carrito=$conexion->prepare($sql_carrito);
		$stmt_carrito->bind_param('s', $invitado);
		$stmt_carrito->execute();
		$stmt_carrito->bind_result($cantidad2, $precio_costo2);
		while($stmt_carrito->fetch()){
			$total=$total+($cantidad2*$precio_costo2);
		}
	}
}
echo "<h3>"."Total de la compra: ".number_format($total,2)."</h3>";

?>