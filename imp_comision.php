<?php 
require('conexion/conexion.php');
require('conexion/acceso.php');
include('escape.php');

//Capturo el parametro de la comision
if(isset($_GET['id_abono_comision']) && is_numeric($_GET['id_abono_comision'])){
	$id_abono_comision=test_entrada($_GET['id_abono_comision']);
	
	$b_comision=mysqli_query($conexion, "SELECT * FROM abono_comision LEFT JOIN usuarios ON abono_comision.id_usuario=usuarios.id_usuario WHERE id_abono_comision=$id_abono_comision");
	$row_comision=mysqli_fetch_assoc($b_comision);
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
     
    </div><div class="col-md-1" align="center"><a href="carrito"><img src="img/sistema/carrito.png" width="70" height="60" /></a>
<div align="center"><span class="carro" id="carro"><?php echo $filas2; ?></div>	</div>
  </div>
	
	<div class="row">
	
<div class="col-sm-12">
	<h1>Frutos del campo</h1>
<h3>Pago de comision <?php echo $row_comision['id_abono_comision']; ?></h3>
	<div class="table-responsive">
	<table class=" table table-bordered table-striped table-hover table-sm">
  <tbody>
    <tr align="center" valign="middle" class="thead-dark">
      <th scope="col">Id</th>
      <th scope="col">Usuario</th>
      <th scope="col">Fecha</th>
      <th scope="col">Hora</th>
      <th scope="col">Total</th>
      <th scope="col">Observacion</th>
    </tr>
    <tr>
      <td><?php echo $row_comision['id_abono_comision']; ?></td>
      <td><?php echo $row_comision['nombre_usuario']; ?></td>
      <td><?php echo $row_comision['fecha']; ?></td>
      <td><?php echo $row_comision['hora']; ?></td>
      <td><?php echo $row_comision['total']; ?></td>
      <td><?php echo $row_comision['observacion']; ?></td>
    </tr>
  </tbody>
</table>

	</div>
</div>
</div>
	
<div class="row">
		<div class="col-md-12" align="center"><input type="button" value="Imprimir" onClick="window.print()" class="imp">
	</div>
		
		</div>	<br>

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