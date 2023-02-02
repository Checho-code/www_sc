<?php
require('conexion/conexion.php');
require('crear_cookie.php');
//include('escape.php');
//determino si hay una sesion iniciada para mostrar la foto
//session_start();
$puntos=0;
$invitado=$_COOKIE['Invitado'];

//Buscamos la cantidad de elementos que tiene el carrito
	$b_carrito2=@mysqli_query($conexion, "SELECT id_registro FROM carrito WHERE idCliente IS NULL AND invitado='$invitado'");
	$row_carrito2=@mysqli_fetch_assoc($b_carrito2);
	$filas2=@mysqli_num_rows($b_carrito2);
  //@session_start();
  
  

$ver= 'nover';
if(isset($_SESSION['nombre_usuario']) && $_SESSION['nombre_usuario'] != ''){
	$id_usuario=$_SESSION['id_usuario'];
	//Actualizo los productos del carrito que tengan el idUsuario vacio y pertenezcan a este invitado
	mysqli_query($conexion, "UPDATE carrito SET id_usuario=$id_usuario  WHERE invitado='$invitado'");
	$ver='';
	//Busco el usuario que esta logueado
	$sql_usuario="SELECT correo_usuario, nombre_usuario, nivel FROM usuarios WHERE correo_usuario = ?";
	$stmt_usuario=$conexion->prepare($sql_usuario);
	$stmt_usuario->bind_param('s', $_SESSION['usuario']);
	$stmt_usuario->execute();
	$stmt_usuario->bind_result($correo1, $nombre_usuario1, $nivel1);
	$stmt_usuario->fetch();
	$stmt_usuario->close();

//Busco todo lo que hay en el carrito de este usuario
$b_puntos=mysqli_query($conexion, "SELECT porcentaje FROM carrito WHERE id_usuario=$id_usuario AND estado=1");
	
while(@$row_puntos=mysqli_fetch_assoc($b_puntos)){
  $puntos+=@$row_puntos['porcentaje'];
}
//Busco los abonos que se ha hecho a esos puntos
$b_abonos=mysqli_query($conexion, "SELECT SUM(total) AS total_abonos FROM abono_comision WHERE id_usuario=$id_usuario");
$row_abonos=mysqli_fetch_assoc($b_abonos);
$total_abonos=$row_abonos['total_abonos'];
$puntos=$puntos-$total_abonos;

	}

  //Busco los pedidos que hay nuevos
  $ped='';
  $buscar_nuevos=mysqli_query($conexion, "SELECT idPedido FROM pedidos WHERE estado=0");
  $row_ped=mysqli_fetch_assoc($buscar_nuevos);
  $ped=mysqli_num_rows($buscar_nuevos);
  if($ped==0){
    $ped='';
  }
	
	
 ?>

<nav class="navbar navbar-expand-lg navbar-dark bg-success">
  <a class="navbar-brand <?php echo $ver; ?>" href="#"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
		 <li class="nav-item active">
        <a class="nav-link" href="index">Inicio <span class="sr-only">(current)</span></a>
      </li>
		
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         Admin.
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
			<a class="dropdown-item" href="saldo_caja"><dfn title="Reciba el saldo que se encuentra en la caja del administrador">Caja</dfn></a>
        <a class="dropdown-item" href="escala_premios"><dfn title="Cree los premios que los usuarios ganaran por sus puntos">Crear premios</dfn></a>
			 <!--<a class="dropdown-item" href="buscar_vendedor.php"><dfn title="Buscar informacion sobre un vendedor y el historial de sus ventas">Buscar</dfn></a>-->
			<!--<div class="dropdown-divider"></div>-->
          
        </div>
      </li>


      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         Nosotros
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
			
        <a class="dropdown-item" href="noticias"><dfn title="Vea y edite los subdepartamentos que tiene registrados">Noticias</dfn></a>
			 <!--<a class="dropdown-item" href="buscar_vendedor.php"><dfn title="Buscar informacion sobre un vendedor y el historial de sus ventas">Buscar</dfn></a>-->
			<!--<div class="dropdown-divider"></div>-->
          
        </div>
      </li>

		
		 <li class="nav-item">
        <a class="nav-link" href="carrito">Carrito<?php echo @$filas2; ?></span></a>
       </li>
		
		<!--<li class="nav-item">
        <a class="nav-link" href="publicar">Publicar <span class="carro" id="carro"></span></a>
       </li>-->
		
		
		
		<li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Sectores
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="crear_sector"><dfn title="Registrar un nuevo sector o municipio">Nuevo sector</dfn></a>
          <a class="dropdown-item" href="listado_sectores"><dfn title="Ver los sectores registrados">Listado sectores</dfn></a>
			
			
			
			<!--<div class="dropdown-divider"></div>
			<a class="dropdown-item" href="nueva_lista.php">Nueva lista</a>
			<a class="dropdown-item" href="mis_listas.php">Mis listas</a>
			<a class="dropdown-item" href="historial_listas.php">Todas las listas</a>-->
			
          
      </li>
		
    
       
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         Vendedores
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
			<a class="dropdown-item" href="nuevo_vendedor"><dfn title="Registrar un nuevo vendedor">Registrar vendedor</dfn></a>
          <a class="dropdown-item" href="listado_vendedores"><dfn title="Elija la finca para crear las planillas ">Listado vendedores</dfn></a>
			 <a class="dropdown-item" href="filtrar_clientes"><dfn title="Buscar informacion sobre vendedores en un rango determinado">Filtrar</dfn></a>
			<!--<div class="dropdown-divider"></div>-->
          
        </div>
      </li>
		
		
		<li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Productos
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="nuevo_producto"><dfn title="Registrar un nuevo producto">Registrar</dfn></a>
		  <a class="dropdown-item" href="listado_productos"><dfn title="Lista de todos los productos registrados">Listado de productos</dfn></a>
		  
			
			
         <!-- <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="agotados">Agotados</a>
        </div>-->
      </li>
			
			
		<li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Pedidos <span style="background-color: red; border-radius: 25px;"><?php echo $ped; ?></span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          
		  <a class="dropdown-item" href="pedidos_nuevos"><dfn title="Mire los pedidos que estan pendientes de despacho">Pedidos nuvos</dfn></a>
			
			<a class="dropdown-item" href="ver_pedidos"><dfn title="Mire todos los pedidos">Todos los pedidos</dfn></a>
		  
		  
          
         <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="solicitud_premio" title="Lista de premios por entregar">Solicitud premios</a>
          <a class="dropdown-item" href="historial_premios_entregados" title="Todos los premios que han sido entregados">Premios entregados</a>
        </div>
      </li>	
			
			
			
			<li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Clientes
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          
		  <a class="dropdown-item" href="ver_clientes.php"><dfn title="Listado de los clientes registrados">Listado de clientes</dfn></a>
      <a class="dropdown-item" href="cambiar_clave.php"><dfn title="Archivo para cambiar la clave de un usuario">Cambiar contraseña</dfn></a>
		  
         <!-- <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="agotados">Agotados</a>
        </div>-->
      </li>	
		
		
		
		<li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Usuarios
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="mi_perfil">Mi perfil</a>
          <a class="dropdown-item" href="f_nuevo_usuario">Lista usuarios</a>
		  
          
        </div>
      </li>
		
		<li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Informes
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="informe_general">informe general</a>
          <a class="dropdown-item" href="f_informe_vendedor">Informe por vendedor</a>
          <a class="dropdown-item" href="informe_por_producto">informe por producto y rango</a>
			    <a class="dropdown-item" href="informe_vendedor_rango">informe por vendedor y rango</a>
		  	<!--<div class="dropdown-divider"></div>-->
				
			
        </div>
      </li>
		
		
		
		
      <li class="nav-item">
        <a class="nav-link" href="redimir">Puntos: <?php echo number_format($puntos); ?></span></a>
       </li>
		
      <li class="nav-item">
        <a class="nav-link" href="desconectar.php">Salir</a>
      </li>
		
		<li class="nav-item">
		<!--<form name="busqueda" method="post" action="busqueda.php" class="form-inline">
			<input class="form-control mr-sm-2" type="search" placeholder="Numero de semana" aria-label="Search" required name="buscar" list="clientes" autocomplete="off" />
			<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
			</form>-->
		</li>
		<li class="nav-item">
        <a class="nav-link" href="mi_perfil">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo @$_SESSION['nombre_usuario']; ?></a>
      </li>
    </ul>
    <!--<form class="form-inline my-2 my-lg-0" name="buscar" method="post">
      <input class="form-control mr-sm-2" type="search" placeholder="Buscar" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
    </form>-->
  </div>
</nav>