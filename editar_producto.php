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
/*if($_COOKIE['Invitado'] == ''){
	header('Location: http://localhost/tesoro');
	}*/

    //Capturo el parametro del producto y creo el juego de registros
    if(isset($_GET['id_producto']) && is_numeric($_GET['id_producto'])){
        $idProducto=test_entrada($_GET['id_producto']);
        $b_prod=mysqli_query($conexion, "SELECT * FROM productos WHERE idProducto=$idProducto");
        $row_prod=mysqli_fetch_assoc($b_prod);
    }



function RandomString(){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randstring = '';
    for ($i = 0; $i < 30; $i++) {
        $randstring = @$randstring.@$characters[rand(0, strlen($characters))];
    }
    return $randstring;
}
function codificar(){
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
			$width=imagesx($im);
			$height=imagesy($im);
			
			$minWidth=$finalWidth;
			$minHeight=floor($height * $finalWidth/$width);
			
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





//Codigo para actualizar el producto
if(isset($_POST['idProducto2']) && is_numeric($_POST['idProducto2'])){
	$id_producto2=test_entrada($_POST['idProducto2']);
	$nombre_producto2=test_entrada($_POST['nombre_producto2']);
	$precio2=test_entrada($_POST['precio2']);
	$unidad2=test_entrada($_POST['unidad2']);
	$porcentaje2=test_entrada($_POST['porcentaje2']);
	$descripcion2=test_entrada($_POST['descripcion2']);
	$promocion2=test_entrada($_POST['promocion2']);
	$disponible2=test_entrada($_POST['disponible2']);
	
	$sql_act="UPDATE productos SET nombre_producto=?, precio=?, unidad=?, porcentaje=?, descripcion=?, estado=?, promocion=? WHERE idProducto=?";
	$stmt_act=$conexion->prepare($sql_act);
	$stmt_act->bind_param('sdsdsiii', $nombre_producto2, $precio2, $unidad2, $porcentaje2, $descripcion2, $disponible2, $promocion2, $id_producto2);
	$stmt_act->execute();
	$stmt_act->close();
	
	
	
	######## -- Codigo para editar la imagen del producto -- #####################
	//$correo=$_SESSION['usuario'];

//Juego de registro del producto
$sql_producto="SELECT iDproducto, nombre_producto, imagen FROM productos WHERE idProducto=?";
$stmt_producto=$conexion->prepare($sql_producto);
$stmt_producto->bind_param('i', $id_producto2);
$stmt_producto->execute();
$stmt_producto->bind_result($idProducto3, $nombre_producto3, $imagen3);
$stmt_producto->fetch();
$stmt_producto->close();

//Cambio de imagen

$cargar=''; $resultado=false;
	$nombre = $_FILES['imagen']['name'];
	$nombrer = strtolower($nombre);
//determino que el archivo que se ha subido no tenga mas de una extencion
 $extenciones=substr_count($nombrer, ".");

if($nombre!='' || $nombre != false){
	
if($extenciones==1 && ($_FILES["imagen"]["size"] < 10000000)){
	$rand=RandomString();
	########################Inicio de los otros formatos #########################################
	//crearMiniatura($rand, $_FILES['imagen']['name']);
	

if ($nombre_archivo2=crearMiniatura($rand, $_FILES['imagen']['name'])){
	$stmt=$conexion->prepare("UPDATE productos SET imagen=? WHERE idProducto=?");
	$stmt->bind_param('si', $nombre_archivo2, $id_producto2);
	$stmt->execute();
	$stmt->close();
	
	//Borro la imagen que habia antes
	unlink("img/$imagen3");
	unlink("img/miniaturas/$imagen3");
	 
	}
		//header('Location: publicar.php');
}	
	
}
header('Location: listado_productos');
	
	
}

$titulo='';
if(isset($_GET['idSubdepartamento']) && is_numeric($_GET['idSubdepartamento'])){
	$idSubdepartamento=test_entrada($_GET['idSubdepartamento']);
	//Busco los registros de este subdepartamento
	$sql_prod="SELECT idProducto, idDepartamento, idSubdepartamento, nombre_producto, precio, unidad, descripcion, imagen, estado, cantidad, promocion FROM productos WHERE idSubdepartamento=$idSubdepartamento ORDER BY nombre_producto";
	$b_productos=mysqli_query($conexion, $sql_prod);
	$row_prod=mysqli_fetch_assoc($b_productos);
	$titulo='Productos de '.test_entrada($_GET['sub']);
}
elseif(isset($_GET['idSubdepartamento']) && !is_numeric($_GET['idSubdepartamento'])){
	echo "<script type='text/javascript'>
	alert('Enlace corrupto');
	window.location='subdepartamentos';
	</script>";
}
else{
	//Busco los registros de todos los productos del inventario
	//$idSubdepartamento=test_entrada($_GET['idSubdepartamento']);
	//Busco los registros de este subdepartamento
	/*$sql_prod="SELECT idProducto, idDepartamento, idSubdepartamento, nombre_producto, precio, unidad, porcentaje, descripcion, imagen, estado, cantidad, promocion FROM productos ORDER BY nombre_producto";
	$b_productos=mysqli_query($conexion, $sql_prod);
	$row_prod=mysqli_fetch_assoc($b_productos);*/
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
<h2>Editar producto</h2>
<form name="editar" id="editar" method="post" enctype="multipart/form-data">
 <div class="form-group">
    <label for="nombre producto">Nombre del producto*</label>
    <input name="nombre_producto2" type="text" required class="form-control" placeholder="Ingrese nombre del producto" value="<?php echo $row_prod['nombre_producto']; ?>">
  </div>
  
  <div class="form-group">
    <label for="Precio">Precio*</label>
    <input type="text" name="precio2" class="form-control" required value="<?php echo $row_prod['precio']; ?>">
  </div>
  
  <div class="form-group">
    <label for="Unidad">Unidad*</label>
    <input name="unidad2" type="text" required class="form-control" placeholder="Ej: libra, kilo, par, unidad" value="<?php echo $row_prod['unidad']; ?>">
  </div>
			  
			   <div class="form-group">
    <label for="Unidad">Porcentaje *</label>
    <input name="porcentaje2" type="text" required class="form-control" placeholder="Ej: 10" value="<?php echo $row_prod['porcentaje']; ?>">
  </div>

<div class="form-group">
    <label for="descripcion">Descripcion</label>
    <textarea name="descripcion2" required class="form-control" placeholder="Ingrese los detalles del producto como presentacion, procedencia, marca etc"><?php echo $row_prod['descripcion']; ?></textarea>
  </div>
  
  
  <div class="form-group">
<label for="Promocion">Promocion*</label>
<select name="promocion2" required class="form-control" id="promocion">
<option value="<?php echo $row_prod['promocion']; ?>">Dejar igual</option>
<option value="1">Si</option>
<option value="0">No</option>
</select>
</div>
			  
			   <div class="form-group">
<label for="Disponible">Disponible</label>
<select name="disponible2" required class="form-control" id="disponible2" required>
<option value="<?php echo $row_prod['estado']; ?>">Dejar igual</option>
<option value="1">Disponible</option>
<option value="0">No disponible</option>
</select>
</div>
  
  <!--<div class="form-group">
  <label for="imagen">Seleccione la imagen del producto</label>
  <input type="file" name="imagen" class="form-control" accept="image/jpeg, image/jpg, image/png, image/gif" lang="es">
  </div>-->
  

			  <div class="form-group">
  <input type="file"  name="imagen" class="form-control" accept="image/jpeg, image/jpg, image/png, image/gif" lang="es">
  <label  for="customFile">Cargar una foto del producto</label>
</div>
			  
			  
  <div class="form-group">
  <input type="submit" value="Editar" class="btn btn-success">
	  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
	  <input type="hidden" name="idProducto2" value="<?php echo $row_prod['idProducto']; ?>">
  <!--<input type="hidden" name="nombre_departamento" id="nombre_departamento">
  <input type="hidden" name="nombre_subdepartamento" id="nombre_subdepartamento">-->
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