<?php 
require('conexion/conexion.php');
require('conexion/acceso.php');
include_once('escape.php');
$nivel=$_SESSION['nivel'];
if($nivel<3){
	echo "<script type='text/javascript'>
	alert('Usted no tiene permiso para visualizar este archivo');
	window.location='index.php';
	</script>";
}
//require_once('acceso.php');
//Codigo para registrar el usuario
if(isset($_POST['correo_usuario'])){
	
	$correo_usuario=test_entrada($_POST['correo_usuario']);
	$nombre_usuario=test_entrada($_POST['nombre_usuario']);
	$clave=password_hash($_POST['clave'], PASSWORD_DEFAULT);
	
	
	$sql="INSERT INTO usuarios (correo_usuario, nombre_usuario, clave) VALUES (?,?,?)";
	$stmt=$conexion->prepare($sql);
	$stmt->bind_param('sss',$correo_usuario, $nombre_usuario, $clave);
	$stmt->execute();
	$stmt->close();
}

$los_usuarios=mysqli_query($conexion, "SELECT * FROM usuarios");
$row_usuarios=mysqli_fetch_assoc($los_usuarios);
$ver='nover';
if($row_usuarios['id_usuario'] !=''){
	$ver='';
}

?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<title>Frutos del campo</title>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="css/mi_estilo.css" />
	<script type="text/javascript">
	function validar_pass(){
		var clave=document.registrar.clave.value;
		var clave2=document.registrar.clave2.value;
		if(clave!=clave2){
			alert('Las contraseñas no coinciden');
			document.registrar.clave.value='';
			document.registrar.clave2.value='';
			return false;
		}
	}
		function nivelar(){
			var id_municipio=document.registrar.id_municipio.value;
			var nivel=document.registrar.nivel.value;
			
			
			
		}
		function confirmacion(id_usuario){
			var confirmar=confirm('Seguro que desea eliminar este usuario?. Esta accion no se puede deshacer');
			if(confirmar){
				window.location='eliminar_usuario.php?id_usuario='+id_usuario;
			}
		}
	</script>
</head>

<body>
	<datalist id="municipios">
		<option value="0">Socio</option>
	<option value="<?php echo @$row_municipio['id_municipio']; ?>"><?php echo @$row_municipio['municipio']; ?></option>
		<?php do{ ?>
		<option value="<?php echo $row_municipios['id_municipio']; ?>"><?php echo $row_municipios['municipio']; ?></option>
		<?php } while($row_municipios=mysqli_fetch_assoc($los_municipios)); ?>
	</datalist>
<div class="container-fluid">
<!--primera fila del menú-->
<div class=" row">
<div class="col-md-12 slider">

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
    
    <div class="col-md-12">
      <?php //echo $_COOKIE['Invitado']; ?>
    </div>
  </div>
</div>



</div>
</div>
<!--Segunda fila-->
<div class="row">
	
	
<div class="col-sm-12">
<h1>Listado de Vendedores </h1>
	
	<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover table-sm <?php echo $ver; ?>">
  <tbody>
    <tr class="thead-dark">
      <th scope="col">ID</th>
      <th scope="col">CORREO</th>
      <th scope="col">NOMBRE</th>
      <th scope="col">ELIMINAR</th>
    </tr>
	  <?PHP do{ ?>
    <tr>
      <td><?php echo $row_usuarios['id_usuario']; ?></td>
      <td><?php echo $row_usuarios['correo_usuario']; ?></td>
      <td><?php echo $row_usuarios['nombre_usuario']; ?></td>
      <td><a href="#" class="btn btn-danger btn-sm <?php echo $ver; ?>" onClick="confirmacion(<?php echo $row_usuarios['id_usuario']; ?>) ">Eliminar</a></td>
    </tr>
	  <?php }while($row_usuarios=mysqli_fetch_assoc($los_usuarios)); ?>
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
<?php


mysqli_free_result($los_usuarios);
?>