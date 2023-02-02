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
$id_receptor=$_SESSION['id_usuario'];
//Codigo para registrar el abono
if(isset($_POST['id_usuario']) && is_numeric($_POST['id_usuario'])){
	$id_usuario=test_entrada($_POST['id_usuario']);
	$fecha=test_entrada($_POST['fecha']);
	$hora=date('H:i:s');
	$total=test_entrada($_POST['total']);
	$observacion=test_entrada($_POST['observacion']);
	$observacion_caja='Pago comision al usuario '.$id_usuario;
	$sql="INSERT INTO abono_comision (id_usuario, fecha, hora, total, observacion) VALUES (?,?,?,?,?)";
	$stmt=$conexion->prepare($sql);
	$stmt->bind_param('issds', $id_usuario, $fecha, $hora, $total, $observacion);
	$stmt->execute();
	$stmt->close();
	
	//Registro la salida en la caja
	//Codigo para registrar en la caja
	$sql_caja="INSERT INTO caja (id_usuario_receptor, id_usuario_emisor, fecha, hora, credito, observacion_caja) VALUES (?,?,?,?,?,?)";
	
	$stmt_caja=$conexion->prepare($sql_caja);
	$stmt_caja->bind_param('iissds', $id_receptor, $id_usuario, $fecha, $hora, $total, $observacion_caja);
	$stmt_caja->execute();
	$stmt_caja->close();
	
	//Busco el ultimo registro en abono_comision
	$b_comision=mysqli_query($conexion, "SELECT id_abono_comision FROM abono_comision ORDER BY id_abono_comision DESC LIMIT 1");
	$row_comision=mysqli_fetch_assoc($b_comision);
	$id_abono_comision=$row_comision['id_abono_comision'];
	header('Location: imp_comision.php?id_abono_comision='.$id_abono_comision);
}

if(isset($_GET['id_usuario']) && is_numeric($_GET['id_usuario'])){
	$id_usuario=test_entrada($_GET['id_usuario']);
	$los_usuarios=mysqli_query($conexion, "SELECT * FROM usuarios WHERE id_usuario=$id_usuario");
$row_usuarios=mysqli_fetch_assoc($los_usuarios);
	
	$porcentaje=0;
			   $b_carro=mysqli_query($conexion, "SELECT * FROM carrito WHERE id_usuario=$id_usuario");
			while($row_carro=mysqli_fetch_assoc($b_carro)){
				$porcentaje+=$row_carro['porcentaje'];
			}
	$abonos=0;
	$b_abonos=mysqli_query($conexion, "SELECT SUM(total) AS abonos FROM abono_comision WHERE id_usuario=$id_usuario");
	$row_abonos=mysqli_fetch_assoc($b_abonos);
	$saldo=$porcentaje-$row_abonos['abonos'];
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
	function validar(saldo){
		var total=document.pagar.total.value;
		total=parseFloat(total);
		saldo=parseFloat(saldo);
		if(total>saldo){
			alert('No se puede abonar mas que el saldo pendiente');
			document.pagar.total.focus();
			return false;
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
<h2>Pagar comision a <?php echo $row_usuarios['nombre_usuario']."&nbsp; Saldo:  ".number_format($porcentaje-$row_abonos['abonos']); ?></h2>
	<form name="pagar" method="post" onSubmit="return validar(<?php echo $saldo; ?>)">
	<div class="form-group">
		<label for="fecha">Fecha del pago *</label>
		<input name="fecha" type="date" required class="form-control" id="fecha" value="<?php echo date('Y-m-d'); ?>" />
		</div>
		
		<div class="form-group">
		<label for="total">Total del pago *</label>
		<input type="text" autofocus="autofocus" required class="form-control" placeholder="Ingrese el total del abono" autocomplete="off" name="total" />
		</div>
		<div class="form-group">
		<label for="fecha">Observacion </label>
		<textarea name="observacion" class="form-control" placeholder="Si tiene alguna observacion ingresela aquí"></textarea>
		</div>
		<div class="form-group">
		<input type="submit" value="Abonar" class="btn btn-dark">
		<input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_GET['id_usuario']; ?>">
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