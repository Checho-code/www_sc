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
if(isset($_POST['id_abono_comision']) && is_numeric($_POST['id_abono_comision'])){
	$id_abono_comision=test_entrada($_POST['id_abono_comision']);
	$clave=test_entrada($_POST['clave']);
	$clave_maestra=$_SESSION['clave_maestra'];
	if($clave==$clave_maestra){
		//busco el registro del pago de la comision para saber el total y descontarlo en caja
	$b_comision=mysqli_query($conexion, "SELECT * FROM abono_comision WHERE id_abono_comision=$id_abono_comision");
	$row_abono=mysqli_fetch_assoc($b_comision);
	$total=$row_abono['total']; $id_usuario_emisor=$row_abono['id_usuario']; $id_usuario_receptor=$_SESSION['id_usuario'];
	$fecha=date('Y-m-d'); $hora=date('H:i:s');
	
	mysqli_query($conexion, "INSERT INTO caja (id_usuario_receptor, id_usuario_emisor, fecha, hora, debito, observacion_caja) VALUES ($id_usuario_receptor, $id_usuario_emisor, '$fecha', '$hora', $total, 'Devolucion registro de comision')");
	
	$id_usuario=test_entrada($_POST['id_usuario']);
	mysqli_query($conexion, "DELETE FROM abono_comision WHERE id_abono_comision=$id_abono_comision");
	header('Location: comisiones_pagadas.php?id_usuario='.$id_usuario);
	
	}
	else{
	echo "<script type='text/javascript'>
	alert('La clave maestra es incorrecta, no se ha eliminado el registro');
	</script>";
}
	//Registro la salida en caja
	
}
/**/
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
<h2>Super </h2>
	<form name="elim_comision" method="post">
	<input type="hidden" name="id_abono_comision" value="<?php echo $_GET['id_abono_comision']; ?>">
	<input type="hidden" name="id_usuario"  value="<?php echo $_GET['id_usuario']; ?>">
		<div class="form-group">
		<label for="clave-maestra">Clave maestra: *</label>
			<input type="password" name="clave" class="form-control" required autocomplete="off" placeholder="Ingrese la clave del super administrador" />
			
		</div>
		<div class="form-group">
			<input type="submit" value="Eliminar comision" class="btn btn-dark" />
			</div>
	</form>
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

