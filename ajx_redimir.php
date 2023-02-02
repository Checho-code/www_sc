<?php
include ('conexion/conexion.php');
include('conexion/acceso.php');
include('escape.php');
$puntos=0;
$id_usuario=$_SESSION['id_usuario'];
//Busco los puntos disponibles para este usuario
$b_puntos=mysqli_query($conexion, "SELECT porcentaje FROM carrito WHERE idCliente=$id_usuario AND estado=1");
	
	while($row_puntos=mysqli_fetch_assoc($b_puntos)){
		$puntos+=$row_puntos['porcentaje'];
	}

if(isset($_GET['id_producto']) && is_numeric($_GET['id_producto'])){
    $respuesta='';
    $id_producto=test_entrada($_GET['id_producto']);

    //Busco los puntos necesarios para este premio
    $b_premio=mysqli_query($conexion, "SELECT * FROM premios WHERE id_premio=$id_producto");
    $row_premio=mysqli_fetch_assoc($b_premio);
    $puntos_necesarios=$row_premio['puntos'];

    //Juego de registros para el primer premio
    $b_primer_premio=mysqli_query($conexion, "SELECT * FROM premios ORDER BY id_premio ASC LIMIT 1");
    $row_primero=mysqli_fetch_assoc($b_primer_premio);
    $id_primero=$row_primero['id_premio'];
    $id_prod=$row_primero['id_premio'];
    $nombre_primero=$row_primero['nombre_premio'];

   
    //Antes busco la cantidad de redenciones, en caso de que no tenga ningun premio redimido, obligar a redimir siempre el primer producto
    $b_redenciones=mysqli_query($conexion, "SELECT * FROM redenciones WHERE id_usuario=$id_usuario ORDER BY id_redencion DESC");
    $row_redenciones=mysqli_fetch_assoc($b_redenciones);
    $filas=mysqli_num_rows($b_redenciones);
    $estado=@$row_redenciones['estado'];
    //Si filas=0 o filas ='' obligo a que solo pueda redimir el primer premio
    if($filas==0 && $id_producto!=$id_prod){
        $respuesta="Debe redimir antes que nada $nombre_primero ";
    }


    elseif($filas==0 && $id_producto==$id_prod){
        //Registro el primer producto, en caso de que haya sido elegido
        //$respuesta="Ha elegido el primer producto correctamente";
        $b_prod=mysqli_query($conexion, "SELECT * FROM premios WHERE id_premio=$id_producto");
    $row_prod=mysqli_fetch_assoc($b_prod);
    $total=$row_prod['puntos'];
    $premio=$row_prod['nombre_premio'];
    //Registro la solicitud de redencion
    
    $fecha=date('Y-m-d');
    $hora=date('H:i:s');
    $estado=0;
    if($puntos>=$puntos_necesarios){
        $sql="INSERT INTO redenciones (id_usuario, id_producto, fecha, hora, total, estado) VALUES (?,?,?,?,?,?)";
    $stm=$conexion->prepare($sql);
    $stm->bind_param('iissii', $id_usuario, $id_producto, $fecha, $hora, $total, $estado);
    $stm->execute();
    $stm->close();
    $respuesta="Solicitud enviada para redimir ".$premio;
    }
    else{
        $respuesta="No tiene los puntos necesarios";
    }
    
    }


    elseif($filas>0){
        
        $b_prod=mysqli_query($conexion, "SELECT * FROM premios WHERE id_premio=$id_producto");
    $row_prod=mysqli_fetch_assoc($b_prod);
    $total=$row_prod['puntos'];
    $premio=$row_prod['nombre_premio'];
    //Registro la solicitud de redencion
    
    $fecha=date('Y-m-d');
    $hora=date('H:i:s');
    //$estado=0;
    if($estado){
        $estadoo=0;
        if($puntos>=$puntos_necesarios){
            $sql="INSERT INTO redenciones (id_usuario, id_producto, fecha, hora, total, estado) VALUES (?,?,?,?,?,?)";
        $stm=$conexion->prepare($sql);
        $stm->bind_param('iissii', $id_usuario, $id_producto, $fecha, $hora, $total, $estadoo);
        $stm->execute();
        $stm->close();
        $respuesta="Solicitud enviada para redimir ".$premio;
        }
        
    }
    else{
        $respuesta="Ya tiene un poceso de redencion iniciado";
    }
   
    }

    echo $respuesta; 
  
}