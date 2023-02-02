<?php 
require('conexion/conexion.php');
require('conexion/acceso.php');
include('escape.php');
//Registro del abono
if(isset($_POST['idPedido']) && is_numeric($_POST['idPedido'])){
	$id_usuario=$_SESSION['id_usuario'];
	$idPedido=test_entrada($_POST['idPedido']);
	$idCliente=test_entrada($_POST['idCliente']);
	$fecha=test_entrada($_POST['fecha']);
	$hora=test_entrada($_POST['hora']);
	$total=test_entrada($_POST['total']);
	$observacion=test_entrada($_POST['observacion']);
	$sql="INSERT INTO abono_pedidos (idPedido, idCliente, fecha, hora, total, observacion) VALUES(?,?,?,?,?,?)";
	$stmt=$conexion->prepare($sql);
	$stmt->bind_param('iissds', $idPedido, $idCliente, $fecha, $hora, $total, $observacion);
	if($stmt->execute()){
		echo "<script type='text/javascript'>
		alert('El abono se registró');
		</script>";
	}
	
	$stmt->close();
	//Busco el ultimo recaudo que acabo de hacer para encontrar el id_abono_pedido
	$b_abono=mysqli_query($conexion, "SELECT id_abono_pedido FROM abono_pedidos ORDER BY id_abono_pedido DESC LIMIT 1");
	$row_abon=mysqli_fetch_assoc($b_abono);
	$id_abono_pedido=$row_abon['id_abono_pedido'];
	//Registro el recaudo, codigo nuevo para probar
	$sql_rec="INSERT INTO recaudos (id_abono_pedido, id_usuario, idCliente, idPedido,fecha_recaudo, hora_recaudo, total_recaudo) VALUES (?,?,?,?,?,?,?)";
	$stmt_rec=$conexion->prepare($sql_rec);
	$stmt_rec->bind_param('iiiissd', $id_abono_pedido, $id_usuario, $idCliente, $idPedido, $fecha, $hora, $total);
	$stmt_rec->execute();
	$stmt_rec->close();
}
if(isset($_GET['idPedido']) && is_numeric($_GET['idPedido'])){
	$idPedido=test_entrada($_GET['idPedido']);
	$b_pedido=mysqli_query($conexion, "SELECT * FROM pedidos WHERE idPedido=$idPedido");
	$row_pedido=mysqli_fetch_assoc($b_pedido);
	//Busco los detalles del cliente
	$idCliente=$row_pedido['idCliente'];
	$b_cliente=mysqli_query($conexion, "SELECT * FROM clientes WHERE idCliente=$idCliente");
	$row_cliente=mysqli_fetch_assoc($b_cliente);
	//Busco los abonos si hay y determino el saldo
	$saldo=0; $subtotal=0; $total=0;$abonos=0;
	//Busco los abonos que se ha hecho
	$b_abonos=mysqli_query($conexion, "SELECT * FROM abono_pedidos WHERE idPedido=$idPedido");
	while($row_abonos=mysqli_fetch_assoc($b_abonos)){
		$abonos+=$row_abonos['total'];
	}
	$sql_detalles="SELECT * FROM carrito WHERE idPedido=$idPedido";
	$b_detalles=mysqli_query($conexion, $sql_detalles);
	//$row_detalles=mysqli_fetch_assoc($b_detalles);
	while($row_detalles=mysqli_fetch_assoc($b_detalles)){
	$subtotal=$row_detalles['cantidad']*$row_detalles['precio_costo'];
		$total+=$subtotal;
	}
	$saldo=$total-$abonos;
	
	//juego de registros para buscar los abonos realizados a este pedido
	$buscar_abonos=mysqli_query($conexion, "SELECT * FROM abono_pedidos WHERE idPedido=$idPedido");
	$fila_abonos=mysqli_fetch_assoc($buscar_abonos);
}
else{
	header('Location: ver_pedidos.php');
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
	<script type=text/javascript>
	function validar(){
		var saldo=document.abono.saldo.value;
		var total=document.abono.total.value;
		saldo=parseFloat(saldo);
		total=parseFloat(total);
		if(total>saldo){
			alert('El total no puede ser mayor que el saldo');
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
<h2>Abono a pedido <?php echo $row_pedido['idPedido']."&nbsp;&nbsp;"." de "." ".$row_cliente['nombre']."&nbsp;&nbsp;"." Total: ".number_format($total)."&nbsp;"."&nbsp;Saldo: ".number_format($saldo); ?> </h2>
	<form name="abono" method="post" onSubmit="return validar()">
	<div class="form-group">
	<label for="fecha">Fecha del abono *</label>
	<input type="date" name="fecha" class="form-control" required value="<?php echo date('Y-m-d') ?>" />
		</div>
		<div class="form-group">
		<label for="total">Total abono *</label>
			<input type="text" name="total" class="form-control" autocomplete="off" required placeholder="Total del abono" autofocus value="<?php echo $saldo; ?>" />
		</div>
		<div class="form-group">
		<label for="observacion">Observacion </label>
			<textarea name="observacion" class="form-control" rows="5" placeholder="Escriba si tiene alguna observacion respecto a este abono"></textarea>
		</div>
		<div class="form-group">
			<input type="hidden" name="idPedido" value="<?php echo $row_pedido['idPedido']; ?>" required >
			<input type="hidden" name="hora" value="<?php echo date('H:i:s'); ?>" />
			<input type="hidden" name="saldo" value="<?php echo $saldo; ?>" required />
		<input type="submit" class="btn btn-dark" value="Abonar">
		<input type="hidden" name="idCliente" id="idCliente" value="<?php echo $row_pedido['idCliente']; ?>">
		</div>
	</form>
</div>
</div>
	<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">
		
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