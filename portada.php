<?php 
require('conexion/conexion.php');
require('conexion/acceso.php');
require('escape.php');
$nivel=$_SESSION['nivel'];
if($nivel>=3){
  header('Location: listado_vendedores.php');
}
else{
  header('Location: index');
}


?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<title>Muenú principal</title>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="css/mi_estilo.css" />
</head>

<body>
<div class="container">
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
    
    <div class="col-md-12"></div>
  </div>
</div>



</div>
</div>
<!--Segunda fila-->
<div class="row">
	
	
<div class="col-sm-12">
<h1>Repartos</h1>
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