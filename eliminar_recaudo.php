<?php 
require('conexion/conexion.php');
require('conexion/acceso.php');
include('escape.php');
session_start();
$clave_maestra=$_SESSION['clave_maestra'];
//Capturo los parametros
if(isset($_POST['id_usuario']) && is_numeric($_POST['id_usuario'])){
	$id_usuario=test_entrada($_POST['id_usuario']);
	$id_recaudo=test_entrada($_POST['id_recaudo']);
	$id_abono_pedido=test_entrada($_POST['id_abono_pedido']);
	
	//Busco el recaudo
	$b_recaudo=mysqli_query($conexion, "SELECT * FROM recaudos WHERE id_recaudo=$id_recaudo");
	$row_recaudo=mysqli_fetch_assoc($b_recaudo);
	$id_usuario_receptor=$_SESSION['id_usuario'];
	$id_usuario_emisor=$row_recaudo['id_usuario'];
	$fecha=date('Y-m-d');
	$hora=date('H:i:s');
	$credito=$row_recaudo['abono_recaudo'];
	$debito=$row_recaudo['total_recaudo'];
	if($debito==''){$debito=0;}
	if($credito==''){$credito=0;}
	$observacion_caja='Eliminacion de recaudo';
	
	$clave=test_entrada($_POST['clave']);
	if($clave==$clave_maestra){
		//Sacar de la caja
		mysqli_query($conexion, "INSERT INTO caja (id_usuario_receptor, id_usuario_emisor, fecha, hora, debito, credito, observacion_caja) VALUES ($id_usuario_receptor, $id_usuario_emisor, '$fecha', '$hora', $debito, $credito, '$observacion_caja')");
		
		$sql="DELETE FROM recaudos WHERE id_recaudo=?";
	$stmt=$conexion->prepare($sql);
	$stmt->bind_param('i',$id_recaudo);
	$stmt->execute();
	$stmt->close();
	$sql="DELETE FROM abono_pedidos WHERE id_abono_pedido=?";
	$stmt=$conexion->prepare($sql);
	$stmt->bind_param('i', $id_abono_pedido);
	$stmt->execute();
	$stmt->close();
		
		
		
	header('Location: ver_recaudos.php?id_usuario='.$id_usuario);
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
<h2>Eliminar el recaudo </h2>
	<form name="eliminar" method="post">
	<div class="form-group">
		<input type="hidden" name="id_usuario" value="<?php echo $_GET['id_usuario']; ?>" required>
		<input type="hidden" name="id_recaudo" value="<?php echo $_GET['id_recaudo']; ?>">
		<input type="hidden" name="id_abono_pedido" value="<?php echo $_GET['id_abono_pedido'] ?>" required>
		<input type="text" name="clave" class="form-control" required placeholder="Ingrese la clave maestra">
		</div>
		<div class="form-group">
		<input type="submit" value="Eliminar recaudo" class="btn btn-dark" />
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
