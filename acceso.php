<?php
if($_SESSION['nivel']<2){
	echo "<script type='text/javascript'>
	alert('Usted no tiene permisos para realizar esta acción, contacte a un administrador');
	window.location='portada.php';
	</script>";
}
?>