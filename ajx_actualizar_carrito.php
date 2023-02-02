<?php
include ('conexion/conexion.php');
include('conexion/acceso.php');
include('escape.php');
//$invitado=test_entrada($_COOKIE['Invitado']);
if(isset($_GET['id_registro']) && is_numeric($_GET['id_registro'])){
    //Buscamos el registro del carrito de compras
    $id_registro=test_entrada($_GET['id_registro']);
    $cantidad=test_entrada($_GET['cantidad']);
    //$invitado=test_entrada($_GET['invitado']);
    $b_registro=mysqli_query($conexion, "SELECT * FROM carrito WHERE id_registro=$id_registro");
    $row_registro=mysqli_fetch_assoc($b_registro);
    $invitado=$row_registro['invitado'];
    mysqli_query($conexion, "UPDATE carrito SET cantidad=$cantidad WHERE id_registro=$id_registro");
    //Busco todo lo que hay en el carrito del invitado
    
    $buscar_carro=mysqli_query($conexion, "SELECT * FROM carrito WHERE invitado='$invitado'");
    //$row_carro=mysqli_fetch_assoc($b_carro);
    $total=0; $subtotal=0;
    while($row_carro=mysqli_fetch_assoc($buscar_carro)){
        $subtotal=$row_carro['cantidad']*$row_carro['precio_costo'];
        $total=$total+$subtotal;
    }
     echo "<h3 class='total'>Total de la compra: $</h3>". number_format($total,2);
    
   
}
?>