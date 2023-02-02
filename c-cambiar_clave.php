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
if(isset($_POST['correo_usuario'])){
    $correo_usuario=test_entrada($_POST['correo_usuario']);
    $clave=test_entrada($_POST['clave']);
    $clave=password_hash($clave, PASSWORD_DEFAULT);
    $actualizar=mysqli_query($conexion, "UPDATE usuarios SET clave='$clave' WHERE correo_usuario='$correo_usuario'");
    if($actualizar){
        echo "<script type='text/javascript'>
        alert('El cambio de contraseña se realizó correctamente');
        </script>";
    }
    else{
        echo "<script type='text/javascript'>
        alert('Hubo un error, no se hizo cambios');
        </script>";
    }
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
<h2>Cambio de  clave</h2>
<form name="cambio_clave" method="POST">
    <div class="form-group">
        <label for="cedula">Cedula del cliente *</label>
        <input type="text" name="correo_usuario" class="form-control" required placeholder="ingrese la cedula del cliente" />
    </div>
    <div class="form-group">
        <label for="clave">Nueva Contraseña *</label>
        <input type="password" class="form-control" required placeholder="Nueva contraseña" name="clave" />
    </div>
    <div class="form-group">
        <input type="submit" value="Cambiar contraseña" class="btn btn-primary btn-sm" />
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