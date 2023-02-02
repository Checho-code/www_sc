<?php
include('conexion/conexion.php');
include('conexion/acceso.php');
include('escape.php');
//Capturo el parametro enviado
$idDepartamento= test_entrada($_GET['id_departamento']);


$subdepartamentos=mysqli_query($conexion, "SELECT * FROM subdepartamento WHERE idDepartamento=$idDepartamento");
$row_subdepa=@mysqli_fetch_assoc($subdepartamentos);
 ?>
 <label for="idSubdepartamento">Elija el subdepartamento</label>
<select name="idSubdepartamento"class="form-control" required onChange="cargar()">
<option value="">Ninguno</option>
<option value="0">Nuevo</option>

<?php do{ ?>
<option value="<?php echo $row_subdepa['idSubdepartamento']; ?>"><?php echo $row_subdepa['nombre']; ?></option> 
<?php } while($row_subdepa=mysqli_fetch_assoc($subdepartamentos)); ?>
</select>