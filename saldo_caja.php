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

$id_usu=$_SESSION['id_usuario'];

//Registro del cierre de caja
if(isset($_POST['clave_maestra'])){
	$clave=test_entrada($_POST['clave_maestra']);
	$clave_admin=$_SESSION['clave_maestra'];
	$buscar_usuario=mysqli_query($conexion, "SELECT * FROM usuarios WHERE id_usuario=$id_usu");
$row_usuario=mysqli_fetch_assoc($buscar_usuario);
	//Determino que la clave maestra sea correcta para registrar el cierre
	if($clave_admin == $clave){
		
		$b_caja=mysqli_query($conexion, "SELECT SUM(debito) AS ingresos, SUM(credito) AS egresos FROM caja WHERE id_usuario_receptor=$id_usu");
$row_caja=mysqli_fetch_assoc($b_caja);
		$saldo=$row_caja['ingresos']-$row_caja['egresos'];
		$fecha=date('Y-m-d'); $hora=date('H:i:s');
		$observacion_caja='Cierre de caja';
		if($saldo>0){
		mysqli_query($conexion, "INSERT INTO caja (id_usuario_receptor, id_usuario_emisor, fecha, hora, credito, observacion_caja) values ($id_usu, $id_usu, '$fecha', '$hora', $saldo, '$observacion_caja')");
		}
		else{
			echo "<script type='text/javascript'>
		alert('No tiene saldo pendiente, no se realizó el registro');
		</script>";
		}
	}
	else{
		echo "<script type='text/javascript'>
		alert('La clave es incorrecta, no se realizó el cierre de caja');
		</script>";
	}
}

//Busco los saldos de la caja
$b_caja=mysqli_query($conexion, "SELECT SUM(debito) AS ingresos, SUM(credito) AS egresos FROM caja WHERE id_usuario_receptor=$id_usu");
$row_caja=mysqli_fetch_assoc($b_caja);

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
<div align="center"><span class="carro" id="carro"></div>	</div>
  </div>
	
	<div class="row">
	
<div class="col-sm-12">
<h2>Saldo en caja:  <?php echo number_format($row_caja['ingresos']-$row_caja['egresos']); $saldo=$row_caja['ingresos']-$row_caja['egresos']; ?></h2>
<h3>Cierre de caja: </h3>
	<form name="cierre" method="post">
	<!--<div class="form-group">
	<label for="fecha">Fecha de cierre: *</label>
		<input type="date" class="form-control" required placeholder="Fecha de recaudo" value="<?php  echo date('Y-m-d'); ?>">
	</div>-->
		<div class="form-group">
		<!--<label for="saldo">Saldo en caja: *</label>-->
			<input type="hidden" class="form-control" required placeholder="ingrese el saldo a cerrar" value="<?php echo $saldo; ?>" name="saldo">
		</div>
		
		<div class="form-group">
		<label for="saldo">Clave maestra: *</label>
			<input type="password" class="form-control" required placeholder="ingrese la clave para cierre" name="clave_maestra" autocomplete="off">
		</div>
		
		<div class="form-group">
		<input type="submit" value="Cerrar caja" class="btn btn-dark">
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