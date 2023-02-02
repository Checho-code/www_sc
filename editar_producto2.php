<?php 
require('conexion/conexion.php');
require('conexion/acceso.php');
include('escape.php');

if(isset($_POST['nombre_producto']) && $_POST['nombre_producto'] != ''){
	
	$nombre_producto=test_entrada($_POST['nombre_producto']);
	$precio=test_entrada($_POST['precio']);
	$descripcion=test_entrada($_POST['descripcion']);
	$estado=1; $promocion=test_entrada($_POST['promocion']);
	$idDepartamento=test_entrada($_POST['idDepartamento']);
	$idSubdepartamento=test_entrada($_POST['idSubdepartamento']);
	$unidad=test_entrada($_POST['unidad']);
	$idProducto=test_entrada($_POST['idProducto']);
	
	
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
	
	//Actualizo los datos del producto
	$stmt=$conexion->prepare("UPDATE productos SET idDepartamento=?, idSubdepartamento=?, nombre_producto=?, precio=?, unidad=?, descripcion=?, estado=?, promocion=? WHERE idProducto=?");
	$stmt->bind_param('iisdssiii', $idDepartamento, $idSubdepartamento, $nombre_producto, $precio, $unidad, $descripcion, $estado, $promocion, $idProducto);
	$stmt->execute();
	$stmt->close();
	header('Location: publicacion_basica.php');
	
	
}

//Busco el registro del producto pasado por el parametro
if(isset($_GET['idProducto']) && is_numeric($_GET['idProducto'])){
	$idProducto=test_entrada($_GET['idProducto']);
	$b_producto=mysqli_query($conexion, "SELECT * FROM productos WHERE idProducto=$idProducto");
	$row_producto=mysqli_fetch_assoc($b_producto);
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
	<div class="col-md-12"><!--INICIO DEL MENU-->
    
	<?php 
		
		include('menuPrincipal.php');	
				
		?>	
     
    </div>
  </div>
	
	<div class="row">
<div class="col-md-12">
	<div align="center">
	<img src="img/miniaturas/<?php echo $row_producto['imagen'] ?>" width="200" height="200" class="img-thumbnail" />
	</div>
	
	<div class="table-responsive">
	<form name="publicar" id="publicar" method="post">
<h2>Datos del producto <?php echo $row_producto['nombre_producto']; ?></h2>
  
<table border="1" class="table table-bordered table-striped table-hover table-sm">
  <tbody>
    <tr>
      <th scope="col"><div class="form-group">
<label for="idDepartamento">Departamento*</label>
<select name="idDepartamento" id="idDepartamento" class="form-control" onChange="showselect(this.value) " required>
<option value="">Ninguno</option>
<option value="0">Nuevo</option>
<?php include('ajx_subdepartamentos.php'); ?>
</select>
</div></th>
      <th scope="col"><div class="form-group">
    <label for="Precio">Precio*</label>
    <input type="text" name="precio" class="form-control" required value="<?php echo $row_producto['precio']; ?>">
  </div></th>
    </tr>
    <tr>
      <td><div class="form-group" id="cliente">



</div></td>
      <td><div class="form-group">
    <label for="Unidad">Unidad*</label>
    <input name="unidad" type="text" required class="form-control" placeholder="Ej: libra, kilo, par, unidad" value="<?php echo $row_producto['unidad']; ?>">
  </div></td>
    </tr>
    <tr>
      <td><div class="form-group">
    <label for="nombre producto">Nombre del producto*</label>
    <input name="nombre_producto" type="text" required class="form-control" placeholder="Ingrese nombre del producto" value="<?php echo $row_producto['nombre_producto']; ?>">
  </div></td>
      <td><div class="form-group">
    <label for="descripcion">Descripcion</label>
    <textarea name="descripcion" required class="form-control" placeholder="Ingrese los detalles del producto como presentacion, procedencia, marca etc"> <?php echo $row_producto['descripcion']; ?> </textarea>
  </div></td>
    </tr>
    <tr>
      <td><div class="form-group">
<label for="Promocion">Promocion*</label>
<select name="promocion" required class="form-control" id="promocion">
<option value="<?php echo $row_producto['promocion']; $valor='Si'; if($row_producto['promocion']==0){$valor='No';} ?>"><?php echo $valor; ?></option>    

<option value="1">Si</option>
<option value="0">No</option>
</select>
</div></td>
      <td>
		<!--  <div class="form-group">
  <label for="imagen">Seleccione la imagen del producto</label>
  <input type="file" name="imagen" class="form-control" accept="image/jpeg, image/jpg, image/png, image/gif" lang="es">
  </div>--></td>
    </tr>
	  
	  <tr>
      <td colspan="2"><div class="form-group">
  <input type="submit" value="Actualizar" class="btn btn-dark">
  <input type="hidden" name="nombre_departamento" id="nombre_departamento">
  <input type="hidden" name="nombre_subdepartamento" id="nombre_subdepartamento">
  <input type="hidden" name="idProducto" id="idProducto" value="<?php echo $row_producto['idProducto']; ?>">
      </div></td>
     
    </tr>
  </tbody>
</table>
  
  

</form>

	

	
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