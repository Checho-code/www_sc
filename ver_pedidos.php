<?php 
require('conexion/conexion.php');
require('conexion/acceso.php');
include('escape.php');
if($_SESSION['nivel']<3){
	header('Location: index.php');
}
/*Determino si hay parametro para ver los pedidos, si no hay parametros, determino el nivel del usuario para saber que  registros puede ver, si solo los propios o todos en caso de ser el administrador*/
$nivel=$_SESSION['nivel'];
$usuario=$_SESSION['id_usuario'];
if(isset($_GET['id_usuario']) && is_numeric($_GET['id_usuario'])){
	$id_usuario=test_entrada($_GET['id_usuario']);
	$b_pedidos=mysqli_query($conexion, "SELECT * FROM pedidos WHERE id_usuario=$id_usuario ORDER BY idPedido DESC");
	$row_pedidos=mysqli_fetch_assoc($b_pedidos);
}
else{
	if($nivel>=3){
		$b_pedidos=mysqli_query($conexion, "SELECT * FROM pedidos ORDER BY idPedido DESC");
	$row_pedidos=mysqli_fetch_assoc($b_pedidos);
	}
	else{
		$b_pedidos=mysqli_query($conexion, "SELECT * FROM pedidos WHERE id_usuario=$usuario");
	$row_pedidos=mysqli_fetch_assoc($b_pedidos);
	}
}

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
	<script type="text/javascript">
	function confirmar(idPedido, invitado){
		var confirmacion=confirm('Seguro que desea eliminar este pedido?');
		if(confirmacion){
			window.location="eliminar_pedido.php?idPedido="+idPedido+"&invitado="+invitado;
		}
	}
	</script>
</head>

<body>
<div class="container-fluid">
<div class="row fixed-top">
	<div class="col-md-11"><!--INICIO DEL MENU-->
    
	<?php //session_start(); 
		if($_SESSION['nivel']>2){
		include('menuPrincipal.php');	
		}
		else{
		include('menuBasico.php');
		}
		?>
     
    </div><div class="col-md-1" align="center"><a href="carrito.php"><img src="img/sistema/carrito.png" width="70" height="60" /></a>
	<div align="center"><span class="carro" id="carro"><?php echo $filas2; ?></div>	</div>
  </div>
	
	<div class="row">
	
<div class="col-sm-12">
<h2>Listado de pedidos recibidos </h2>
	<div class="table-responsive">
	<table class=" table table-bordered table-striped table-hover table-sm">
  <tbody>
    <tr class="thead-dark">
      <th scope="col">Id</th>
      <th scope="col">Vendedor</th>
      <th scope="col">Cliente</th>
      <th scope="col">Fecha</th>
      <th scope="col">Estado</th>
      <th scope="col">Observacion</th>
      <th scope="col">Total</th>
	  <th scope="col">Porcentaje</th>
      <th scope="col">Detalles</th>
      <th scope="col">Abonos</th>
	  <th scope="col">Saldo</th>
      <th scope="col">Abonar</th>
      <th scope="col">Eliminar</th>
    </tr>
	  <?php do{ ?>
    <tr>
      <td><?php echo $row_pedidos['idPedido']; $idPedido=$row_pedidos['idPedido']; $invit=$row_pedidos['invitado'];
		  $b_carro=mysqli_query($conexion, "SELECT idProducto, cantidad, precio_costo, porcentaje FROM carrito WHERE idPedido=$idPedido");
			  
		  ?></td>
      <td><?php $id_usuario=$row_pedidos['id_usuario'];
		  $b_usuario=mysqli_query($conexion, "SELECT nombre_usuario FROM usuarios WHERE id_usuario=$id_usuario");
			   $row_usu=mysqli_fetch_assoc($b_usuario);
			   echo $row_usu['nombre_usuario'];
			   mysqli_free_result($b_usuario);
		  ?></td>
      <td><?php $id_cliente=$row_pedidos['idCliente'];
		  $b_cliente=mysqli_query($conexion, "SELECT nombre FROM clientes WHERE idCliente=$id_cliente");
			   $row_cliente=mysqli_fetch_assoc($b_cliente);
			   echo $row_cliente['nombre'];
			   mysqli_free_result($b_cliente);
		  ?></td>
      <td><?php echo $row_pedidos['fecha']; ?></td>
      <td><?php $estado=$row_pedidos['estado']; if($estado==0){ echo "No despachado";}else{echo "Despachado";} ?></td>
      <td><?php echo $row_pedidos['observacion']; ?></td>
      <td><?php
		   $total=0; $subtotal=0; $porcentaje=0;
			   while($row_carro=mysqli_fetch_assoc($b_carro)){
				   $subtotal=($row_carro['cantidad']*$row_carro['precio_costo']);
				   $total+=$subtotal;
				   $porcentaje+=$row_carro['porcentaje'];
				  
			   }
			    echo number_format($total);
			   mysqli_free_result($b_carro);
		  ?></td>
		<td><?php echo number_format($porcentaje); ?></td>
      <td><a href="detalle_pedido.php?invitado=<?php echo $row_pedidos['invitado']; ?>" class="btn btn-success btn-sm">Detalles</a></td>
      <td><?PHP $b_abonos=mysqli_query($conexion, "SELECT SUM(total) AS suma FROM abono_pedidos WHERE idPedido=$idPedido");
			   $row_abonos=mysqli_fetch_assoc($b_abonos);
			   echo number_format($row_abonos['suma']);
		  
		  ?></td>
		<td><?php echo number_format($total-$row_abonos['suma']); ?></td>
      <td><a href="abono_pedido.php?idPedido=<?php echo $row_pedidos['idPedido']; ?>" class="btn btn-primary btn-sm">Abonar</a></td>
      <td><a href="#" onClick="confirmar(<?php echo $row_pedidos['idPedido']; ?>, '<?php echo $invit; ?>')" class="btn btn-sm btn-danger">QUITAR</a></td>
    </tr>
	  <?php }while($row_pedidos=mysqli_fetch_assoc($b_pedidos)); ?>
  </tbody>
</table>

	</div>
</div>
</div>
	

<div class="row">
<div class="col-md-12">
<?php include('footer.php'); ?>
</div>
</div>

  
 
</div>




<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/popper.js"></script>
</body>
</html>