<?php
include 'conexion/conexion.php';

if(!empty($_POST["btnLogin"])){
    
    if (!empty($_POST["user"]) and !empty($_POST["pass"])){ 
        $user = $_POST["user"];
        $pass = $_POST["pass"];
        
        $conexion = new Conexion($user, $pass);
        
        if ($conexion->isLogin()){
    }else{

    }
}


?>