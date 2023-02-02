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
//Codigo para registrar el nuevo vendedor
if(isset($_POST['correo_usuario'])){
	$correo_usuario=test_entrada($_POST['correo_usuario']);
	$nombre_usuario=test_entrada($_POST['nombre_usuario']);
	$clave=password_hash($_POST['clave'], PASSWORD_DEFAULT);
	$nivel=test_entrada($_POST['nivel']);
	$fecha_registro=date('Y-m-d');
	$sql="INSERT INTO usuarios (correo_usuario, nombre_usuario, clave, nivel, fecha_registro) VALUES (?,?,?,?,?)";
	$stmt=$conexion->prepare($sql);
	$stmt->bind_param('sssis', $correo_usuario, $nombre_usuario, $clave, $nivel, $fecha_registro);
	$stmt->execute();
	$stmt->close();
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
	function validar(){
		var clave=document.registrar.clave.value;
		var clave2=document.registrar.clave2.value;
		if(clave!=clave2){
			alert('Las contraseñas no coinsiden');
			document.registrar.clave.value='';
			document.registrar.clave2.value='';
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
<div align="center"><span class="carro" id="carro"></div>	</div>
  </div>
	
	<div class="row">
	
<div class="col-sm-12">
<h1>Nuevo vendedor</h1>
	<form name="registrar" method="post" onSubmit="return validar()">
	<div class="form-group">
		<label for="correo_usuario">Cedula del usuario *</label>
		<input type="number" name="correo_usuario" autocomplete="off" class="form-control" required placeholder="Ingrese la cedula del cliente" />
		</div>
		
		<div class="form-group">
		<label for="nombre_suaurio">Nombre del vendedor *</label>
		<input type="text" name="nombre_usuario" autocomplete="off" class="form-control" required placeholder="Ingrese el nombre del vendedor" />
		</div>
		
		<div class="form-group">
		<label for="clave">Contraseña *</label>
		<input type="password" name="clave" autocomplete="off" class="form-control" required placeholder="Ingrese una contraseña" />
		</div>
		
		
		<div class="form-group">
		<label for="clave2">Contraseña *</label>
		<input type="password" name="clave2" autocomplete="off" class="form-control" required placeholder="Repita la contraseña" />
		</div>
		<div class="form-group">
		<label for="nivel">Rol *</label>
			<select name="nivel" required="required" class="form-control">
		  <option value="">Ninguno</option>
		  <option value="3">Administrador</option>
		  <option value="2">Vendedor</option>
		  <option value="1">Repartidor</option>
		  <option value="0">Empacador</option>
		</select>
		</div>
		<div class="form-group">
		<input type="submit" class="btn btn-dark" value="Registrar" >
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