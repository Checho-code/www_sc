<?php 
require('conexion/conexion.php');
require('conexion/acceso.php');
include('escape.php');
$nivel=$_SESSION['nivel'];
if(isset($_GET['id_usuario']) && is_numeric($_GET['id_usuario']) && $nivel>=3){
	$id_usu=test_entrada($_GET['id_usuario']);
	$b_usuario=mysqli_query($conexion, "SELECT * FROM usuarios WHERE id_usuario=$id_usu");
	$row_usu=mysqli_fetch_assoc($b_usuario);
	
	$b_recaudos=mysqli_query($conexion, "SELECT * FROM recaudos LEFT JOIN clientes ON recaudos.idCliente=clientes.idCliente WHERE id_usuario=$id_usu ORDER BY id_recaudo DESC");
	$row_recaudos=mysqli_fetch_array($b_recaudos);
}
else{
	$id_usu=$_SESSION['id_usuario'];
	$b_usuario=mysqli_query($conexion, "SELECT * FROM usuarios WHERE id_usuario=$id_usu");
	$row_usu=mysqli_fetch_assoc($b_usuario);
	
	$b_recaudos=mysqli_query($conexion, "SELECT * FROM recaudos LEFT JOIN clientes ON recaudos.idCliente=clientes.idCliente WHERE id_usuario=$id_usu ORDER BY id_recaudo DESC");
	$row_recaudos=mysqli_fetch_array($b_recaudos);
	
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
  <div class="row">
	<div class="col-md-12"><!--INICIO DEL MENU-->
    
	<?php 
		
		include('menuPrincipal.php');	
				
		?>	
     
    </div>
  </div>
	
	<div class="row">
	
<div class="col-sm-12">
<h2>Listado de recaudos <?php echo $row_usu['nombre_usuario']; ?>  </h2>
	<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover table-sm">
  <tbody>
    <tr align="center" valign="middle" class="thead-dark">
      <th scope="col">Id</th>
      <th scope="col">Cliente</th>
      <th scope="col">Fecha</th>
      <th scope="col">Hora</th>
      <th scope="col">Total</th>
      <th scope="col">Abono</th>
      
      <th scope="col">Eliminar</th>
    </tr>
	  <?php do{ ?>
    <tr align="center" valign="middle">
      <td><?php echo $row_recaudos['id_recaudo']; ?></td>
      <td><?php echo $row_recaudos['nombre']; ?></td>
      <td><?php echo $row_recaudos['fecha_recaudo']; ?></td>
      <td><?php echo $row_recaudos['hora_recaudo']; ?></td>
      <td><?php echo number_format($row_recaudos['total_recaudo']); ?></td>
      <td><?php echo number_format($row_recaudos['abono_recaudo']); ?></td>
      
    <td><a href="eliminar_recaudo.php?id_usuario=<?php echo $row_usu['id_usuario']; ?>&id_recaudo=<?php echo $row_recaudos['id_recaudo']; ?>&id_abono_pedido=<?php echo $row_recaudos['id_abono_pedido']; ?>" class="btn btn-danger btn-sm">Eliminar</a></td>
    </tr>
	  <?php }while($row_recaudos=mysqli_fetch_assoc($b_recaudos)); ?>
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