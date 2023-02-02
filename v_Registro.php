<!doctype html>
<html lang="es">

<head>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	<link rel="shortcut icon" href="img/sistema/logo.ico">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="stylesheet" type="text/css" href="mis_css/registro.css">

	<link rel="stylesheet" href="util/sweetalert2.min.css">
  <script type="text/javascript" src="js/jquery.js"></script>
	<title>Formulario de registro</title>
<!-- 
	<script type="text/javascript">
		function validar_clave() {
			var clave = document.registro.clave.value;
			var clave2 = document.registro.clave2.value;
			if (clave != clave2) {
				alert('Las contraseñas no coinciden');
				document.registro.clave.value = "";
				document.registro.clave2.value = "";
				return false;
			}
		}
	</script> -->
</head>

<body>


	<!--Form registro-->
	<div class="cont_ppal">

		<div class="form_regis">

			<div class="cont-img">
				<img src="img/sistema/logo.png" alt="Solcomercial" />
			</div>
			<h2>Formulario de registro v</h2>
			<form  method="post" id="registro">

			<?php
			include "registro.php";
			?>
				<div class="contenedor">
					<div class="entradas">
						<label for="nombres">Nombre *</label>
						<input name="nombre" type="text" autofocus="autofocus" placeholder="Ej Luisa ">
					</div>

					<div class="entradas">
						<label for="apellidos">Apellido *</label>
						<input name="apellido" type="text" placeholder="Ej Calle">
					</div>

					<div class="entradas">
						<label for="tipo-docs">Tipo documento *</label>
						<input name="tipo-doc" type="text" placeholder="Seleccione uno" >
					</div>

					<div class="entradas">
						<label for="num-docs">Número docuemnto *</label>
						<input name="num-doc" type="number" placeholder="Ej 000111000" >
					</div>

					<div class="entradas">
						<label for="departamentos">Departamento *</label>
						<input type="text" name="departamento" placeholder="Seleccione su departamento">
					</div>

					<div class="entradas">
						<label for="ciudads">Ciudad *</label>
						<input type="text" name="ciudad" placeholder="Seleccione su ciudad">
					</div>

					<div class="entradas">
						<label for="sectors">Barrio o sector *</label>
						<input type="text" name="sector" placeholder="Seleccione su barrio">
					</div>

					<div class="entradas">
						<label for="direccions">Direccion *</label>
						<input name="direccion" type="text" placeholder="Ej Cra xx # xx-xx" >
					</div>

					<div class="entradas">
						<label for="correo1s">Correo *</label>
						<input type="email" name="correo1" placeholder="Ej micorreo@algo.com">
					</div>

					<div class="entradas">
						<label for="correo2s">Repetir correo *</label>
						<input type="email" name="correo2" placeholder="Ej micorreo@algo.com">
					</div>

					<div class="entradas">
						<label for="clave1s">Contraseña *</label>
						<input name="clave1" type="password"  class="claves">
						<img src="icon/ver.png" class="icon" id="eye">
					</div>

					<div class="entradas">
						<label for="clave2s">Repetir Contraseña *</label>
						<input name="clave2" type="password"  class="claves">
						<img src="icon/ver.png" class="icon" id="eye1">
					</div>
				</div>
				<!-- <div class="term-cond">
					<div class="entrasdas" align="left">
						<label for="contrato">Acepto el <a href="contrato.html" target="_blanck">Contrato</a>
							*</label>
						<input name="checkbox" type="checkbox" required="required" id="checkbox">
					</div>
				</div> -->

				<div class="entradas">
					<button type="submit" class="btn-ingreso" name="btn-R" value="ok">Registrar</button>
					<a href="login.php" class="btn-registro">Cancelar</a>
				</div>
			</form>
			<br>


		</div>
	</div>



	
	
	<script type="text/javascript" src="js/popper.js"></script>
	<script type="text/javascript" src="js/ver_password-reg.js"></script>
</body>

</html>