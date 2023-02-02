<?php
require('conexion/conexion.php');
require('escape.php');


//Busco el registro  del usuario para determinar si ya tiene intentos
if (!empty($_POST["btn-login"])) {

	if (!empty($_POST["user"]) and !empty($_POST["pass"])) {

		$intentos = '';
		$usuario = $_POST['user'];
		$clave = $_POST['pass'];

		$buscar_usuario = mysqli_query($conexion, "SELECT nombre_usuario, apellido_usuario, num_doc,id_depto, id_ciudad, id_sector, direccion, email, clave, nivel, estado, intentos FROM usuarios WHERE email='$usuario'");
		$row_usuario = mysqli_fetch_assoc($buscar_usuario);
		if ($row_usuario >= 1) {

			$intentos = $row_usuario['intentos'];

			if (password_verify($clave, $row_usuario['clave'])) {
				session_start();
				$_SESSION['id_usuario'] = $row_usuario['id_usuario'];
				$_SESSION['mombre'] = $row_usuario['nombre_usuario'];
				$_SESSION['tipo-doc'] = $row_usuario['tipo_doc'];
				$_SESSION['numero'] = $row_usuario['num-doc'];
				$_SESSION['dpto'] = $row_usuario['id_depto'];
				$_SESSION['ciudad'] = $row_usuario['id_ciudad'];
				$_SESSION['sector'] = $row_usuario['id_sector'];
				$_SESSION['direccio'] = $row_usuario['direccion'];
				$usu = $_SESSION['usuario'];
				$_SESSION['nivel'] = $row_usuario['nivel'];
				$_SESSION['clave_maestra'] = '963852';
				mysqli_query($conexion, "UPDATE usuarios SET intentos=0 WHERE email='$usuario'");
				header('Location: index.php');//No va a index.php arreglar
			} else {
				$intentos++;
				mysqli_query($conexion, "UPDATE usuarios SET intentos=$intentos WHERE email='$usuario'");

				if ($intentos >= 5) {

					session_start();
					session_destroy();
					header('Location: cuenta_bloqueada');
				} else {
					?>
					<script>
						Swal.fire({
							icon: 'error',
							title: 'Oops...',
							text: 'Contraseña invalida, vuelve a intentar!',
							confirmButtonColor: '#177c03',

						})
					</script>
					<?php
				}
			}
		} else {
			?>
			<script>
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'Correo invalido, vuelve a intentar!',
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
				text: 'Verifica porque hay campos vacios!',
				confirmButtonColor: '#177c03',
			})
		</script>
		<?php
	}
}