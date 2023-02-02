<?php 
require('conexion/conexion.php');
require('conexion/acceso.php');
include('escape.php');
if($_SESSION['nivel']<3){
	header('Location: index.php');
}
$id_usuario_conectado=$_SESSION['id_usuario'];
$nivel=$_SESSION['nivel'];
if($nivel>=3){
	/*echo "<script type='text/javascript'>
	alert('Usted no tiene permiso para visualizar este archivo');
	window.location='index.php';
	</script>";*/
	//Juego de registros para buscar los vendedores
$b_vendedores=mysqli_query($conexion, "SELECT * FROM usuarios");
$row_usuarioss=mysqli_fetch_assoc($b_vendedores);
	
}
else{
	$b_vendedores=mysqli_query($conexion, "SELECT * FROM usuarios WHERE id_usuario=$id_usuario_conectado");
$row_usuarioss=mysqli_fetch_assoc($b_vendedores);
}
$ver='nover';
//Codigo para hacer la busqueda
if(isset($_POST['id_usuario0']) &$_POST['id_usuario0']==$id_usuario_conectado){
	$id_usuario=test_entrada($_POST['id_usuario0']);
	/*echo "<script type='text/javascript'>
	alert($id_usuario);
	</script>";*/
	$los_usuarios0=mysqli_query($conexion, "SELECT * FROM usuarios WHERE id_usuario=$id_usuario");
$row_usuarios0=mysqli_fetch_assoc($los_usuarios0);
	$ver='';
	
	
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
	<link rel="stylesheet" type="text/css" href="mis_css/mis_estilos.css" >
	
</head>

<body>
	<datalist id="vendedores">
	<?php do{ ?>
		<option value="<?php echo $row_usuarioss['id_usuario']; ?>"><?php echo $row_usuarioss['nombre_usuario']; ?></option>
		<?php }while($row_usuarioss=mysqli_fetch_assoc($b_vendedores)); ?>
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
<h2>Informe por vendedor  </h2>
	<div class="table-responsive">
		<form name="busquedaa" method="post">
	<table class=" table table-bordered table-striped table-hover table-sm">
  <tbody>
    <tr align="center" valign="middle" class="thead-dark">
      <th width="78%" scope="col"><input name="id_usuario0" type="text" required class="form-control" placeholder="Elija un vendedor de la lista" list="vendedores" autocomplete="off" ></th>
      <th width="22%" scope="col"><input type="submit" value="Buscar" class="btn btn-primary" /></th>
    </tr>
  </tbody>
</table>
		</form>

	</div>
	
</div>
</div>
	<div class="row">
	<div class="col-md-12">
		<div class="table-responsive  <?php echo $ver; ?>">
	<table class="table table-bordered table-striped table-hover table-sm <?php echo $ver; ?>">
  <tbody>
    <tr class="thead-dark  <?php echo $ver; ?>">
      <th scope="col">ID</th>
      <th scope="col">Correo</th>
      <th scope="col">Nombre</th>
      <th scope="col">Pedidos</th>
	  <th scope="col">Comisiones</th>
	  <th scope="col">Pagado</th>
	  <th scope="col">Saldo</th>
	  <th scope="col">Pagar comisiones</th>
    </tr>
	  <?PHP do{ ?>
    <tr align="center" valign="middle" class=" <?php echo $ver; ?>">
      <td><?php echo $row_usuarios0['id_usuario']; $id_usu=$row_usuarios0['id_usuario']; ?></td>
      <td><?php echo $row_usuarios0['correo_usuario']; ?></td>
      <td><?php echo $row_usuarios0['nombre_usuario']; ?></td>
      <td><a href="ver_pedidos.php?id_usuario=<?php echo $row_usuarios0['id_usuario']; ?>" class="btn btn-info btn-sm">Pedidos</a></td>
		<td><?php
			   $porcentaje=0;
			   $b_carro=mysqli_query($conexion, "SELECT * FROM carrito WHERE id_usuario=$id_usu");
			while($row_carro=mysqli_fetch_assoc($b_carro)){
				$porcentaje+=$row_carro['porcentaje'];
			} 
			echo number_format($porcentaje,2);
			?></td>
		<td><?php $b_pagos=mysqli_query($conexion, "SELECT SUM(total) AS total_suma FROM abono_comision WHERE id_usuario=$id_usu");
			$row_pagos=mysqli_fetch_assoc($b_pagos); 
			echo number_format($row_pagos['total_suma'],2);
			?></td>
		<td><?php echo number_format($porcentaje-$row_pagos['total_suma']); ?></td>
		<td><a href="pagar_comision.php?id_usuario=<?php echo $row_usuarios['id_usuario']; ?>" class="btn btn-success btn-sm">Pagar</a></td>
    </tr>
	  <?php }while($row_usuarios0=@mysqli_fetch_assoc($los_usuarios0)); ?>
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