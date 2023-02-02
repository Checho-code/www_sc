<?php 
require('conexion/conexion.php');
require('conexion/acceso.php');
include('crear_cookie.php');
$nivel=$_SESSION['nivel'];
if($nivel<3){
	echo "<script type='text/javascript'>
	alert('Usted no tiene permiso para visualizar este archivo');
	window.location='index.php';
	</script>";
}

$redireccion=$_SERVER['PHP_SELF'];
if($_COOKIE['Invitado'] == ''){
	header('Location: '.$redireccion);
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
	<link rel="stylesheet" type="text/css" href="css/mi_css/ocultar_en_pantalla.css" />
	<link rel="stylesheet" type="text/css" href="css/mi_estilo.css" />
	<script type="text/javascript">
	function actualizar(idPedido, contador, invitado, cedula){
		var xmlhttp;
		
		if(idPedido==""){
			document.getElementById("txtHint").innerHTML="";
			return;
		}
		if(window.XMLHttpRequest){
			xmlhttp=new XMLHttpRequest();
		}
		else{
			xmlhttp=new ActiveXObjet("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function(){
			if(xmlhttp.readyState==4 && xmlhttp.status==200){
				//subtotal=cantidad*costo;
				//subtotal=new Intl.NumberFormat().format(subtotal);
				//document.getElementById("total").innerHTML=xmlhttp.responseText;
				document.getElementById("despacho"+contador).innerHTML="Despachado";
				
			}
		 }
		
		
		xmlhttp.open("GET", "actualizar_despacho.php?idPedido="+idPedido+"&contador="+contador+"&invitado="+invitado+"&cedula="+cedula, true);
		xmlhttp.send();
		
		
	}
	</script>
	<script type="text/javascript">
	function confirmar(idPedido, invitado){
		var confirmacion=confirm('Seguro que desea eliminar este pedido?');
		if(confirmacion){
			window.location="eliminar_pedido.php?idPedido="+idPedido+"&invitado="+invitado;
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
		<?php
		$estado=0; $ver=''; $mensaje='Listado de pedidos nuevos';
$b_pedidos=mysqli_query($conexion, "SELECT idPedido, id_usuario, idCliente, invitado, fecha, estado, observacion FROM pedidos WHERE estado=0 ORDER BY idPedido DESC");
$row_pedidos=mysqli_fetch_assoc($b_pedidos);
		if(@$row_pedidos['idPedido'] == ''){
			$ver='nover'; $mensaje='No hay pedidos nuevos';
		}
		?>
     
    </div>
	<div class="col-md-1" align="center"><a href="carrito.php"><img src="img/sistema/carrito.png" width="70" height="60" /></a>
	<div align="center"><span class="carro" id="carro"><?php echo $filas2; ?></div>	</div>
  </div>
	
	
	<div class="row">
<div class="col-md-12">
	<div id="txtHint"></div>
<h1><?php echo $mensaje; ?></h1>
	<div class="table-responsive <?php echo $ver; ?>">
		<form name="pedidos" method="get">
	<table border="1" class="table table-bordered table-sm">
  <tbody>
    <tr class="thead-dark">
      <th scope="col">CEDULA</th>
      <th scope="col">NOMBRE</th>
      <th scope="col">TELEFONO</th>
      <th scope="col">FECHA</th>
      <th scope="col">OBSERVACION</th>
      <th scope="col">DETALLES</th>
      <th scope="col">DESPACHADO</th>
      <th scope="col">ELIMINAR</th>
	  </tr>
	  <?PHP $contador=1;   do{ ?>
	  <tr align="center" valign="middle" <?php $cajon=''; $leido = ''; if($row_pedidos['estado'] == 1){
	$cajon='nover'; 
} if($row_pedidos['estado'] == 0){$leido='noleido';} ?> class="<?php echo $leido; ?>">
	  <td><?php /*echo $row_pedidos['idCliente'];*/ $idCliente=$row_pedidos['idCliente']; 
		  $buscar_cliente=mysqli_query($conexion, "SELECT * FROM clientes WHERE idCliente=$idCliente");
			  $row_cliente=mysqli_fetch_assoc($buscar_cliente); $cedula=$row_cliente['cedula'];
			  $nombre=$row_cliente['nombre']; 
							  echo $cedula;
		  ?></td>
		  <td><?php $buscar_cliente=mysqli_query($conexion, "SELECT * FROM clientes WHERE idCliente=$idCliente");
			  $row_cliente=mysqli_fetch_assoc($buscar_cliente); $cedula=$row_cliente['cedula'];
			  $nombre=$row_cliente['nombre'];
							  echo $nombre;
							  //mysqli_free_result($buscar_cliente);
							  
			  ?></td>
		  <td><?php echo $row_cliente['telefono'];  ?></td>
		  <td><?php echo $row_pedidos['fecha']; ?></td>
		  <td><?php echo $row_pedidos['observacion']; $inv=$row_pedidos['invitado']; $invit=$row_pedidos['invitado'] ?></td>
		  <td><a href="detalle_pedido.php?invitado=<?php echo $row_pedidos['invitado']; ?>" class="btn btn-sm btn-success">Ver detalles</a></td>
		  <td id="despacho<?php echo $contador; ?>"><input type="checkbox" class="form-control <?php echo $cajon; ?> <?php echo $leido; ?>" name="despacho<?php echo $contador; ?>" onClick="actualizar(<?php echo $row_pedidos['idPedido']; ?>, <?php echo $contador; ?>, '<?php echo $inv; ?>', '<?php echo $cedula; ?>')"></td>
		  <td id="despacho<?php echo $contador; ?>"><a href="#" onClick="confirmar(<?php echo $row_pedidos['idPedido']; ?>, '<?php echo $invit; ?>')" class="btn btn-sm btn-danger">QUITAR</a></td>
		  </tr>
	  <?php $contador++; }while($row_pedidos=mysqli_fetch_assoc($b_pedidos));
	   ?>
  </tbody>
</table>
			</form>

	</div>
</div>
</div>
	<div class="row">
	<div class="col-md-12" align="center"><a href="imp_pedidos.php" class="btn btn-dark" target="_blank">Imprimir</a></div>
	</div><br>
	

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
<?php mysqli_free_result($b_pedidos) ?>