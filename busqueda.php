<?php 
require('conexion/conexion.php');
include('crear_cookie.php');
include('escape.php');
if($_COOKIE['Invitado'] == ''){
	header('Location: http://localhost/tesoro');
	}
$invitado=test_entrada($_COOKIE['Invitado']);



//Codigo para buscar los departamentos
$b_departamentos=mysqli_query($conexion, "SELECT * FROM departamentos ORDER BY nombre");
$row_departamentos=mysqli_fetch_assoc($b_departamentos);

//Codigo para capturarl el idSubdepartamento
$idSubdepartamento=1;
if(isset($_GET['sub'])){
	$idSubdepartamento=test_entrada($_GET['sub']);
}


	//CODIGO PARA BUSCAR TODOS LOS SUBDEPARTAMENTOS
	$b_subdepartamentos=mysqli_query($conexion, "SELECT idSubdepartamento, idDepartamento, nombre, descripcion FROM subdepartamento WHERE idSubdepartamento=$idSubdepartamento");
	$row_subdepartamentos=mysqli_fetch_assoc($b_subdepartamentos);
	
	


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
	
<link rel="stylesheet" type="text/css" href="css/galeria.css" />

<script type="text/javascript" src="js/jquery.js"></script>
	
	
	<script type="text/javascript">
	function cargar_carrito(str, unidad, contador, cantidad){
		var xmlhttp;
		
		
		if(isNaN(cantidad) || cantidad==0){
			alert('Valor invalido, no se ha realizado el registro');
		}
		
		if(cantidad && !isNaN(cantidad) && cantidad>0){
		
		if(str==""){
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
				document.getElementById("carro").innerHTML=xmlhttp.responseText;
				document.getElementById("carro"+contador).innerHTML="Agregado"+" "+cantidad;
				
			}
		 }
		}
		
		xmlhttp.open("GET", "cargar_carrito.php?idProducto="+str+"&cantidad="+cantidad, true);
		xmlhttp.send();
		
	}
	
	function aumentar(contador){
		var nuevo_valor=document.getElementById('cantidad'+contador).value;
		nuevo_valor=parseInt(nuevo_valor);
		nuevo_valor=nuevo_valor+1;
		document.getElementById('cantidad'+contador).value=nuevo_valor;
	}
	</script>
</head>

<body>
<div class="container-fluid">
  <div class="row">
	<div class="col-md-12"><!--INICIO DEL MENU-->
    
	<?php session_start(); 
		if(isset($_SESSION['usuario'])){
		include('menuPrincipal.php');	
		}
		else{
		include('menuBasico.php');
		}
		?>
		<?php
		//Buscamos la cantidad de elementos que tiene el carrito
	$b_carrito2=@mysqli_query($conexion, "SELECT id_registro FROM carrito WHERE cedula_cliente IS NULL AND invitado='$invitado'");
	$row_carrito2=@mysqli_fetch_assoc($b_carrito2);
	$filas2=@mysqli_num_rows($b_carrito2);
	//echo $filas;
		?>	
     
    </div>
  </div>
	
	<div class="row">
	
<div class="col-sm-12">
<h1>Busqueda</h1>
</div>
</div>
	<div class="row">
    
    <div class="col-md-12" id="carro">
      
    </div>
  </div>
	<div class="row">
		<div class="col-sm-2">
		<!--Ingresamos el segundo menú-->
			
			<?php include('menu_lateral.php'); ?>
		
		</div>
	<div class="col-sm-10">
		
		<?php
		if(!isset($_POST['buscar'])){
			$idSubdepartamento=1;
		$b_productos=mysqli_query($conexion, "SELECT * FROM productos WHERE idSubdepartamento=$idSubdepartamento AND estado>0");
	$row_productos=@mysqli_fetch_assoc($b_productos);
		}
		
		
		if(isset($_POST['buscar'])){
			$buscar=test_entrada($_POST['buscar']);
			$buscar="%".$buscar."%";
			$b_productos=mysqli_query($conexion, "SELECT * FROM productos WHERE nombre_producto LIKE '$buscar' AND estado>0");
	$row_productos=@mysqli_fetch_assoc($b_productos);
		}
		
		
		?>
	  
		  
		  <?php $contador=0; do{ ?>
		  
		  <div style="float: left;">
			  
		    <ul class="galeria">
		
		<div style="align-content: center; width: 350px; margin: 15px; background-color: #ccc; border-radius: 3px; float: left" align="center;">
	    <li><figure><a href="img/<?php echo $row_productos['imagen']; ?>" target="_blank"><img src="img/miniaturas/<?php echo $row_productos['imagen']; ?>" width="320" alt="<?php echo $row_productos['nombre_producto']; ?>" /></a>
			<figcaption><b style="font-size: 20px;"><?php echo $row_productos['nombre_producto']; ?></b><br><br>
				<b style="font-size: 24px;"><?php echo number_format($row_productos['precio']); ?>, &nbsp;<?php echo $row_productos['unidad']; ?></b><br>
				<input name="cantidad" type="number" placeholder="Cantidad" max="6" autocomplete="off" onChange="cargar_carrito(<?php echo $row_productos['idProducto']; ?>, '<?php echo $row_productos['unidad']; ?>',<?php echo $contador; ?>, this.value) " />
				<?php $id_prod=$row_productos['idProducto']; $texto='';  $clase=""; $b_carro=mysqli_query($conexion, "SELECT cantidad FROM carrito WHERE idProducto=$id_prod AND invitado='$invitado' AND estado=1");
				$row_prod=@mysqli_fetch_assoc($b_carro);
				  $promocion=$row_productos['promocion']; $prom="";
				  if($promocion==1){$prom="Promocion";}
				  if(@$row_prod['cantidad']!=''){$texto="Agregado"." ".$row_prod['cantidad']; }
				  
				?><span id="carro<?php echo $contador; ?>" class="btn btn-success btn-sm" style="font-size: 12px;"><?php echo $texto; ?></span></figcaption>
			</figure></li>
			<div class="<?php echo $prom; ?>"><?php echo $prom; ?></div>
			<div style="margin: 10px; padding: 5px;"><?php echo $row_productos['descripcion']; ?></div>
		</div>
		
		
	</ul>
	    </div>
		  <?php }while($row_productos=@mysqli_fetch_assoc($b_productos)); ?>
		  
	  
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