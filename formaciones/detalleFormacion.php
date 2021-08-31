<?php

require_once('../accesorios/accesos_bd.php');
$con=conectar();

if(isset($_POST['det'])){

	$idDetalle = $_POST['det'];
	mysqli_query($con, "DELETE FROM formacion_detalle_formaciones WHERE id = $idDetalle" );
}

// DATOS DE LA FORMACION

$id 	=  $_POST['id'];
$query  = mysqli_query($con, "SELECT * FROM formacion_detalle_formaciones WHERE id_solicitante = $id" );

?>

	
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-lg-12">
			<hr>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-lg-12">
			<p class="card-title">
				Detalle de problemática / objetivos
				<a href="modificaDetalleFormacion.php?id=0&id_solicitante=<?php echo $id ?>">
					<i class="fas fa-plus"></i>
				</a>
			</p>				
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-lg-12">
			<table class="table table-hover table-bordered text-center" style="font-size: smaller">
			<tr class="table-dark text-dark">
				<td style=" width:  5%;">#</td>
				<th style=" width:  40%;">Problemática</th>
				<th style=" width:  40%;">Objetivos</th>
				<th style=" width:  5%;">Cumplió</th>
				<th style=" width:  5%;">Modifica</th>
				<th style=" width:  5%;">Elimina</th>
			</tr>
			
			<?php 
			$contador = 1;
			while($fila   = mysqli_fetch_array($query)){ 

				$cumplio = ($fila['cumplio']==0)?'No':'Si';
			?>
			
			<tr>
				<td>
					<?php echo $contador ?>
				</td>
				<td class="text-left">
					<?php echo $fila['objetivos'] ?>
				</td>
				<td class="text-left">
					<?php echo $fila['acciones'] ?>
				</td>
				<td>
					<?php echo $cumplio; ?>
				</td>
				<td>
					<a href="modificaDetalleFormacion.php?id=<?php echo $fila['id'] ?>&id_solicitante=<?php echo $id ?>">
						<i class="fas fa-pencil-alt"></i> 
					</a>
				</td>
				<td>
					<a href="javascript:borrarObjetivos(<?php echo $fila['id'] ?>)">
						<i class="fas fa-trash text-danger"></i>
					</a>
				</td>
			</tr>

			<?php 
			$contador ++;
			}
			?>

			</table>
		</div>
	</div>

<?php mysqli_close($con);
