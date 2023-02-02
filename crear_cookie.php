<?php
//function codigo(){
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $codigo = '';
    for ($i = 0; $i < 19; $i++) {
        $codigo = @$codigo.@$characters[rand(0, strlen($characters))];
    }
    //return $codigo;
	
	//Busco para ver si la cookie existe
	if(!isset($_COOKIE['Invitado'])){
		setcookie("Invitado", $codigo, time()+64200);
		
		}//Fin de la busqueda de la cookie
		
 ?>