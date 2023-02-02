<?php 
require('conexion/conexion.php');
require('conexion/acceso.php');
include('escape.php');

//Juego de registros para las solicitudes de remision
//Busco los pedidos que hay nuevos
$ped='';
$buscar_nuevoss=mysqli_query($conexion, "SELECT * FROM redenciones JOIN usuarios ON redenciones.id_usuario=usuarios.id_usuario JOIN premios ON redenciones.id_producto=premios.id_premio WHERE redenciones.estado=0 ORDER BY redenciones.id_redencion DESC");
$row_redencioness=mysqli_fetch_array($buscar_nuevoss);
//$ped=mysqli_num_rows($buscar_nuevos);

?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="robots" content="noindex">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="Cache-Control" content="no-cache" />
<meta http-equiv="Pragma" content="no-cache" />

<title>Frutos del campo</title>

<link rel="stylesheet" type="text/css" href="css/mi_estilo.css" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
    <script type="text/javascript">
        function confirmacion(id_redencion){
            if(confirm('Seguro que desea eliminar esta solicitud?')){
                window.location='eliminar_redencion.php?id_redencion='+id_redencion;
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
<h2>Solicitudes de premios</h2>
<div class="table-responsive">
<table class=" table table-bordered table-striped table-hover table-sm">
    <tbody>
        <tr>
            <th>Id</th>
            <th>Usuario</th>
            <th>Producto</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Total</th>
            <th>Estado</th>
            <th>Observacion</th>
            <th>Despachar</th>
            <th>Eliminar</th>
           
        </tr>
        <?php do{ ?>
            <tr>
            <td><?php echo $row_redencioness['id_redencion']; ?></td>
            <td><?php echo $row_redencioness['nombre_usuario']; ?></td>
            <td><?php echo $row_redencioness['nombre_premio']; ?></td>
            <td><?php echo $row_redencioness['fecha']; ?></td>
            <td><?php echo $row_redencioness['hora']; ?></td>
            <td><?php echo number_format($row_redencioness['total']); ?></td>
            <td><?php echo $row_redencioness[6]; ?></td>
            <td><?php echo $row_redencioness['observacion']; ?></td>
            <td><a href="editar_redencion.php?id_redencion=<?php echo $row_redencioness['id_redencion']; ?>" class="btn btn-success btn-sm">Despachar</a></td>
            <td><a href="#" class="btn btn-danger btn-sm" onclick="confirmacion(<?php echo $row_redencioness['id_redencion']; ?>)">Eliminar</a></td>
            </tr>
            <?php } while($row_redencioness=mysqli_fetch_array($buscar_nuevoss)); ?>
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