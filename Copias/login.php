<?php 
require('conexion/conexion.php');
include('escape.php');
//Busco si existen las cookies para el inicio de sesion
$cedula='';
$clave='';
if(isset($_COOKIE['cedula'])){
  $cedula=$_COOKIE['cedula'];
  $clave=$_COOKIE['clave'];
}
?>
<!doctype html>
<html lang="es">
<head>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<link rel="shortcut icon" href="img/sistema/logo.ico">
<meta charset="utf-8">
<meta name="description" content="" />
<meta name="keywords" content="" />
<!--<meta name="robots" content="noindex">-->
	<meta name="robots" content="index, follow">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<title>Solcomercial</title>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="css/mi_estilo.css" />
<link rel="stylesheet" type="text/css" href="css/galeria.css" />

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">
  function revelar(){
    var clave=document.ingresar.clave3.value;
    document.getElementById('clave').innerHTML="";
    document.ingresar.clave3.setAttribute("type", "text");
    document.getElementById('clave').innerHTML=clave+'&nbsp;&nbsp;'+'<a href="#" onclick="ocultar()">Ocultar clave</a>';
  }
  function ocultar(){
    window.location='login';
  }
</script>


</head>

<body>
    <div class="container-fluid ">
    <!--primera fila del menú-->
	
    <div class="row">
      <div class="col-md-12 slider">
	

          <!--<div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img class="d-block w-100" src="img/sistema/letrero.jpg" alt="First slide">
              </div>
              <div class="carousel-item">
                <img class="d-block w-100" src="img/sistema/pie.jpg" alt="Second slide">
              </div>
              
            </div>
          </div>-->



      <div class="container-fluid">
  <div class="row fixed-top">
	<div class="col-md-11"><!--INICIO DEL MENU-->
    
	    <?php 
		   include('menuBasico.php');	
		?>
		
     
    </div>
    <div class="col-md-1" align="center"><a href="carrito.php"><img src="img/sistema/carrito.png" width="70" height="60" /></a>
    <div align="center"><span class="carro" id="carro"><?php echo $filas2; ?></div>	</div>
  </div>
  
  
</div>



</div>
</div>
	<!-- Formulario login -->
	<div class="row">
		
        <div class="col-sm-12">
        <div><img src="img/sistema/logo.png" width="150" height="150" alt="Solcomercial"></div>
          <!--<h1>Solcomercial</h1>--><br><br>
          
          <form name="ingresar" method="post" action="inicio_sesion.php">
                <div class="table-responsive">
              <div class="form-group">
                <label for="correo_usuario2">Id user / Cedula del usuario *</label>
                  <input type="text" name="correo_usuario2" required placeholder="Ingrese su  ID -numero de cedula" class="form-control" size="20" value="<?php echo $cedula; ?>"></div>
              <div class="form-group">
                <label for="clave3">Password / clave * <span id="clave"></span> <a href="#" onclick="revelar()">Ver clave</a></label>
                <input type="password" name="clave3" required placeholder="Ingrese su contraseña" class="form-control" size="20" value="<?php echo $clave; ?>"></div>
                <div class="form-group">
                          <div class="g-recaptcha" data-sitekey="6Le7r80hAAAAALFj1ERzZeaej5hrhxk34d4uCIcM"></div>
                          </div>
                <input type="submit" name="enviar" value="INGRESAR" class="btn btn-primary"> 
                        &nbsp;&nbsp;&nbsp;<a href="f_registro" class="btn btn-dark">Crear una cuenta</a>
                <!--Olvidadó su contraseña?<br><a href="recuperar_clave.php">CAMBIAR CONTRASEÑA</a>--><br><br>
                          </div>
              
           </form>
		
           
		
		    <br><br>

		
    </div>
	</div>


	<div class="row">
    <div class="col-md-6">¿QUÉ ES SOLCOMERCIAL?
Somos una empresa ubicada en el municipio de Andes-Antioquia, creada para acompañar al campesino en el proceso de comercialización de sus cosechas, especialmente de manera directa en sus hogares.
Así, usted tiene la tranquilidad de recibir los frutos del campo en su mesa y poder ayudar a que los campesinos se beneficien del duro trabajo en sus cultivos y que no sean los intermediarios los que se sigan quedando con el producto de su esfuerzo.
¿QUÉ OFRECE SOLCOMERCIAL?
Inicialmente ofrecemos la línea de productos del campo, denominada FRUTOS DEL CAMPO EN SU MESA.
 
</div>
    <div class="col-md-6">¿QUIÉN SE BENEFICIA?
Inicialmente usted se beneficia porque adquiere un producto natural, bien cuidado y sin contaminantes, a precios directos y en su propia casa. Pero al mismo tiempo, con su compra, tiene la seguridad de que apoya a una familia campesina y a diversas asociaciones que trabajan en beneficio del campo colombiano.
De esta manera, por cada compra  que usted realice, acumulará puntos que le darán el derecho de recibir obsequios de nuestra empresa; y otros recursos derivados de su compra se destinarán a conformar una Fundación de apoyo a las familias de los campesinos que nos proveen con sus productos.
SU APORTE SERÁ VITAL PARA QUE RENAZCA EL CAMPO COLOMBIANO. ¡MIL GRACIAS!<br>
</div>
  </div>
	
	
<div class="row">
<div class="col-md-12">
<?php include('footer.php'); ?>
</div>
</div>

	
	

</div>
<!--<script type="text/javascript" src="js/jquery.js"></script>-->
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<!--<script type="text/javascript" src="js/popper.js"></script>-->

</body>
</html>
