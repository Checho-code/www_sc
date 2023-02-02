<?php 
require('conexion/conexion.php');
require('conexion/acceso.php');
include('escape.php');
$nivel=$_SESSION['nivel'];
if($nivel<3){
	echo "<script type='text/javascript'>
	alert('Usted no tiene permiso para visualizar este archivo');
	window.location='index.php';
	</script>";
}
//Codigo para realizar la busqueda
if(isset($_POST['idProducto']) && is_numeric($_POST['idProducto'])){
	$idProducto=test_entrada($_POST['idProducto']);
	$desde=test_entrada($_POST['desde']);
	$hasta=test_entrada($_POST['hasta']);
	$buscar_productos=mysqli_query($conexion, "SELECT * FROM carrito INNER JOIN clientes ON carrito.idCliente=clientes.idCliente INNER JOIN usuarios ON usuarios.id_usuario=carrito.id_usuario WHERE idProducto=$idProducto AND (fecha>='$desde' AND fecha<='$hasta')");
	$row_los_productos=mysqli_fetch_assoc($buscar_productos);
}
//Juego de registros de los productos
$b_productos=mysqli_query($conexion, "SELECT * FROM productos");
$row_productos=mysqli_fetch_assoc($b_productos);

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
</head>

<body>
	<datalist id="productos">
	<?php do{ ?>
		<option value="<?php echo $row_productos['idProducto']; ?>"><?php echo $row_productos['nombre_producto']; ?></option>
		<?php }while($row_productos=mysqli_fetch_assoc($b_productos)); ?>
	</datalist>
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
<h1>Informe por producto </h1>
	<form name="busquedaa" method="post">
	<div class="table-responsive">
		<table class=" table table-bordered table-striped table-hover table-sm">
  <tbody>
    <tr class="thead-dark">
      <th scope="col"><input type="text" name="idProducto" class="form-control" required autocomplete="off" placeholder="Elija el producto" list="productos"></th>
      <th scope="col"><input type="date" name="desde" class="form-control" required></th>
	  <th scope="col"><input type="date" name="hasta" class="form-control" required></th>
	  <th scope="col"><input type="submit" value="Buscar" class="btn btn-primary" /></th>
    </tr>
  </tbody>
</table>

		</div>
	</form>
</div>
</div>
	
	<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">
		<table class=" table table-bordered table-striped table-hover table-sm">
  <tbody>
    <tr class="thead-dark">
      <th scope="col">Id</th>
      <th scope="col">Cliente</th>
      <th scope="col">Usuario</th>
      <th scope="col">Fecha</th>
      <th scope="col">Cantidad</th>
      <th scope="col">Costo</th>
	  <th scope="col">Total</th>
    </tr>
	  <?php $cantidad=0; $subtotal=0; $total=0; do{ ?>
    <tr align="center" valign="middle">
      <td><?php echo $row_los_productos['id_registro']; ?></td>
      <td><?php echo $row_los_productos['nombre']; ?></td>
      <td><?php echo $row_los_productos['nombre_usuario']; ?></td>
      <td><?php echo $row_los_productos['fecha']; ?></td>
      <td><?php echo $row_los_productos['cantidad']; $cantidad+=$row_los_productos['cantidad']; ?></td>
      <td><?php echo number_format($row_los_productos['precio_costo']); ?></td>
		<td><?php $subtotal=$row_los_productos['cantidad']*$row_los_productos['precio_costo'];
			echo number_format($subtotal); $total+=$subtotal;
			?></td>
    </tr>
	  <?php }while($row_los_productos=mysqli_fetch_assoc($buscar_productos)); ?>
	  <h4>Catidad vendida: <?php echo number_format($cantidad)." Total: ".number_format($total); ?></h4>
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