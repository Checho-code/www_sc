<?php 
require('conexion/conexion.php');
require('conexion/acceso.php');
include_once('escape.php');
$complemento='';
$usuario=$_SESSION['usuario'];

//Codigo para registrar el usuario
if(isset($_POST['correo_usuario'])){
	
	$correo_usuario=test_entrada($_POST['correo_usuario']);
	$nombre_usuario=test_entrada($_POST['nombre_usuario']);
	$clave=password_hash($_POST['clave'], PASSWORD_DEFAULT);
	$sql="UPDATE usuarios SET nombre_usuario=?, clave=? WHERE correo_usuario=?";
	$stmt=$conexion->prepare($sql);
	$stmt->bind_param('sss', $nombre_usuario, $clave, $correo_usuario);
	$stmt->execute();
		$stmt->close();
	
}



$los_usuarios=mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo_usuario='$usuario' ORDER BY nombre_usuario");
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

<title>Caminos de amor</title>
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
			if(nivel>1 && id_municipio!=0){
				alert('Para un socio el municipio debe ser 0');
				document.registrar.id_municipio.value=0;
			}
			if(nivel==1 && id_municipio ==0){
				alert('Debe elegir un municipio para el administradpr de sede');
				document.registrar.id_municipio.value='';
			}
			
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
		<option value="<?php echo $row_usuarios['id_usuario'] ?>"><?php echo $row_usuarios['municipio']; ?></option>
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
<h1>Editar usuario <?php echo $row_usuarios['nombre_usuario']; ?></h1>
	<form name="registrar" method="post">
	
		<div class="form-group">
		<label for="correo">Cedula del usuario *</label>
		  <input type="text" name="correo_usuario" class="form-control" required placeholder="Correo del usuario" value="<?php echo $row_usuarios['correo_usuario']; ?>" readonly />
		</div>
		<div class="form-group">
		<label for="nombre_usuario">Nombre del usuario *</label>
			<input type="text" class="form-control" name="nombre_usuario" required placeholder="Nombre completo del usuario" value="<?php echo $row_usuarios['nombre_usuario']; ?>" />
		</div>
		<div class="form-group">
		<label for="clave">Contraseña *</label>
			<input name="clave" type="password" required class="form-control" placeholder="Ingrese una clave" autocomplete="off" />
		</div>
		<div class="form-group">
		<label for="clave2">Repita la contraseña*</label>
			<input type="password" class="form-control" name="clave2" required placeholder="Repita su clave" onBlur="validar_pass() " />
		</div>
		
		<div class="form-group">
		<input type="submit" value="Actualizar" class="btn btn-dark" />
		</div>
	</form>
	<div class="table-responsive"></div>
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