<?php 
require('conexion/conexion.php');
require('conexion/acceso.php');
include('escape.php');

/*Capturo el parametro para mostrar solo los clientes de este vendedor, si no hay parametro me guio por el nivel de la sesion */
$nivel=$_SESSION['nivel'];
if($nivel>=3){
	$b_clientes=mysqli_query($conexion, "SELECT * FROM clientes ORDER BY nombre");
	$row_clientes=mysqli_fetch_assoc($b_clientes);
}
else{
	echo "<script type='text/javascript'>
	alert('No tiene permiso para visualizar este archivo');
	window.location='index.php';
	</script>";
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
	<link rel="stylesheet" type="text/css" href="mis_css/mis_estilos.css" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
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
<h2>Lista de clientes</h2>
<div class="table-responsive">
	<table class=" table table-bordered table-striped table-hover table-sm">
  <tbody>
    <tr class="thead-dark">
      <th scope="col">Id</th>
      <th scope="col">Correo</th>
      <th scope="col">Cedula</th>
      <th scope="col">Nombre</th>
      <th scope="col">Telefono</th>
      <th scope="col">Observacion</th>
      <th scope="col">Compras</th>
      <th scope="col">Saldo</th>
      
	  <?php do{ ?>
    <tr align="center" valign="middle">
      <td><?php echo $row_clientes['idCliente']; $idCliente=$row_clientes['idCliente']; ?></td>
      <td><?php echo $row_clientes['correo']; ?></td>
      <td><?php echo $row_clientes['cedula']; ?></td>
      <td><?php echo $row_clientes['nombre']; ?></td>
      <td><?php echo $row_clientes['telefono']; ?></td>
      <td><?php echo $row_clientes['observacion']; ?></td>
      <td><?php $total=0; $b_compras=mysqli_query($conexion, "SELECT cantidad, precio_costo FROM carrito WHERE idCliente=$idCliente");
		  while($row_compras=mysqli_fetch_assoc($b_compras)){
			  $total+=($row_compras['cantidad']*$row_compras['precio_costo']);
		  }
			   echo number_format($total);
			   mysqli_free_result($b_compras);
			   $total_abonos=0;
		  $b_abonos=mysqli_query($conexion, "SELECT SUM(total) AS total FROM abono_pedidos WHERE idCliente=$idCliente");
			   $row_abonos=mysqli_fetch_assoc($b_abonos);
		  $saldo=$total-$row_abonos['total'];
			   $color='';
			   if($saldo>0){ $color='rojo';}
		  ?></td>
      <td class="<?php echo $color; ?>"><?php 
			   echo number_format($saldo);
			   //mysqli_free_result($b_abonos);
		  ?></td>
      
    </tr>
	  <?php }while($row_clientes=mysqli_fetch_assoc($b_clientes)); ?>
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