<?php
@session_start();
if(!isset($_SESSION['usuario']) || $_SESSION['usuario'] == ''){
	session_start();
	session_destroy();
	header('Location: login');
	}
 ?>