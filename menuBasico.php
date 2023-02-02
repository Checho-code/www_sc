<?php
require('conexion/conexion.php');
//include('escape.php');
//determino si hay una sesion iniciada para mostrar la foto
//session_start();

//Buscamos la cantidad de elementos que tiene el carrito
	$b_carrito2=@mysqli_query($conexion, "SELECT id_registro FROM carrito WHERE idCliente IS NULL AND invitado='$invitado'");
	$row_carrito2=@mysqli_fetch_assoc($b_carrito2);
	$filas2=@mysqli_num_rows($b_carrito2);


$ver= 'nover'; $contenido="Ingresar";
$pag="login";
$puntos=0;
if(isset($_SESSION['nombre_usuario']) && $_SESSION['nombre_usuario'] != ''){
	$id_usuario=$_SESSION['id_usuario']; $contenido="Salir"; $pag="desconectar";
	$ver='';
	//Busco el usuario que esta logueado
	$sql_usuario="SELECT correo_usuario, nombre_usuario, nivel FROM usuarios WHERE correo_usuario = ?";
	$stmt_usuario=$conexion->prepare($sql_usuario);
	$stmt_usuario->bind_param('s', $_SESSION['usuario']);
	$stmt_usuario->execute();
	$stmt_usuario->bind_result($correo1, $nombre_usuario1, $nivel1);
	$stmt_usuario->fetch();
	$stmt_usuario->close();
	
	//Actualizo los productos del carrito que tengan el idUsuario vacio y pertenezcan a este invitado
	//mysqli_query($conexion, "UPDATE carrito SET id_usuario=$id_usuario  WHERE invitado='$invitado'");
	
	//Busco todo lo que hay en el carrito de este usuario
	$b_puntos=mysqli_query($conexion, "SELECT porcentaje FROM carrito WHERE id_usuario=$id_usuario AND estado=1");
	
	while($row_puntos=mysqli_fetch_assoc($b_puntos)){
		$puntos+=$row_puntos['porcentaje'];
	}
	//Busco los abonos que se ha hecho a esos puntos
	$b_abonos=mysqli_query($conexion, "SELECT SUM(total) AS total_abonos FROM abono_comision WHERE id_usuario=$id_usuario");
	$row_abonos=mysqli_fetch_assoc($b_abonos);
	$total_abonos=$row_abonos['total_abonos'];
	$puntos=$puntos-$total_abonos;

	}
	
	
 ?>

<nav class="navbar navbar-expand-lg navbar-dark bg-success">
  <a class="navbar-brand <?php echo $ver; ?>" href="#"><!--<img src="img/miniaturas/<?php echo $imagen1; ?>" width="40" height="45" />--></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index">Inicio <span class="sr-only">(current)</span></a>
      </li>
		
      <li class="nav-item">
        <a class="nav-link" href="carrito">Carrito<?php echo @$filas2; ?></span></a>
       </li>
		
	   <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         Nosotros
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
			
        <a class="dropdown-item" href="noticias"><dfn title="">Noticias</dfn></a>
			 <!--<a class="dropdown-item" href="buscar_vendedor.php"><dfn title="Buscar informacion sobre un vendedor y el historial de sus ventas">Buscar</dfn></a>-->
			<!--<div class="dropdown-divider"></div>-->
          
        </div>
      </li>

	  <li class="nav-item">
        <a class="nav-link" href="solcomercial.apk">Descargas</span></a>
       </li>
		
		
       
      
      <!--<li class="nav-item">
        <a class="nav-link" href="<?php echo $pag; ?>"><?php echo $contenido; ?></a>
      </li>-->
	  <li class="nav-item">
        <a class="nav-link" href="redimir">Puntos: <?php echo number_format($puntos); ?></span></a>
       </li>

	  <li class="nav-item">
        <a class="nav-link" href="#"><?php echo @$_SESSION['nombre_usuario']; ?></span></a>
       </li>
	   <li class="nav-item">
        <a class="nav-link" href="<?php echo $pag; ?>"><?php echo $contenido; ?></a>
      </li>

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<!--<li class="nav-item">
		<form name="busqueda" method="post" action="busqueda class="form-inline">
			<input name="buscar" type="search" required class="form-control mr-sm-2" placeholder="Buscar producto" autocomplete="off" aria-label="Search" />
			<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
			</form>
		</li>-->
		
		
    </ul>
    
  </div>
</nav>