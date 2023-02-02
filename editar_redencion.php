<?php 
require('conexion/conexion.php');
require('conexion/acceso.php');
include('escape.php');
$nivel=$_SESSION['nivel'];
$id_beneficiario='';
if($nivel<3){
	echo "<script type='text/javascript'>
	alert('Usted no tiene permiso para visualizar este archivo');
	window.location='index.php';
	</script>";
}
$comentario='';
$estado=0; $total=0;
//Determino si recibo el parametro de la redencion
if(isset($_GET['id_redencion']) && is_numeric($_GET['id_redencion'])){
    $id_redencion=test_entrada($_GET['id_redencion']);
    //Busco el juego de registro de la redencion
    $buscar_nuevoss=mysqli_query($conexion, "SELECT * FROM redenciones JOIN usuarios ON redenciones.id_usuario=usuarios.id_usuario JOIN premios ON redenciones.id_producto=premios.id_premio WHERE redenciones.id_redencion=$id_redencion");
$row_redencioness=mysqli_fetch_array($buscar_nuevoss);
$total=$row_redencioness['total'];
$id_beneficiario=$row_redencioness[8];
if($row_redencioness[6]==0){$comentario='No entregado';}
else{
    $comentario='Entregado';
    $estado=$row_redencioness['estado'];
}
}

//Codigo par editar la redencion
if(isset($_POST['id_redencion']) && is_numeric($_POST['id_redencion'])){
    $id_redencion=test_entrada($_POST['id_redencion']);
    $estado=test_entrada($_POST['estado']);
    $observacion=test_entrada($_POST['observacion']);
    

    $sql="UPDATE redenciones SET estado=?, observacion=? WHERE id_redencion=?";
    $stmt=$conexion->prepare($sql);
    $stmt->bind_param('isi', $estado, $observacion, $id_redencion);
    $stmt->execute();
    $stmt->close();
    $fecha=date('Y-m-d'); $hora=date('H:i:s');
    //Determino si el estado es despachado para registrar el abono
    if($estado==1){
        $sql="INSERT INTO abono_comision (id_usuario, fecha, hora, total, observacion) VALUES (?,?,?,?,?)";
	$stmt=$conexion->prepare($sql);
	$stmt->bind_param('issds', $id_beneficiario, $fecha, $hora, $total, $observacion);
	$stmt->execute();
	$stmt->close();
    }
    header('Location: historial_premios_entregados');
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
<h2>Edicion y despacho de premios <?php echo $id_beneficiario; ?></h2>
<b>Solicitud de <?php echo $row_redencioness['nombre_usuario']."  ".$row_redencioness['nombre_premio']; ?></b><br><br><br>
<h4><?php echo $row_redencioness['nombre_premio']; ?></h4>
<form name="edicion" method="POST">
    <div class="form-group">
        <label for="observacion">Observacion</label>
        <textarea name="observacion" class="form-control" placeholder="Escriba aqui cualquier observacion sobre la entrega de este premio"><?php echo $row_redencioness['observacion'] ?></textarea>
    </div>
    <div class="form-group">
        <Label for="estado">Estado</Label>
        <select name="estado" class="form-control" required>
            <option value="<?php echo $estado; ?>"><?php echo $comentario; ?></option>
            <option value="0">No entregado</option>
            <option value="1">Entregado</option>
        </select>
    </div>
    <div class="form-group">
        
        <input type="submit" value="Enviar" class="btn btn-primary" />
    </div>
    <input type="hidden" name="id_redencion" value="<?php echo $id_redencion; ?>" />
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