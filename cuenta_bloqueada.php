<?php
session_start();
		session_destroy();
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
<h1>Cuenta bloqueada por intentos fallidos de acceso</h1>
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