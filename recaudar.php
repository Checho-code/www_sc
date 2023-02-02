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

//Registrar el recaudo
if(isset($_POST['id_usuario']) && is_numeric($_POST['id_usuario'])){
	$id_usuario=test_entrada($_POST['id_usuario']);
	$fecha_recaudo=test_entrada($_POST['fecha_recaudo']);
	$hora_recaudo=date('H:i:s');
	$abono_recaudo=test_entrada($_POST['abono_recaudo']);
	$observacion=test_entrada($_POST['observacion']);
	$id_receptor=$_SESSION['id_usuario'];
	$observacion_caja='Recepcion recaudo del usuario'.' '.$id_usuario;
	$sql="INSERT INTO recaudos (id_usuario, fecha_recaudo, hora_recaudo, abono_recaudo, observacion) VALUES (?,?,?,?,?)";
	$stmt=$conexion->prepare($sql);
	$stmt->bind_param('issds', $id_usuario, $fecha_recaudo, $hora_recaudo, $abono_recaudo, $observacion);
	$stmt->execute();
	$stmt->close();
	
	//Codigo para registrar en la caja
	$sql_caja="INSERT INTO caja (id_usuario_receptor, id_usuario_emisor, fecha, hora, debito, observacion_caja) VALUES (?,?,?,?,?,?)";
	
	$stmt_caja=$conexion->prepare($sql_caja);
	$stmt_caja->bind_param('iissds', $id_receptor, $id_usuario, $fecha_recaudo, $hora_recaudo, $abono_recaudo, $observacion_caja);
	$stmt_caja->execute();
	$stmt_caja->close();
	
}

//Juego de registros para el usuario
if(isset($_GET['id_usuario']) && is_numeric($_GET['id_usuario'])){
	$id_usuario=test_entrada($_GET['id_usuario']);
	$b_usuario=mysqli_query($conexion, "SELECT * FROM usuarios WHERE id_usuario=$id_usuario");
	$row_usuario=mysqli_fetch_assoc($b_usuario);
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
<h2>Recibir direno de <?php echo $row_usuario['nombre_usuario']; ?> </h2>
	<form name="recaudo" method="post">
	<div class="form-grop">
		<label for="fecha_recaudo">Fecha de recaudo *</label>
		<input type="date" value="<?php echo date('Y-m-d'); ?>" class="form-control" required name="fecha_recaudo" >
		</div>
		<div class="form-group">
		<label for="abono_recaudo">Total del recaudo *</label>
			<input type="number" class="form-control" required placeholder="Ingrese el total" name="abono_recaudo" >
		</div>
		<div class="form-group">
		<label for="observacion">Observacion</label>
			<textarea name="observacion" class="form-control" placeholder="Si tiene una observacion escribala aquí"></textarea>
		</div>
		<div class="form-group">
		<input type="submit" value="Recibir recaudo" class="btn btn-dark" />
		<input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $row_usuario['id_usuario']; ?>">
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