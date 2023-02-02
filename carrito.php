<!--https://api.whatsapp.com/send?phone=+573147417810&text=su%20pedido%20ha%20sido%20recibido%20satisfactoriamente-->

<!--https://yoursite.com/path/to/script/yourscript.php?text=Hello&phone=70123456789-->
<?php 
require('conexion/conexion.php');
require('conexion/acceso.php');
include('crear_cookie.php');
include('escape.php');
@session_start();
$cedula=$_SESSION['usuario'];
$nombre=$_SESSION['nombre_usuario'];
//Busco el cliente para ver si está registrado
$buscar_cliente=@mysqli_query($conexion, "SELECT * FROM clientes WHERE cedula='$cedula'");
$row_elcliente=@mysqli_fetch_assoc($buscar_cliente);
$telefono=@$row_elcliente['telefono'];
$obs=@$row_elcliente['observacion'];
$url=$_SERVER['PHP_SELF'];
if($_COOKIE['Invitado'] == ''){
	header('Location: '.$url);
	}
$idCliente='';
//Codigo para registrar el pedido
if(isset($_POST['cedula_cliente']) && $_POST['cedula_cliente'] !=''){
	$id_sector=test_entrada($_POST['id_sector']);
	$cedula_cliente=test_entrada($_POST['cedula_cliente']);
	$nombre_cliente=test_entrada($_POST['nombre_cliente']);
	$telefono_cliente=test_entrada($_POST['telefono_cliente']);
	$invitado=$_COOKIE['Invitado'];
	$fecha=date('Y-m-d');
	$estado=0;
	$observacion=test_entrada($_POST['observacion']);
	session_start();
	if($_SESSION['id_usuario']>0 || $_SESSION['id_usuario']!=''){
		$id_usuario=$_SESSION['id_usuario'];
	}
	
	//Determino si el cliente ya se encuentra registrado, de lo contrario lo registro
	$b_cliente=mysqli_query($conexion, "SELECT idCliente FROM clientes WHERE cedula='$cedula_cliente'");
	$row_cliente=mysqli_fetch_assoc($b_cliente);
	if(@$row_cliente['idCliente']==''){ 
		//Registro el cliente
		$sql="INSERT INTO clientes (cedula, nombre, telefono, observacion) VALUES (?,?,?,?)";
		$stmt=$conexion->prepare($sql);
		$stmt->bind_param('ssss',$cedula_cliente, $nombre_cliente, $telefono_cliente, $observacion);
		$stmt->execute();
		$stmt->close();
		//Busco el cliente para encontrar el id del cliente
		$b_cliente2=mysqli_query($conexion, "SELECT idCliente FROM clientes WHERE cedula='$cedula_cliente'");
	$row_cliente2=mysqli_fetch_assoc($b_cliente2);
		$idCliente=$row_cliente2['idCliente'];
	}else{
		//Actualizo los datos del cliente
		$sql_upd="UPDATE clientes SET nombre=?, telefono=?, observacion=? WHERE cedula=?";
		$stmt_upd=$conexion->prepare($sql_upd);
		$stmt_upd->bind_param('ssss',$nombre_cliente, $telefono_cliente, $observacion, $cedula_cliente);
		$stmt_upd->execute();
		$stmt_upd->close();
		$b_cliente2=mysqli_query($conexion, "SELECT idCliente FROM clientes WHERE cedula='$cedula_cliente'");
	$row_cliente2=mysqli_fetch_assoc($b_cliente2);
		$idCliente=$row_cliente2['idCliente'];
	}
	
	
	
	##########################################-------------------######################################
	
	
	
	//Registro el pedido nota: arreglar esto en base a la tabla de pedidos que se modifico
	$sql_pedido="INSERT INTO pedidos (id_usuario, idCliente, invitado, fecha, estado, id_sector, observacion) VALUES (?,?,?,?,?,?,?)";
	$stmt_pedido=$conexion->prepare($sql_pedido);
	$stmt_pedido->bind_param('iissiis',$id_usuario, $idCliente, $invitado, $fecha, $estado, $id_sector, $observacion);
	$stmt_pedido->execute();
	$stmt_pedido->close();
	
	//Busco el juego de registros del ultimo pedido que acabo de crear
	$b_pedido=mysqli_query($conexion, "SELECT idPedido FROM pedidos ORDER BY idPedido DESC LIMIT 1");
	$row_pedido=mysqli_fetch_assoc($b_pedido);
	$idPedido=$row_pedido['idPedido'];
	
	
	//Actualizo la tabla de carrito para poner la cedula donde es el invitado
	$sql_act="UPDATE carrito SET idPedido=?, idCliente=?, estado=? WHERE invitado=?";
	$stmt_act=$conexion->prepare($sql_act);
	$stmt_act->bind_param('iiis',$idPedido, $idCliente, $estado, $invitado);
	$stmt_act->execute();
	$stmt_act->close();
	setcookie("Invitado","",time()-3600);
	echo "<script type='text/javascript'>
	alert('Su pedido ha sido enviado satisfactoriamente');
	window.location='index.php'
	</script>";
}




$invitado=test_entrada($_COOKIE['Invitado']);
//Codigo para los productos en el carrito
$b_carrito=mysqli_query($conexion, "SELECT id_registro, idProducto, fecha, invitado, cantidad, precio_costo, estado FROM carrito WHERE idCliente IS  NULL AND invitado='$invitado'");
$row_carrito=mysqli_fetch_assoc($b_carrito);

$ver='';
if(@$row_carrito['id_registro'] == ''){
	$ver='nover';
}

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

//Determino si el usuario ya inicio sesion
//session_start();
if(@$_SESSION['id_usuario']!=''){
	$b_clientes=mysqli_query($conexion, "SELECT * FROM clientes");
	$row_clientes=mysqli_fetch_assoc($b_clientes);
	
}
//Juego de registros de los sectores
$b_sectores=mysqli_query($conexion, "SELECT * FROM sectores JOIN ciudades ON sectores.id_ciudad=ciudades.id_ciudad ORDER BY nombre_sector");
$row_sectores=mysqli_fetch_assoc($b_sectores);
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
	<script type="text/javascript">
	function comprobar(){
		var xmlhttp;
		var cedula_cliente=document.enviar.cedula_cliente.value;
		if(cedula_cliente==""){
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
				/*subtotal=cantidad*costo;
				subtotal=new Intl.NumberFormat().format(subtotal);*/
				document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
				//document.getElementById("subtotal"+contador).innerHTML=subtotal;
				
				
			}
		 }
		
		
		xmlhttp.open("GET", "ajx_buscar_saldo.php?cedula_cliente="+cedula_cliente, true);
		xmlhttp.send();
		
		
	}



function actualizar(id_registro, cantidad, costo, contador, invitado){
	var xmlhttp;
		
		if(id_registro==""){
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
				subtotal=cantidad*costo;
				subtotal=new Intl.NumberFormat().format(subtotal);
				document.getElementById("txtHint").innerHTML="";
				document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
				document.getElementById("subtotal"+contador).innerHTML=subtotal;
				
				
			}
		 }
		
		
		xmlhttp.open("GET", "ajx_actualizar_carrito.php?id_registro="+id_registro+"&cantidad="+cantidad+"&invitado="+invitado, true);
		xmlhttp.send();
}


	</script>
</head>

<body>
	<datalist id="clientes">
		<?php do{ ?>
	<option value="<?php echo @$row_clientes['cedula']; ?>"><?php echo @$row_clientes['nombre']; ?></option>
		<?php } while(@$row_clientes=mysqli_fetch_assoc($b_clientes)); ?>
	</datalist>
	<datalist id="sectores">
		<?php do{ ?>
			<option value="<?php echo $row_sectores['id_sector']; ?>"><?php echo $row_sectores['nombre_ciudad']." - ".$row_sectores['nombre_sector']; ?></option>

			<?php }while($row_sectores=mysqli_fetch_assoc($b_sectores)); ?>
	</datalist>
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
     
    </div><div class="col-md-1" align="center"><a href="carrito"><img src="img/sistema/carrito.png" width="70" height="60" /></a>
	<div align="center"><span class="carro" id="carro"><?php echo $filas2; ?></div>	</div>
  </div>
  
	
	<div class="row">
	
<div class="col-sm-12"><br><br>
<h1>Carrito de  &nbsp;<?php echo @$_SESSION['nombre_usuario']; ?></h1>
</div>
</div>
	<div class="row">
	
	<div class="col-sm-2">
		<!--Ingresamos el segundo menú-->
			
			<?php include('menu_lateral.php'); ?>
		
		</div>
	
	
<div class="col-sm-10"><br>
<br>
	<?php  $ver='';  $filas=@$row_carrito['id_registro']; if($filas==0 || $filas==''){
	$ver='nover';
} ?>
	<div class="table-responsive">
		<form name="form-carro" method="post">
	<table border="1" class="table table-bordered table-striped table-hover table-sm <?php echo $ver; ?>">
  <tbody>
    <tr class="thead-dark">
      <th scope="col">Imagen</th>
      <th scope="col">Producto</th>
      <th scope="col">Cant.</th>
      <th scope="col">Precio</th>
      <th scope="col">Subt.</th>
      <th scope="col">Quitar</th>
    </tr>
	  <?php $subtotal=0; $total=0; $contador=1; do { ?>
	  <tr align="center" valign="middle">
		  <?php $idProducto=@$row_carrito['idProducto'];
		  $b_prod=mysqli_query($conexion, "SELECT nombre_producto, imagen FROM productos WHERE idProducto=$idProducto LIMIT 1");
				$row_prod=@mysqli_fetch_assoc($b_prod);
		  ?>
	  <td><img src="img/miniaturas/<?php echo $row_prod['imagen']; ?>" width="45" height="45" /></td>
		  <td><?php echo $row_prod['nombre_producto']; ?></td>
		  <td><input type="text" name="cantidad<?php echo $contador; ?>" value="<?php echo $row_carrito['cantidad']; ?>" class="form-control" required  onkeyup="actualizar(<?php echo $row_carrito['id_registro']; ?>, this.value, <?php echo $row_carrito['precio_costo']; ?>, <?php echo $contador; ?>, '<?php echo $invitado; ?>')" autocomplete="off" size="3"></td>
		  <td><?php echo number_format($row_carrito['precio_costo']); $subtotal=$row_carrito['cantidad']*$row_carrito['precio_costo']; ?></td>
		  <td id="subtotal<?php echo $contador; ?>"><?php echo number_format($subtotal); $total=$total+$subtotal; ?></td>
		  <td><a href="quitar_carrito.php?reg=<?php echo $row_carrito['id_registro']; ?>" class="btn btn-danger btn-sm">Quitar</a></td>
	  </tr>
	  <?php $contador++; }while($row_carrito=@mysqli_fetch_assoc($b_carrito)); ?>
	  <h3 class="total" id="txtHint">Total de la compra: $<?php echo number_format($total,2); ?></h3>
  </tbody>
</table>
			</form>

	</div>
	<button type="button" class="btn btn-dark <?php echo $ver; ?>" data-toggle="modal" data-target="#exampleModal">
  <b>Enviar pedido</b>
</button><br><br>
	
	
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Llene los campos para recibir su pedido</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
		  <form name="enviar" method="post">
		  <div class="form-group">
			  <label for="cedula_cliente">Número de cédula del cliente: *</label>
			  <input type="text" name="cedula_cliente" class="form-control" required placeholder="Ingrese su numero de cedula" list="clientes" autocomplete="off" onChange="comprobar()" value="<?php echo $cedula; ?>">
			  </div>
			  <div class="form-group" id="txtHintt" style="background-color: #F9060A; border-radius: 3px; padding-left: 5px;"></div>
			  
			  <div class="form-group">
			  <label for="nombre_cliente">Nombre completo del cliente: *</label>
			  <input type="text" name="nombre_cliente" class="form-control" required placeholder="Ingrese su nombre completo" autocomplete="off" value="<?php echo $nombre; ?>">
			  </div>
			  
			  <div class="form-group">
			  <label for="telefono_cliente">Telefono: *</label>
			  <input type="text" name="telefono_cliente" class="form-control" required placeholder="Ingrese su número de telefono" autocomplete="off" value="<?php echo $telefono; ?>">
			  </div>
			  
			  <div class="form-group">
			  <label for="observacion">Observacion, direccion y/o órden de compra: </label>
			  <textarea name="observacion" rows="4" class="form-control" placeholder="Ingrese la informacion adicional que considere necesaria para la entrega, como horario, nombre de la calle, preguntar por, nro de puerta, orden de compra, etc" required><?php echo $obs; ?></textarea>
			  </div>

			  <div class="form-group">
			  <label for="id_sector"> </label>
			  <input type="hidden" name="id_sector" class="form-control" required placeholder="Elija el sector" list="sectores" value="1">
			  </div>
			  
			  <div class="form-group">
			  <label for="contrato"><b><dfn title="Acepto que el supermercado el tesoro use mis datos para contactarme y enviar los pedidos que quega de hoy en adelante">Acepto manejo de datos *</dfn></b></label>
			  <input type="checkbox" name="acepto" class="form-control" required>
			  </div>
			  
			  
			  <button type="submit" class="btn btn-primary">Enviar</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
		  </form>
		  
		  
      </div>
     <!-- <div class="modal-footer">
        
        
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