<?php 
require('conexion/conexion.php');
require('conexion/acceso.php');
include('escape.php');

//Juego de registros para buscar los premios
$b_premios=mysqli_query($conexion, "SELECT * FROM premios ORDER BY id_premio");
$row_premios=mysqli_fetch_assoc($b_premios);

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
	function redimir(id_producto){
		var xmlhttp;
		
		if(id_producto==""){
			document.getElementById("txtHint").innerHTML="";
			return;
		}
		if(window.XMLHttpRequest){
			xmlhttp=new XMLHttpRequest();
		}
		else{
			xmlhttp=new ActiveXObjet("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function(){
			if(xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById("respuesta").innerHTML=xmlhttp.responseText;
				
			}
		 }
		xmlhttp.open("GET", "ajx_redimir.php?id_producto="+id_producto, true);
		xmlhttp.send();
		
		
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
<div align="center"><span class="carro" id="carro"><?php echo $filas2; ?></div>	</div>
  </div>
	
	<div class="row">
	
<div class="col-sm-12"><br><br><br>
<div id="txtHint"></div>
<h1>Puntos por redimir: <?php echo number_format($puntos); ?></h1>
<div class="table-responsive">
<table class="table table-bordered table-striped table-hover">
	<tbody>
	 <tr>
		<?php do{ ?>
			<td align="center"><figure>
				<img src="img/miniaturas/<?php echo $row_premios['imagen']; ?>" width="200" height="200" />
				<figcaption><b><?php echo $row_premios['nombre_premio']."  ".number_format($row_premios['puntos'])."  "." Puntos"; ?></b></figcaption>
			</figure>
			<a href="#" class="btn btn-success btn-sm" onclick="redimir(<?php echo $row_premios['id_premio']; ?>)">Redimir</a>
		</td>
		<?php }while($row_premios=mysqli_fetch_assoc($b_premios)); ?>	
	 </tr>
	</tbody>
</table>
</div><br>
<div id="respuesta" style="font-size:40px ; color: green; font-weight:500"></div>
<br>
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