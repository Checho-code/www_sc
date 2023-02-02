<!doctype html>
<html lang="es">

<head>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <link rel="shortcut icon" href="img/sistema/logo.ico">
  <meta charset="utf-8">
  <meta name="description" content="" />
  <meta name="keywords" content="" />
  <meta name="robots" content="index, follow">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>Solcomercial</title>

  <link rel="stylesheet" href="mis_css/login.css">
  <link rel="stylesheet" href="util/sweetalert2.min.css">
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script type="text/javascript" src="js/jquery.js"></script>


</head>

<body>
<p style="background-color: lawngreen;">Error: No abre la sesion de index, revisar y solucionar</p>
  <!-- Formulario login -->
  <div class="cont_ppal">
    <div class="form_login">



      <form class="cont_form" method="post" action="">
        <div class="cont-img ">
          <img src="img/sistema/logo.png" alt="Solcomercial" class="logo" />
        </div>
    <?php
          include 'inicio_sesion.php';
          ?>
        <div class="cont-img">
          <h3 id="titulo">Iniciar Sesión </h3>
        </div>

        <div class="tabla">
         

          <div class="entradas">
            <label for="correo">E-mail</label>
            <input type="email" name="user" placeholder="Ej micorreo@algo.com" class="user" size="10">
          </div>

          <div class="entradas">
            <label for="clave">Contraseña </label>
            <input type="password" name="pass" placeholder="Ingrese su contraseña" class="password" id="password" size="10">
            <img src="icon/ver.png" class="icon" id="eye">
          </div>


          <div class="olvido">
            <a href="recuperar_clave.php" class="link">¿Olvidó su contraseña?</a>
          </div>

          <div class="botonera">
            <a href="f_registro.php" class="btn-registro">Registrarme</a>
            <button type="submit" name="btn-login" value="ok" class="btn-ingreso">Ingresar</button>
          </div>
        </div>
      </form>

    </div>
  </div>

  
  <script type="text/javascript" src="js/ver_password-login.js"></script>
  <script type="text/javascript" src="util/sweetalert2.min.js"></script>

</body>

</html>