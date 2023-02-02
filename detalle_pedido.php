<?php 
require('conexion/conexion.php');
require('conexion/acceso.php');
include('crear_cookie.php');
include('escape.php');
$pagina=$_SERVER['PHP_SELF'];
if($_COOKIE['Invitado'] == ''){
	header("Location: $pagina");
	}

//Juego de registros para el pedido
if(isset($_GET['invitado'])){
	$campo_invitado=test_entrada($_GET['invitado']);
	$sql_pedido="SELECT * FROM pedidos JOIN sectores ON pedidos.id_sector=sectores.id_sector JOIN ciudades ON sectores.id_ciudad=ciudades.id_ciudad WHERE invitado='$campo_invitado'";
	$b_pedido=mysqli_query($conexion, $sql_pedido);
	$row_pedido=mysqli_fetch_assoc($b_pedido);
	$idPedido=$row_pedido['idPedido'];
	
	//Juego de registros para buscar los detalles
	$sql_detalles="SELECT * FROM carrito WHERE invitado='$campo_invitado'";
	$b_detalles=mysqli_query($conexion, $sql_detalles);
	$row_detalles=mysqli_fetch_assoc($b_detalles);
	
	//Busco los registros de los abonos
	$b_abonos=mysqli_query($conexion, "SELECT * FROM abono_pedidos WHERE idPedido=$idPedido");
	$row_abonos=mysqli_fetch_assoc($b_abonos);
	
	
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
	<link rel="stylesheet" type="text/css" href="css/imprimir.css" media="print" />
	<script type="text/javascript">
	function validar(id_abono_pedido, invitado){
		var confirmar=confirm('Seguro que desea eliminar este abono?. Esta acción no se puede deshacer');
		if(confirmar){
			window.location="eliminar_abono.php?id_abono_pedido="+id_abono_pedido+"&inv="+invitado;
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
<div class="col-md-12">
<h2>Detalles pedido </h2>
	<div class="table-responsive">
	  <table border="1" class="table table-bordered table-striped table-hover table-sm">
  <tbody>
    <tr align="center" valign="middle" class="thead-dark">
      <th scope="col">CEDULA</th>
      <th scope="col">NOMBRE</th>
      <th scope="col">TELEFONO</th>
      <th scope="col">FECHA</th>
      <th scope="col">DIRECCION</th>
      </tr>
    <tr align="center" valign="middle" style="font-size: 20px; font-weight: bold">
      <td><?php $idCliente=$row_pedido['idCliente'];
		  $b_cliente=mysqli_query($conexion, "SELECT * FROM clientes WHERE idCliente=$idCliente");
		  $row_cliente=mysqli_fetch_assoc($b_cliente);
		  echo  $row_cliente['cedula'];
		  ?></td>
      <td><?php echo $row_cliente['nombre']; ?></td>
      <td><?php echo $row_cliente['telefono']; ?></td>
      <td><?php echo $row_pedido['fecha']; ?></td>
      <td><?php echo $row_pedido['nombre_ciudad'].", ". $row_pedido['nombre_sector'].", ". $row_cliente['observacion']; ?></td>
      </tr>
  </tbody>
</table><br>
		<table border="1" class="table table-bordered table-striped table-hover table-sm">
  <tbody>
    <tr align="center" valign="middle" class="thead-dark">
      <th scope="col">ID</th>
      <th scope="col">NOMBRE PRODUCTO</th>
      <th scope="col">CANTIDAD</th>
      <th scope="col" class="ocultar">VALOR UNITARIO</th>
	  <th scope="col" class="ocultar">PORCENTAJE</th>
      <th scope="col" class="ocultar">SUBTOTAL</th>
	  <th scope="col" class="ocultar">ELIMINAR</th>
      
    </tr>
	  <?php $subtotal=0; $total=0; do{ ?>
	  <tr align="center" valign="middle">
	   <td><?php echo $row_detalles['idProducto']; $idProducto=$row_detalles['idProducto'];
		   $b_prod=mysqli_query($conexion, "SELECT nombre_producto FROM productos WHERE idProducto=$idProducto");
            $row_prod=mysqli_fetch_assoc($b_prod);									  
		   ?></td>
	   <td><?php echo $row_prod['nombre_producto']; ?></td>
	   <td><?php echo $row_detalles['cantidad']; ?></td>
	   <td class="ocultar"><?php echo number_format($row_detalles['precio_costo']); $subtotal=$row_detalles['cantidad']*$row_detalles['precio_costo']; $total=$total+$subtotal; ?></td>
		  <td class="ocultar"><?php echo number_format($row_detalles['porcentaje']); ?></td>
	   <td class="ocultar"><?php echo number_format($subtotal,2) ?></td>
	   <td><a href="Eliminar_detalle_pedido.php?id_detalle=<?php echo $row_detalles['id_registro']; ?>&invitado=<?php echo $_GET['invitado']; ?>" class="btn btn-danger btn-sm">Quitar</a></td>
	   
	  </tr>
	  
	  <?php }while($row_detalles=mysqli_fetch_assoc($b_detalles)); ?>
	  <h3 class="ocultar">Total factura: <?php echo number_format($total,2) ?></h3>
  </tbody>
</table><br>
		<div align="center">
		<input type="button" class="btn btn-success ocultar" onClick="window.print()" value="&nbsp;&nbsp;&nbsp;Imprimir&nbsp;&nbsp;&nbsp;">
</div><br>

	</div>
</div>
</div>
	<div class="row">
	<div class="col-md-12">
		<h3>Abonos recibidos</h3>
		<div class="table-responsive">
		<table border="1" class="table table-bordered table-striped table-hover table-sm">
  <tbody>
    <tr class="thead-dark">
      <th scope="col">Id</th>
      <th scope="col">Fecha</th>
      <th scope="col">Hora</th>
      <th scope="col">Total</th>
      <th scope="col">Observacion</th>
      <th scope="col">Eliminar</th>
    </tr>
	  <?php do{ ?>
    <tr align="center" valign="middle">
      <td><?php echo @$row_abonos['id_abono_pedido']; ?></td>
      <td><?php echo @$row_abonos['fecha']; ?></td>
      <td><?php echo @$row_abonos['hora']; ?></td>
      <td><?php echo number_format(@$row_abonos['total']); ?></td>
      <td><?php echo @$row_abonos['observacion']; ?></td>
      <td><a href="#" class="btn btn-danger btn-sm" onClick="validar(<?php echo $row_abonos['id_abono_pedido']; ?>, '<?php echo $campo_invitado; ?>')">Quitar</a></td>
    </tr>
	  <?php }while($row_abonos=mysqli_fetch_assoc($b_abonos)); ?>
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
<?php mysqli_free_result($b_prod);
//mysqli_free_result($b_carrito2);
mysqli_free_result($b_cliente);
mysqli_free_result($b_detalles);
?>