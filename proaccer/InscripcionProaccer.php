<?php 

require('../accesorios/admin-superior.php');
require('../accesorios/accesos_bd.php');
$con=conectar(); 

?>

<form id="relevamiento" method="GET" action="../personas/registro_edita.php">
<div class="card">	
	
	<div class="card-header">
		<div class="row">
			<div class="col-xs-12 col-sm-9 col-lg-9">				
				FORMULARIO DE INSCRIPCION DIGITAL - <b>PROACCER</b>							
			</div>
			<div class="col-xs-12 col-sm-3 col-lg-3 text-right">
				<input type="submit" value="Inicia registro" class="btn btn-info">
			</div>	
		</div>		
	</div>
			
	<div class="card-body"> 	

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-lg-12 ">
				<input type="hidden" id="id_lugar" name="id_lugar" value="4">
			</div>
		</div>			  	

		<div class="row pb-3">
			<div class="col-xs-12 col-sm-12 col-lg-12">
				<label>
					Emprendedor registrado y autorizado en PROACCER <span style="color:red">*</span>
				</label>
			</div>	
		</div>

		<div class="row pb-5">
			<div class="col-xs-12 col-sm-6 col-lg-6">
				<select id="id_solicitante" name="id_solicitante" class="form-control" required>
				<option value="" disabled selected>Seleccione solicitante .... &nbsp;</option>
				<?php
				$registro  = mysqli_query($con, "SELECT t1.id_solicitante, t1.apellido, t1.nombres
				FROM solicitantes t1
				INNER JOIN (SELECT * FROM habilitaciones WHERE id_programa = 2) t2 ON t1.id_solicitante = t2.id_solicitante
				WHERE id_responsabilidad = 1	  
				ORDER BY apellido, nombres");
				
				while($fila = mysqli_fetch_array($registro)){ 
					echo '<option value='.$fila[0].' >'.strtoupper($fila[1]).', '.strtoupper($fila[2]).'</option>';
				}			
				?> 
				</select>
			</div>
		</div>

		<div class="row pb-3">

			<div class="col-xs-12 col-sm-12 col-lg-12 ">
				<label>
					Quién registra inscripción ? <span style="color:red">*</span>
				</label>
			</div>	
		</div>

		<div class="row pb-3">
			<div class="col-xs-12 col-sm-6 col-lg-6">
				<select id="id_encuestador" name="id_encuestador" class="form-control" required>
				<option value="" disabled selected>Seleccione encuestador .... &nbsp;</option>
				<?php
				$registro  = mysqli_query($con, 
					"SELECT id_usuario, nombre_usuario 
						FROM usuarios 
						WHERE estado = 'a' AND id_usuario not in (2,4) 
						ORDER BY nombre_usuario asc");
				
				while($fila = mysqli_fetch_array($registro)){ 
					
					if($fila[0] == $_SESSION['id_usuario'] ){					
						echo '<option value='.$fila[0].' selected>'.strtoupper($fila[1]).'</option>';					
					}else{
						echo '<option value='.$fila[0].' >'.strtoupper($fila[1]).'</option>';					
					}
				}			
				?> 
				</select>
			</div>
		</div>
		
	</div>  
</div>
</form>	

<?php require_once('../accesorios/admin-scripts.php'); ?>

<script>

$(document).ready(function() {

	$('#id_solicitante').select2();
});

</script>


<?php
mysqli_close($con);
require_once('../accesorios/admin-inferior.php');