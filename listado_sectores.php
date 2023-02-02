<?php 
require('conexion/conexion.php');
require('conexion/acceso.php');
include('escape.php');
if($_SESSION['nivel']<3){
	header('Location: index.php');
}

//Juego de registros para buscar los sectores registrados
$b_sectores=mysqli_query($conexion, "SELECT id_sector, nombre_sector, observacion FROM sectores ORDER BY nombre_sector");
$row_sectores=mysqli_fetch_assoc($b_sectores);
if($row_sectores['id_sector']!=''){$ver='';}
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="robots" content="noindex">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<title>Repartos</title>

<link rel="stylesheet" type="text/css" href="css/mi_estilo.css" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="mis_css/mis_estilos.css" />
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
<h1>Listado de sectores</h1>
	
	
</div>
</div>
	<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">
		<table class=" table table-bordered table-striped table-hover table-sm">
  <tbody>
    <tr align="center" valign="middle" class="thead-dark">
      <th scope="col">Id</th>
      <th scope="col">Nombre</th>
      <th scope="col">Observacion</th>
      <th scope="col">Pedidos</th>
      <th scope="col">Ventas</th>
    </tr>
	  <?php do{ ?>
    <tr align="center" valign="middle">
      <td><?PHP echo $row_sectores['id_sector']; $id_sector=$row_sectores['id_sector']; ?></td>
      <td><?PHP echo $row_sectores['nombre_sector'];$nombre_sector=$row_sectores['nombre_sector']; ?></td>
      <td><?PHP echo $row_sectores['observacion']; $observacion=$row_sectores['observacion']; ?></td>
      <td></td>
      <td></td>
    </tr>
	  <?php }while($row_sectores=mysqli_fetch_assoc($b_sectores)); ?>
  </tbody>
</table>

	  </div>
	  </div>
	</div>
	<div class="row">
	<div class="col-md-12">
		<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar sector</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
		  <form name="editar_sector" method="post">
	  <div class="form-group">
		<label for="nombre_sector2">Nombre del sector *</label>
		  <input type=text name="nombre_sector2" class="form-control" required placeholder="Ingrese el nombre del sector" autocomplete="off">
		</div>
		<div id="sector" class="rojo"></div>
		<div class="form-group">
		<label for="observacion2">Observacion </label>
			<textarea name="observacion2" class="form-control" placeholder="Escriba cualquier observacion respecto al nuevo sector"></textarea>
			<input type="hidden" name="id_sector2" />
		</div>
		<div class="form-group">
		<div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Guardar</button>
      </div>
		</div>
	</form>
		  
      </div>
      <!--<div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Guardar</button>
      </div>-->
    </div>
  </div>
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
<?php mysqli_free_result($b_sectores); ?>