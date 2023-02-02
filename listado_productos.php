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
	$sql_prod="SELECT idProducto, idDepartamento, idSubdepartamento, nombre_producto, precio, unidad, porcentaje, descripcion, imagen, estado, cantidad, promocion FROM productos ORDER BY nombre_producto";
	$b_productos=mysqli_query($conexion, $sql_prod);
	$row_prod=mysqli_fetch_assoc($b_productos);
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
	function agotado(idProducto, contador){
		var xmlhttp;
		var cantidad=prompt('Ingrese la cantidad existente');
		
		
		if(idProducto==""){
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
				//subtotal=cantidad*costo;
				//subtotal=new Intl.NumberFormat().format(subtotal);
				//document.getElementById("total").innerHTML=xmlhttp.responseText;
				document.getElementById("agotado"+contador).innerHTML="Agotado";
				
			}
		 }
		
		xmlhttp.open("GET", "actualizar_productos.php?idProducto="+idProducto+"&contador="+contador+"&cantidad="+cantidad, true);
		xmlhttp.send();
		
		
	}
	</script>
	<script type="text/javascript">
	function editarr(idProducto, nombre_producto, precio, unidad, porcentaje, descripcion, promocion){
		
		document.editar.idProducto2.value=idProducto;
		document.editar.nombre_producto2.value=nombre_producto;
		document.editar.precio2.value=precio;
		document.editar.unidad2.value=unidad;
		document.editar.porcentaje2.value=porcentaje;
		document.editar.descripcion2.value=descripcion;
		document.editar.promocion2.value=promocion;
		
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
<h1>Listado de productos</h1>
	<div class="table-responsive">
	<form name="productos" method="post">
	<table border="1" class="table table-bordered table-striped table-hover table-sm">
  <tbody>
    <tr align="center" valign="middle" class="thead-dark">
      <th scope="col">ID</th>
      <th scope="col">NOMBRE</th>
      <th scope="col">PRECIO</th>
      <th scope="col">UNIDAD</th>
	  <th scope="col">PORCENTAJE</th>
      <th scope="col">DESCRIPCION</th>
      <th scope="col">EDITAR PRODUCTO</th>
      <!--<th scope="col">AGOTADO</th>-->
    </tr>
	  <?php $contador=1; do{ ?>
	  <tr align="center" valign="middle">
	  <td><a href="editar_producto2.php?idProducto=<?php echo $row_prod['idProducto']; ?>" title="Click aquí para cambiar el departamento"><?php echo $row_prod['idProducto']; $idProducto=$row_prod['idProducto']; $ver=''; $comentario=''; if(($row_prod['estado'] == 0 || $row_prod['cantidad']>0) ||($row_prod['estado'] == 0 &&$row_prod['cantidad']==0 )){ $ver = 'nover'; $comentario='Agotado';} ?></a></td>
		  
		  <td><a href="editar_producto2.php?idProducto=<?php echo $row_prod['idProducto']; ?>" title="Clic aquí para cambiar el departamento sin cambiar la imagen"><?php echo $row_prod['nombre_producto']; $nombre_producto=$row_prod['nombre_producto']; ?></a></td>
		  <td><?php echo $row_prod['precio']; $precio=$row_prod['precio']; ?></td>
		  <td><?php echo $row_prod['unidad']; $unidad=$row_prod['unidad'];  ?></td>
		  <TD><?php echo $row_prod['porcentaje']; $porcentaje=$row_prod['porcentaje']; ?></TD>
		  <td><?php echo $row_prod['descripcion']; $descripcion=$row_prod['descripcion']; $promocion=$row_prod['promocion']; ?></td>
		  <td><a href="editar_producto.php?id_producto=<?php echo $row_prod['idProducto']; ?>" class="btn btn-primary btn-sm">Editar</a><!--<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal" onClick="editarr(<?php echo $idProducto; ?>, '<?php echo $nombre_producto; ?>', <?php echo $precio ?>, '<?php echo $unidad; ?>', <?php echo $porcentaje; ?>, '<?php echo $descripcion; ?>', <?php echo $promocion; ?>)">
  Editar</button>--></td>
		  <!--<td id="agotado<?php echo $contador; ?>"><input type="checkbox" name="idProducto<?php echo $row_prod['idProducto']; ?>" class="form-control <?php echo $ver; ?>" onClick="agotado(<?php echo $row_prod['idProducto']; ?>, <?php echo $contador; ?>)" ><?php echo $comentario; ?></td>-->
	  </tr>
	  <?php $contador++; } while($row_prod=mysqli_fetch_assoc($b_productos)); ?>
  </tbody>
</table>
		</form>

	</div>
</div>
</div>
	
	<div class="row">
	<div class="col-md-12">
		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar producto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
		  
		  
		  <form name="editar" id="editar" method="post" enctype="multipart/form-data">
 <div class="form-group">
    <label for="nombre producto">Nombre del producto*</label>
    <input name="nombre_producto2" type="text" required class="form-control" placeholder="Ingrese nombre del producto">
  </div>
  
  <div class="form-group">
    <label for="Precio">Precio*</label>
    <input type="text" name="precio2" class="form-control" required>
  </div>
  
  <div class="form-group">
    <label for="Unidad">Unidad*</label>
    <input name="unidad2" type="text" required class="form-control" placeholder="Ej: libra, kilo, par, unidad">
  </div>
			  
			   <div class="form-group">
    <label for="Unidad">Porcentaje *</label>
    <input name="porcentaje2" type="text" required class="form-control" placeholder="Ej: 10">
  </div>

<div class="form-group">
    <label for="descripcion">Descripcion</label>
    <textarea name="descripcion2" required class="form-control" placeholder="Ingrese los detalles del producto como presentacion, procedencia, marca etc"></textarea>
  </div>
  
  
  <div class="form-group">
<label for="Promocion">Promocion*</label>
<select name="promocion2" required class="form-control" id="promocion">
<option value="">Ninguno</option>
<option value="1">Si</option>
<option value="0">No</option>
</select>
</div>
			  
			   <div class="form-group">
<label for="Disponible">Disponible</label>
<select name="disponible2" required class="form-control" id="disponible2" required>
<option value="">Ninguno</option>
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
	  <input type="hidden" name="idProducto2">
  <!--<input type="hidden" name="nombre_departamento" id="nombre_departamento">
  <input type="hidden" name="nombre_subdepartamento" id="nombre_subdepartamento">-->
  </div>
  

</form>

	
      </div>
      <!--<div class="modal-footer">
        
        <button type="button" class="btn btn-primary">Guardar</button>
      </div>-->
    </div>
  </div>
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