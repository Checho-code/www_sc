<?php
require('conexion/conexion.php');
require('escape.php');

//capturamos y escapamos todo lo que se envio por el formulario
if (!empty($_POST["btn-R"])) {

	if (!empty($_POST["nombre"]) and !empty($_POST["apellido"]) and !empty($_POST["tipo_doc"]) and !empty($_POST["num_doc"]) and  !empty($_POST["departamento"]) and !empty($_POST["ciudad"]) and  !empty($_POST["sector"]) and !empty($_POST["direccion"]) and !empty($_POST["correo1"]) and !empty($_POST["correo2"]) and !empty($_POST["clave1"]) and !empty($_POST["clave2"])) { 

		
		$nombre=$_POST["nombre"];
		$apellido=$_POST["apellido"];
		$tipo_doc=$_POST["tipo_doc"];
		$num_doc=$_POST["num_doc"];
		$dpto=$_POST["departamento"];
		$city=$_POST["ciudad"];
		$barrio=$_POST["sector"];
		$adress=$_POST["direccion"];
		$email=$_POST["correo1"];
		$email2=$_POST["correo2"];
		$clave=$_POST["clave1"];
		$clave2=$_POST["clave2"];
		$nivel= 4; //nivel para saber que rol es
		$estado= 1;
		$intentos= 0;
		$fecha_registro= date('Y-m-d');
	

		//Registramos el usuario
		$sql = $conexion->query("INSERT INTO usuarios (nombre_usuario,apellido_usuario,tipo_doc,num_doc,id_depto,id_ciudad,id_sector,direccion,email,clave, nivel,estado,intentos,fecha_registro) VALUES('$nombre', '$apellido','$tipo_doc', '$num_doc', '$dpto','$city', '$barrio','$adress','$email','(aes_encrypt('$clave','AES'))','$nivel','$estado',''$intentos','$fecha_registro')");
		if ($sql==1) { 
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

	} else {?>
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