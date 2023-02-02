<?php 
require('conexion/conexion.php');
require('conexion/acceso.php');
include('crear_cookie.php');

$estado=0; $ver=''; $mensaje='Listado de pedidos nuevos';
$b_pedidos=mysqli_query($conexion, "SELECT idPedido, id_usuario, idCliente, invitado, fecha, estado, id_sector, observacion FROM pedidos WHERE estado=0 ORDER BY idPedido");
$row_pedidos=mysqli_fetch_assoc($b_pedidos);

?>

<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="robots" content="noindex">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<title>Frutos del campo</title>

<link rel="stylesheet" type="text/css" href="css/mi_estilo.css" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="css/mi_css/ocultar_en_pantalla.css" />
	<link rel="stylesheet" type="text/css" href="css/mi_estilo.css" />
	<style>
		.facturacion{ display: flex;
flex-wrap: wrap; justify-content: space-around; float: left; margin: 10px;}
	</style>
</head>
<body onLoad="window.print()">
	<div class="container-fluid">
		<?php do{ ?>
		<div class="facturacion">
		<table border="1">
  <tbody>
    <tr>
      <td scope="col" colspan="2"><b>Fecha:</b> <?php echo $row_pedidos['fecha']; ?></td>
      
      <td scope="col" colspan="2"><b>Pedido N°:</b> <?php echo $row_pedidos['idPedido']; $idPedido=$row_pedidos['idPedido']; $id_sector=$row_pedidos['id_sector']; ?></td>
      
		<?php $idCliente=$row_pedidos['idCliente'];
		$b_cliente=mysqli_query($conexion, "SELECT * FROM clientes WHERE idCliente=$idCliente");
				 $row_cliente=mysqli_fetch_assoc($b_cliente);
		?>
      
    </tr>
    <tr>
      <td width="16" colspan="4"><b>Cliente:</b> <?php echo $row_cliente['nombre']; ?></td>
     
      
    </tr>
    <tr>
      <td colspan="4"><b>Direccion:</b> <?php
	 //Busco el sector correspondiente a este pedido
	 $b_sectores=mysqli_query($conexion, "SELECT * FROM sectores JOIN ciudades ON sectores.id_ciudad=ciudades.id_ciudad WHERE id_sector=$id_sector");
$row_sectores=mysqli_fetch_assoc($b_sectores); 
	  echo $row_sectores['nombre_ciudad']."&nbsp;&nbsp;".$row_sectores['nombre_sector']."&nbsp;&nbsp;".$row_pedidos['observacion'];
		  //Busco los detalles de este pedido
				 $b_detalles=mysqli_query($conexion, "SELECT * FROM carrito  WHERE idPedido=$idPedido");
				 $row_detalles=mysqli_fetch_assoc($b_detalles);
		  ?></td>
      </tr>
    <tr align="center" valign="middle">
      <th>Producto</th>
      <th>Cant.</th>
      <th>Vr/unit</th>
      <th>Subtotal</th>
      
    </tr>
	  <?php $subtot=0; $tot=0; do{ ?>
	  <tr>
      <td><?php $idProducto=$row_detalles['idProducto'];
		  $b_producto=mysqli_query($conexion, "SELECT nombre_producto FROM productos WHERE idProducto=$idProducto");
								  $row_prod=mysqli_fetch_assoc($b_producto);
								  echo $row_prod['nombre_producto'];
								  mysqli_free_result($b_producto);
		  ?></td>
      <td><?php echo $row_detalles['cantidad']; $subtot=$row_detalles['cantidad']*$row_detalles['precio_costo']; ?></td>
      <td><?php echo number_format($row_detalles['precio_costo']); $tot+=$subtot;  ?></td>
      <td><?php echo number_format($subtot); ?></td>
      
    </tr>
	  <?php }while($row_detalles=mysqli_fetch_assoc($b_detalles));
	  mysqli_free_result($b_detalles);
	  ?>
	  <tr>
      <td colspan="4" align="right"><b>Total:</b>&nbsp;<?php echo number_format($tot); ?> </td>
      </tr>
    <tr>
  </tbody>
</table>

		</div>
		<?php }while($row_pedidos=mysqli_fetch_assoc($b_pedidos)); ?>
	</div>
	</div>
</body>
</html>
<?php
@mysqli_free_result($b_pedidos);
@mysqli_free_result($b_cliente);
@mysqli_free_result($b_detalles);
@mysqli_free_result($b_sectores);
@mysqli_free_result($b_producto);
?>