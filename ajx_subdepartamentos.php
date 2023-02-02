<?php
include('conexion/conexion.php');
include('conexion/acceso.php');
//include('conexion/acceso-principal');
$departamentos=mysqli_query($conexion, "SELECT * FROM departamentos ORDER BY nombre");
$row_departamentos=mysqli_fetch_assoc($departamentos);
 ?>

 <?php
 do{
  ?>
  <option value="<?php echo $row_departamentos['idDepartamento']; ?>"><?php echo $row_departamentos['nombre']; ?></option>
  <?php } while($row_departamentos=mysqli_fetch_assoc($departamentos)); ?>