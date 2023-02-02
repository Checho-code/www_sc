<?php
include('conexion/conexion.php');
include('conexion/acceso.php');
include('escape.php');
if(isset($_GET['id_detalle']) && is_numeric($_GET['id_detalle']) && $_SESSION['nivel']>2){
    $id_detalle=test_entrada($_GET['id_detalle']);
    $invitado=test_entrada($_GET['invitado']);
    $sql="DELETE FROM carrito WHERE id_registro=?";
    $stmt=$conexion->prepare($sql);
    $stmt->bind_param('i', $id_detalle);
    $stmt->execute();
    $stmt->close();
    header('Location: detalle_pedido.php?invitado='.$invitado);
}
?>