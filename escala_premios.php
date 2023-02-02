<?php 
require('conexion/conexion.php');
require('conexion/acceso.php');
include('escape.php');

//Codigo para cargar las imagenes al servidor
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

			//Creo el codigo para registrar el premio
			if(isset($_POST['nombre_premio'])){
				$nombre_premio=test_entrada($_POST['nombre_premio']);
				$puntos=test_entrada($_POST['puntos']);
     
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
	$sql="INSERT INTO premios (nombre_premio, puntos, imagen) VALUES (?,?,?)";
	$stmt=$conexion->prepare($sql);
	$stmt->bind_param('sis', $nombre_premio, $puntos, $nombre_archivo2);
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

			//Juego de registros de los premios creados
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
<h2>Formulario creacion de premios </h2>
<form name="plan_premios" method="POST" enctype="multipart/form-data">
	<div class="form-group">
		<label for="nombre_premio">Nombre del premio *</label>
		<input type="text" name="nombre_premio" required class="form-control" autocomplete="off" placeholder="Nombre del premio a entregar" />
	</div>
	<div class="form-group">
		<label for="puntos">Puntos necesarios *</label>
		<input type="number" name="puntos" class="form-control" required placeholder="Ingrese los puntos que se requieren para ganar el premio" />
	</div>
	<div class="form-group">
  <label for="imagen">Seleccione la imagen del producto</label>
  <input type="file" name="imagen" class="form-control-file" accept="image/jpeg, image/jpg, image/png, image/gif" lang="es">
  </div>
  <div class="form-group">
	<input type="submit" class="btn btn-primary" value="Crear premio" />
  </div>
</form>
</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">
		<table class="table table-bordered table-striped table-hover table-sm">
			<tbody>
				<tr align="center">
					<th>Id</th>
					<th>Premio</th>
					<th>Puntos</th>
					<th>Imagen</th>
					<th>Quitar</th>
				</tr>
				<?php do{ ?>
					<tr align="center">
						<td><?php echo $row_premios['id_premio']; ?></td>
						<td><?php echo $row_premios['nombre_premio']; ?></td>
						<td><?php echo number_format($row_premios['puntos']); ?></td>
						<td><img src="img/miniaturas/<?php echo $row_premios['imagen']; ?>" width="100" height="100" /></td>
						<td>Quitar</td>
					</tr>
					<?php }while($row_premios=mysqli_fetch_assoc($b_premios)); ?>
			</tbody>
		</table>
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