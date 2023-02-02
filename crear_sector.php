<?php 
require('conexion/conexion.php');
require('conexion/acceso.php');
include('escape.php');
$ver='nover';
if($_SESSION['nivel']<3){
	header('Location: index.php');
}
//Registrando el nuevo sector
if(isset($_POST['nombre_sector'])){
	$id_ciudad=test_entrada($_POST['ciudad']);
	//Registro la ciudad
	if(!is_numeric($id_ciudad)){
		$sql="INSERT INTO ciudades (nombre_ciudad) VALUES (?)";
		$stmt=$conexion->prepare($sql);
		$stmt->bind_param('s', $id_ciudad);
		$stmt->execute();
		$stmt->close();
		//Busco el ultimo registro
		$b_ciudad=mysqli_query($conexion, "SELECT id_ciudad FROM ciudades ORDER BY id_ciudad DESC LIMIT 1");;
		$row_ciudad=mysqli_fetch_assoc($b_ciudad);
		$id_ciudad=$row_ciudad['id_ciudad'];
	}
	$nombre_sector=test_entrada($_POST['nombre_sector']);
	$observacion=test_entrada($_POST['observacion']);
	$sql="INSERT INTO sectores (id_ciudad, nombre_sector, observacion) VALUES (?,?,?)";
	$stmt=$conexion->prepare($sql);
	$stmt->bind_param('iss', $id_ciudad, $nombre_sector, $observacion);
	if(!$stmt->execute()){
		echo "<script type='text/javascript'>
		alert('No se realizó el registro, hubo un problema');
		</script>";
	}
	$stmt->close();
}

//Actualizo el sector
if(isset($_POST['id_sector2'])){
	$id_sector2=test_entrada($_POST['id_sector2']);
	$nombre_sector2=test_entrada($_POST['nombre_sector2']);
	$observacion2=test_entrada($_POST['observacion2']);
	$sql="UPDATE sectores SET nombre_sector=?, observacion=? WHERE id_sector=?";
	$stmt=$conexion->prepare($sql);
	$stmt->bind_param('ssi', $nombre_sector2, $observacion2, $id_sector2);
	$stmt->execute();
}
//Juego de registros para buscar los sectores registrados
$b_sectores=mysqli_query($conexion, "SELECT * FROM sectores JOIN ciudades ON sectores.id_ciudad=ciudades.id_ciudad ORDER BY nombre_sector");
$row_sectores=mysqli_fetch_assoc($b_sectores);
if($row_sectores['id_sector']!=''){$ver='';}

//Juego de registros para buscar las ciudades registradas
$las_ciudades=mysqli_query($conexion, "SELECT * FROM ciudades");
$row_ciudades=mysqli_fetch_assoc($las_ciudades);
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="robots" content="noindex">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<script type="text/javascript">
function validar(str){
	var xmlhttp;
	
	
	if(str == ""){
		document.getElementById("txtHint").innerHTML= "";
		return;
		}
		
		if(window.XMLHttpRequest){
			xmlhttp = new XMLHttpRequest();
			}
			else{
				xmlhttp = new ActiveXObjet("Microsoft.XMLHTTP");
				
				}
				xmlhttp.onreadystatechange=function(){
					if(xmlhttp.readyState==4 && xmlhttp.status == 200){
						document.getElementById("sector").innerHTML=xmlhttp.responseText;
						}
					}
					
					xmlhttp.open("GET", "b_sector.php?sector="+str, true);
					xmlhttp.send();
	}
		function cargar(id_sector, nombre_sector, observacion){
			document.editar_sector.id_sector2.value=id_sector;
			document.editar_sector.nombre_sector2.value=nombre_sector;
			document.editar_sector.observacion2.value=observacion;
		}
		function eliminar(id_sector){
			var confirmar=confirm('Seguro que desea eliminar este sector?, esta accion no se puede deshacer');
			if(confirmar){
				window.location='eliminar_sector.php?id_sector='+id_sector;
			}
		}
		
</script>

<title>Repartos</title>

<link rel="stylesheet" type="text/css" href="css/mi_estilo.css" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="mis_css/mis_estilos.css" />
</head>

<body>
	<datalist id="ciudades">
		<?php do{ ?>
              <option value="<?php echo $row_ciudades['id_ciudad']; ?>"><?php echo $row_ciudades['nombre_ciudad']; ?></option>
			<?php }while($row_ciudades=mysqli_fetch_assoc($las_ciudades)); ?>
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
<div align="center"><span class="carro" id="carro"></div>	</div>
  </div>
	
	<div class="row">
	
<div class="col-sm-12">
<h1>Crear sector</h1>
	<form name="nuevo_sector" method="post">
	<div class="form-group">
		<label for="ciudad">Ciudad *</label>
		  <input type=text name="ciudad" class="form-control" required placeholder="Ingrese el nombre de la ciudad" autocomplete="off" list="ciudades" >
		</div>

		
	  <div class="form-group">
		<label for="nombre_sector">Nombre del sector *</label>
		  <input type=text name="nombre_sector" class="form-control" required placeholder="Ingrese el nombre del sector" autocomplete="off" onKeyUp="validar(this.value)">
		</div>

		<div id="sector" class="rojo"></div>
		<div class="form-group">
		<label for="observacion">Observacion </label>
			<textarea name="observacion" class="form-control" placeholder="Escriba cualquier observacion respecto al nuevo sector"></textarea>
		</div>
		<div class="form-group">
		<input type="submit" class="btn btn-dark" value="Crear sector"/>
		</div>
	</form>
	
</div>
</div>
	<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">
		<table class=" table table-bordered table-striped table-hover table-sm <?php echo $ver; ?>">
  <tbody>
    <tr align="center" valign="middle" class="thead-dark">
      <th scope="col">Id</th>
	  <th scope="col">Ciudad</th>
      <th scope="col">Nombre sector</th>
      <th scope="col">Observacion</th>
      <th scope="col">Editar</th>
      <th scope="col">Eliminar</th>
    </tr>
	  <?php do{ ?>
    <tr align="center" valign="middle">
      <td><?PHP echo @$row_sectores['id_sector']; $id_sector=@$row_sectores['id_sector']; ?></td>
	  <td><?php echo $row_sectores['nombre_ciudad']; ?></td>
      <td><?PHP echo @$row_sectores['nombre_sector'];$nombre_sector=@$row_sectores['nombre_sector']; ?></td>
      <td><?PHP echo @$row_sectores['observacion']; $observacion=@$row_sectores['observacion']; ?></td>
      <td><a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal" onClick="cargar(<?php echo $id_sector; ?>, '<?php echo $nombre_sector; ?>', '<?php echo $observacion; ?>')">Editar</a></td>
      <td><a href="#" class="btn btn-danger btn-sm" onClick="eliminar(<?php echo $id_sector; ?>)">Eliminar</a></td>
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