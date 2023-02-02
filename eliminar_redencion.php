<?php 
require('conexion/conexion.php');
require('conexion/acceso.php');
include('escape.php');
if(isset($_GET['id_redencion']) && is_numeric($_GET['id_redencion'])){
    $id_redencion=test_entrada($_GET['id_redencion']);
    $elim=mysqli_query($conexion, "DELETE FROM redenciones WHERE id_redencion=$id_redencion");
    header('Location: solicitud_premio');
}

?>