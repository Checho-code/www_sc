<?php 
require('conexion/conexion.php');
require('conexion/acceso.php');
include('escape.php');
//Recibo el parametro para buscar el usuario
if(isset($_GET['id_usuario']) && is_numeric($_GET['id_usuario'])){
	$id_usu=test_entrada($_GET['id_usuario']);
	$b_usu=mysqli_query($conexion, "SELECT * FROM usuarios WHERE id_usuario=$id_usu");
	$row_usu=mysqli_fetch_assoc($b_usu);
	$b_comisiones=mysqli_query($conexion, "SELECT * FROM abono_comision WHERE id_usuario=$id_usu");
	$row_comisiones=mysqli_fetch_assoc($b_comisiones);
}
else{
	header('Location: listado_vendedores.php');
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
	function confirmacion(id_usuario, id_abono_comision){
		var confirmacion=confirm('Seguro que desea eliminar este elemento?, esta accion no se puede deshacer');
		if(confirmacion){
			window.location='eliminar_comision.php?id_abono_comision='+id_abono_comision+'&id_usuario='+id_usuario;
		}
	}
	</script>
</head>

<body>
<div class="container-fluid">
  <div class="row fixed-top">
	<div class="col-md-12"><!--INICIO DEL MENU-->
    
	<?php 
		
		include('menuPrincipal.php');	
				
		?>	
     
    </div>
  </div>
	
	<div class="row">
	
<div class="col-sm-12">
<h2>Comisiones pagadas a <?php echo $row_usu['nombre_usuario']; ?> </h2>
	<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover table-sm">
  <tbody>
    <tr align="center" valign="middle" class="thead-dark">
      <th scope="col">Id</th>
      <th scope="col">Fecha</th>
      <th scope="col">Hora</th>
      <th scope="col">Total</th>
      <th scope="col">Observacion</th>
      <th scope="col">Eliminar</th>
    </tr>
	  <?php do{ ?>
    <tr align="center" valign="middle">
      <td><?php echo $row_comisiones['id_abono_comision']; ?></td>
      <td><?php echo $row_comisiones['fecha']; ?></td>
      <td><?php echo $row_comisiones['hora']; ?></td>
      <td><?php echo number_format($row_comisiones['total']); ?></td>
      <td><?php echo $row_comisiones['observacion']; ?></td>
      <td><a href="#" onClick="confirmacion(<?php echo $row_usu['id_usuario']; ?>,<?php echo $row_comisiones['id_abono_comision']; ?>)" class="btn btn-danger btn-sm">Eliminar</a></td>
    </tr>
	  <?php }while($row_comisiones=mysqli_fetch_assoc($b_comisiones)); ?>
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