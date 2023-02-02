<?php 
require('conexion/conexion.php');
require('conexion/acceso.php');
include_once('escape.php');

//Codigo para registrar el usuario
//session_start();
$ver='nover';
$nivel=$_SESSION['nivel'];
if($nivel<3){
	header('Location: login.php');
}
$usuario=$_SESSION['id_usuario'];
if($nivel>=3){
	$los_usuarios=mysqli_query($conexion, "SELECT * FROM usuarios");
$row_usuarios=mysqli_fetch_assoc($los_usuarios);
}
else{
	$los_usuarios=mysqli_query($conexion, "SELECT * FROM usuarios WHERE id_usuario=$usuario");
$row_usuarios=mysqli_fetch_assoc($los_usuarios);
}


$ver='nover';
if($row_usuarios['id_usuario'] !=''){
	$ver='';
}

?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<title>Frutos del campo</title>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="css/mi_estilo.css" />
	
	<script type="text/javascript">
	function validar_pass(){
		var clave=document.registrar.clave.value;
		var clave2=document.registrar.clave2.value;
		if(clave!=clave2){
			alert('Las contraseñas no coinciden');
			document.registrar.clave.value='';
			document.registrar.clave2.value='';
			return false;
		}
	}
		function nivelar(){
			var id_municipio=document.registrar.id_municipio.value;
			var nivel=document.registrar.nivel.value;
			if(nivel>1 && id_municipio!=0){
				alert('Para un socio el municipio debe ser 0');
				document.registrar.id_municipio.value=0;
			}
			if(nivel==1 && id_municipio ==0){
				alert('Debe elegir un municipio para el administradpr de sede');
				document.registrar.id_municipio.value='';
			}
			
		}
		function confirmacion(id_usuario){
			var confirmar=confirm('Seguro que desea eliminar este usuario?. Esta accion no se puede deshacer');
			if(confirmar){
				window.location='eliminar_usuario.php?id_usuario='+id_usuario;
			}
		}
	</script>
	<link rel="stylesheet" type="text/css" href="css/mi_css/ocultar_en_pantalla.css" />
</head>

<body>
	<datalist id="municipios">
		<option value="0">Socio</option>
	<option value="<?php echo @$row_municipio['id_municipio']; ?>"><?php echo @$row_municipio['municipio']; ?></option>
		<?php do{ ?>
		<option value="<?php echo $row_municipios['id_municipio']; ?>"><?php echo $row_municipios['municipio']; ?></option>
		<?php } while($row_municipios=mysqli_fetch_assoc($los_municipios)); ?>
	</datalist>
<div class="container-fluid">
<!--primera fila del menú-->
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
<!--Segunda fila-->
<div class="row">
	
	
<div class="col-sm-12">
<h1>Listado de Vendedores </h1>
	
	<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover table-sm <?php echo $ver; ?>">
  <tbody>
    <tr align="center" valign="middle" class="thead-dark">
      <th scope="col">ID</th>
      <th scope="col">Cedula</th>
      <th scope="col">Nombre</th>
      <th scope="col">Pedidos</th>
	  <th scope="col">Puntos</th>
	  <th scope="col"><dfn title="Pagos realizados de las comisiones">Puntos pagados</dfn></th>
	  <th scope="col">Puntos disponibles</th>
	  <th scope="col">Recaudos</th>
	  <th scope="col">Pagado</th>
	  <th scope="col">Saldo recaudos</th>
	  <th scope="col">Fecha registro</th>	
	  <th scope="col">Pagar comisiones</th>
	  <th scope="col">Recibir</th>
    </tr>
	  <?PHP do{ ?>
    <tr align="center" valign="middle">
      <td><?php echo $row_usuarios['id_usuario']; $id_usu=$row_usuarios['id_usuario']; ?></td>
      <td><?php echo $row_usuarios['correo_usuario']; ?></td>
      <td><?php echo $row_usuarios['nombre_usuario']; ?></td>
      <td><a href="ver_pedidos.php?id_usuario=<?php echo $row_usuarios['id_usuario']; ?>" class="btn btn-info btn-sm">Pedidos</a></td>
		<td><?php
			   $porcentaje=0;
			   $b_carro=mysqli_query($conexion, "SELECT * FROM carrito WHERE id_usuario=$id_usu");
			while($row_carro=mysqli_fetch_assoc($b_carro)){
				$porcentaje+=$row_carro['porcentaje'];
			} 
			echo number_format($porcentaje);
			?></td>
		<td><?php $b_pagos=mysqli_query($conexion, "SELECT SUM(total) AS total_suma FROM abono_comision WHERE id_usuario=$id_usu");
			$row_pagos=mysqli_fetch_assoc($b_pagos); 
			
			?><a href="comisiones_pagadas.php?id_usuario=<?php echo $row_usuarios['id_usuario']; ?>"><dfn title="Click para ver todos los pagos de comisiones realizados"><?php echo number_format($row_pagos['total_suma']); ?></dfn></a></td>
		<td><?php echo number_format($porcentaje-$row_pagos['total_suma']); ?></td>
		<td><?php $total_recaudos=0; $abonos_recaudos=0; $saldo_recaudos=0; $pagos=0; $saldo_rec=0; 
			$b_recaudos=mysqli_query($conexion, "SELECT * FROM recaudos WHERE id_usuario=$id_usu");
			   while($row_recaudos=mysqli_fetch_assoc($b_recaudos)){
				   $total_recaudos+=$row_recaudos['total_recaudo'];
				   $abonos_recaudos+=$row_recaudos['abono_recaudo'];
				   $pagos+=$row_recaudos['abono_recaudo'];
			   }
			   echo number_format($total_recaudos);
			?></td>
		<td><a href="ver_recaudos.php?id_usuario=<?php echo $row_usuarios['id_usuario']; ?>"><dfn title="Click para ver todos los recaudos del usuario"><?php echo number_format($pagos); ?></dfn></a></td>
		<td><?php $saldo_rec=$total_recaudos-$pagos; echo number_format($saldo_rec); ?></td>
		<td><?php echo $row_usuarios['fecha_registro']; ?></td>
		<td><a href="pagar_comision.php?id_usuario=<?php echo $row_usuarios['id_usuario']; ?>" class="btn btn-success btn-sm">Pagar comision</a></td>
		<td><a href="recaudar.php?id_usuario=<?php echo $row_usuarios['id_usuario']; ?>" class="btn btn-sm btn-info">Recibir recaudo</a></td>
    </tr>
	  <?php }while($row_usuarios=mysqli_fetch_assoc($los_usuarios)); ?>
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
<?php


mysqli_free_result($los_usuarios);
?>