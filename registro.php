<?php
require('conexion/conexion.php');
require('escape.php');

//capturamos y escapamos todo lo que se envio por el formulario
if (!empty($_POST["btn-R"])) {

	if (!empty($_POST["name"]) and !empty($_POST["lastname"]) and !empty($_POST["tip-doc"]) and !empty($_POST["num-doc"]) and  !empty($_POST["depart"]) and !empty($_POST["ciudad"]) and  !empty($_POST["sector"]) and !empty($_POST["direcc"]) and !empty($_POST["corr1"]) and !empty($_POST["corr2"]) and !empty($_POST["cla1"]) and !empty($_POST["cla2"])) {
		$nombre = $_POST["name"];
		$apellido = $_POST["lastname"];
		$tipo_doc = $_POST["tip-doc"];
		$num_doc = $_POST["num-doc"];
		$dpto = $_POST["depart"];
		$city = $_POST["ciudad"];
		$barrio = $_POST["sector"];
		$adress = $_POST["direcc"];
		$email = $_POST["corr1"];
		$email2 = $_POST["corr2"];
		$clave_natural = $_POST["cla1"];
		$clave = password_hash($_POST['cla1'], PASSWORD_DEFAULT);
		$clave2 = $_POST["cla2"];
		$nivel=4;
		$estado = 1;
		$intentos = 0;
		$fecha_registro=date('Y-m-d');

		//Registramos el usuario
		$sql =mysqli_query($conexion, "INSERT INTO usuarios (nombre_usuario,apellido_usuario,tipo_doc,num_doc,id_depto,id_ciudad,id_sector,direccion,email,clave,rku,nivel,estado,intentos,fecha_registro) VALUES('$nombre', '$apellido','$tipo_doc', '$num_doc', '$dpto','$city', '$barrio','$adress','$email','$clave','$clave2','$nivel','$estado','$intentos','$fecha_registro')");
		if ($sql == 1) {?>
			<script>
				Swal.fire({
					icon: 'error',
					title: 'Bueno Bueno.',
					text: 'usuario Registrado!',
					confirmButtonColor: '#177c03',

				})
			</script>
		<?php
			header("Location:login.php");
		} else {
?>
			<script>
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'Error al registrar usuario!',
					confirmButtonColor: '#177c03',

				})
			</script>
		<?php
		}
	} else { ?>
		<script>
			Swal.fire({
				icon: 'error',
				title: 'Oops...',
				text: 'Campos vacios!',
				confirmButtonColor: '#177c03',

			})
		</script>
<?php

	}
}
?>