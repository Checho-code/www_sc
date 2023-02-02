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


function RandomString()
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randstring = '';
    for ($i = 0; $i < 30; $i++) {
        $randstring = @$randstring.@$characters[rand(0, strlen($characters))];
    }
    return $randstring;
}


function codificar()
{
    $characters = '0123456789';
    $codigo = '';
    for ($i = 0; $i <= 11; $i++) {
        $codigo = @$codigo.@$characters[rand(0, strlen($characters))];
    }
    return $codigo;
}

function crearMiniatura($rand, $nombre_archivo){
	$nombre_archivo=$rand."-".$nombre_archivo;
		$finalWidth=500;
		$dirFullImage="img/";
		$dirTumbsImage="img/miniaturas/";
		$tmpName=$_FILES['imagen']['tmp_name'];
		$finalName=$dirFullImage.$rand."-".$_FILES['imagen']['name'];
		//Copiar imagen a la carpeta principal
		copiarImagen($tmpName, $finalName);
		$im=null;
		if(preg_match('/[.](jpg)$/', $nombre_archivo)){
			$im=imagecreatefromjpeg($finalName);
			}
			else if(preg_match('/[.](jpeg)$/', $nombre_archivo)){
			$im=imagecreatefromjpeg($finalName);
			}
		else if(preg_match('/[.](gif)$/', $nombre_archivo)){
			$im=imagecreatefromgif($finalName);
			}
		else if(preg_match('/[.](png)$/', $nombre_archivo)){
			$im=imagecreatefrompng($finalName);
			}
			$width=round(imagesx($im));
			$height=imagesy($im);
			
			$minWidth=$finalWidth;
			$minHeight=round($height * ($finalWidth/$width));
			
			$imageTrueColor=imagecreatetruecolor($minWidth, $minHeight);
			imagecopyresized($imageTrueColor, $im, 0, 0, 0, 0, $minWidth, $minHeight, $width, $height);
			
			if(!file_exists($dirTumbsImage)){
				if(!mkdir($dirTumbsImage)){
					die("Hubo un problema con la miniatura");
					}
				}
				
				imagejpeg($imageTrueColor, $dirTumbsImage.$nombre_archivo);
				return $nombre_archivo;
		}
		
		
		function copiarImagen($origen, $destino){
			$resultado=move_uploaded_file($origen, $destino);
			}



if(isset($_POST['nombre_producto']) && $_POST['nombre_producto'] != ''){
	//$idDepartamento=test_entrada($_POST['idDepartamento']);
	//$idSubdepartamento=test_entrada($_POST['idSubdepartamento']);
	$nombre_producto=test_entrada($_POST['nombre_producto']);
	$precio=test_entrada($_POST['precio']);
	$porcentaje=test_entrada($_POST['porcentaje']);
	$descripcion=test_entrada($_POST['descripcion']);
	$estado=1; $promocion=test_entrada($_POST['promocion']);
	$idDepartamento=test_entrada($_POST['idDepartamento']);
	$idSubdepartamento=test_entrada($_POST['idSubdepartamento']);
	$unidad=test_entrada($_POST['unidad']);
	
	
	$cargar=''; $resultado=false;
	$nombre = $_FILES['imagen']['name'];
	$nombrer = strtolower($nombre);
//determino que el archivo que se ha subido no tenga mas de una extencion
 $extenciones=substr_count($nombrer, ".");
	
	if($extenciones==1 && ($_FILES["imagen"]["size"] < 10000000)){
	$rand=RandomString();
	########################Inicio de los otros formatos #########################################
	//crearMiniatura($rand, $_FILES['imagen']['name']);
	

if ($nombre_archivo2=crearMiniatura($rand, $_FILES['imagen']['name'])){
	//Creo el departamento si no existe y el subdepartamento
	if($idDepartamento == 0 && $idSubdepartamento == 0){
		
		//Creacion del departamento
		$nombre_departamento=test_entrada($_POST['nombre_departamento']);
		$sql_dep="INSERT INTO departamentos (nombre) VALUES (?)";
		$stmt_dep=$conexion->prepare($sql_dep);
		$stmt_dep->bind_param('s', $nombre_departamento);
		$stmt_dep->execute();
		$stmt_dep->close();
		
		//Busco el departamento creado
		$sql_ultimo_dep="SELECT MAX(idDepartamento) AS maximoDepartamento FROM departamentos";
		$ultimo_dep=mysqli_query($conexion, $sql_ultimo_dep);
		$row_ultimo=mysqli_fetch_assoc($ultimo_dep);
				$idDepartamento=$row_ultimo['maximoDepartamento'];
				
			
		//ceacion del subdepartamento
		$nombre_subdepartamento=test_entrada($_POST['nombre_subdepartamento']);
		$sql_sub="INSERT INTO subdepartamento (idDepartamento, nombre) VALUES (?,?)";
		$stmt_sub=$conexion->prepare($sql_sub);
		$stmt_sub->bind_param('is', $idDepartamento, $nombre_subdepartamento);
		$stmt_sub->execute();
		$stmt_sub->close();
		
		//Busco el ultimo subdepartamento creado para registrar el producto
			$sql_ultimo_sub="SELECT MAX(idSubdepartamento) AS ultimoSub FROM subdepartamento";
			$ultimo_sub=mysqli_query($conexion, $sql_ultimo_sub);
			$row_ultimo_sub=mysqli_fetch_assoc($ultimo_sub);
			$idSubdepartamento=$row_ultimo_sub['ultimoSub'];
		}
		if($_POST['idDepartamento'] != 0 && $_POST['idSubdepartamento'] == 0){
			
			//Creo solo el subdepartamento
			$nombre_subdepartamento=test_entrada($_POST['nombre_subdepartamento']);
			$sql_sub="INSERT INTO subdepartamento (idDepartamento, nombre) VALUES (?,?)";
		    $stmt_sub=$conexion->prepare($sql_sub);
		    $stmt_sub->bind_param('is', $idDepartamento, $nombre_subdepartamento);
		    $stmt_sub->execute();
		    $stmt_sub->close();
			
			//Busco el ultimo subdepartamento creado y registro el producto
			$sql_ultimo_sub="SELECT MAX(idSubdepartamento) AS ultimoSub FROM subdepartamento";
			$ultimo_sub=mysqli_query($conexion, $sql_ultimo_sub);
			$row_ultimo_sub=mysqli_fetch_assoc($ultimo_sub);
			$idSubdepartamento=$row_ultimo_sub['ultimoSub'];
			
			}
	
	$stmt=$conexion->prepare("INSERT INTO productos (idDepartamento, idSubdepartamento, nombre_producto, precio, unidad, porcentaje, descripcion, imagen, estado, promocion) VALUES (?,?,?,?,?,?,?,?,?,?)");
	$stmt->bind_param('iisdsdssii', $idDepartamento, $idSubdepartamento, $nombre_producto, $precio, $unidad, $porcentaje, $descripcion, $nombre_archivo2, $estado, $promocion);
	$stmt->execute();
	$stmt->close();
	
	}
}
else{
		 echo "<script type='text/javascript'>
		 alert('El formato no es permitido o es demasiado granden no se ha realizado el registro');
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
	
	<script type="text/javascript">
function showselect(str){
	var xmlhttp;
	
	if(str == 0){
		document.publicar.nombre_departamento.value=prompt('Ingrese el nombre del nuevo departamento');
		}
	
	if(str == ""){
		document.getElementById("txtHint").innerHTML= "";
		document.publicar.nombre_departamento.value="";
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
						document.getElementById("cliente").innerHTML=xmlhttp.responseText;
						}
					}
					
					xmlhttp.open("GET", "b_subdepartamento.php?id_departamento="+str, true);
					xmlhttp.send();
	}
	function cargar(){
		if(document.publicar.idSubdepartamento.value==0){
			document.publicar.nombre_subdepartamento.value=prompt('Ingrese el nombre del nuevo subdepartamento');
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
	<div align="center"><span class="carro" id="carro"><?php echo $filas2; ?></div>	</div>
  </div>
	
	<div class="row">
	
<div class="col-sm-12">

	<form name="publicar" id="publicar" method="post" enctype="multipart/form-data">
<h2>Publicar producto  </h2>
<div class="form-group">
<label for="idDepartamento">Departamento*</label>
<select name="idDepartamento" id="idDepartamento" class="form-control" onChange="showselect(this.value) ">
<option value="">Ninguno</option>
<option value="0">Nuevo</option>
<?php include('ajx_subdepartamentos.php'); ?>
</select>
</div>

<div class="form-group" id="cliente">



</div>

<div class="form-group">
    <label for="nombre producto">Nombre del producto*</label>
    <input name="nombre_producto" type="text" required class="form-control" placeholder="Ingrese nombre del producto" autocomplete="off">
  </div>
  
  <div class="form-group">
    <label for="Precio">Precio*</label>
    <input name="precio" type="text" required class="form-control" autocomplete="off">
  </div>
  
  <div class="form-group">
    <label for="Unidad">Unidad*</label>
    <input name="unidad" type="text" required class="form-control" placeholder="Ej: libra, kilo, par, unidad">
  </div>
		
		<div class="form-group">
    <label for="porcentaje">Porcentaje*</label>
    <input name="porcentaje" type="text" required class="form-control" placeholder="Ingrese el porcentaje sin el simbolo % Ej: 10" autocomplete="off">
  </div>

<div class="form-group">
    <label for="descripcion">Descripcion</label>
    <textarea name="descripcion" required class="form-control" placeholder="Ingrese los detalles del producto como presentacion, procedencia, marca etc"></textarea>
  </div>
  
  
  <div class="form-group">
<label for="Promocion">Promocion*</label>
<select name="promocion" required class="form-control" id="promocion">
<option value="">Ninguno</option>
<option value="1">Si</option>
<option value="0">No</option>
</select>
</div>
  
  <div class="form-group">
  <label for="imagen">Seleccione la imagen del producto</label>
  <input type="file" name="imagen" class="form-control-file" accept="image/jpeg, image/jpg, image/png, image/gif" lang="es">
  </div>
  

  <div class="form-group">
  <input type="submit" value="publicar" class="btn btn-dark">
  <input type="hidden" name="nombre_departamento" id="nombre_departamento">
  <input type="hidden" name="nombre_subdepartamento" id="nombre_subdepartamento">
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