<div id="accordion"><br>
				<?php $contador=1; do{ ?>
   
  <div class="card">
    <div class="card-header" id="heading<?php echo $contador; ?>">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse<?php echo $contador; ?>" aria-expanded="false" aria-controls="collapse<?php echo $contador; ?>" style="font-size: 17px;">
          <b><?php echo $row_departamentos['nombre']; ?></b>
        </button>
      </h5>
    </div>
    <div id="collapse<?php echo $contador; ?>" class="collapse" aria-labelledby="heading<?php echo $contador; ?>" data-parent="#accordion">
      <div class="card-body">
        <?php
									  $idDepartamento=$row_departamentos['idDepartamento'];
		  $buscar_subdep=mysqli_query($conexion, "SELECT * FROM subdepartamento WHERE idDepartamento=$idDepartamento");
		  $row_subdep=mysqli_fetch_assoc($buscar_subdep);
		  ?>
		  <?php do{ ?>
		  <a href="index.php?sub=<?php echo $row_subdep['idSubdepartamento']; ?>" style="color: #000; font-weight: 900"><?php echo $row_subdep['nombre']; ?></a><br>
		  <?php }while($row_subdep=mysqli_fetch_assoc($buscar_subdep)); 
		  
		  ?>
      </div>
    </div>
  </div>
				
				
 
				<?php $contador++; }while($row_departamentos=mysqli_fetch_assoc($b_departamentos)); ?>
				

</div>