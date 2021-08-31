<?php

require_once('../accesorios/accesos_bd.php');
$con=conectar();

if(isset($_POST['det'])){

	$idDetalle = $_POST['det'];
	mysqli_query($con, "DELETE FROM proaccer_detalle_inversiones WHERE id = $idDetalle" );
}


// DATOS DE LA INVERSION

$id 	=  $_POST['id'];
$query  = mysqli_query($con, "SELECT * FROM proaccer_detalle_inversiones WHERE id_proyecto = $id" );


?>

<div class="form-group">
	<div class="row">
		<div class="col">
			<hr>
		</div>
	</div>
</div>

<div class="row">
	<div class="col">
		<h5 class="card-title">
			Detalle de inversiones				
		
			<a href="modificaDetalleInversion.php?id=0&id_proyecto=<?php echo $id ?>">
				<i class="fas fa-plus"></i>
			</a>		

		</h5>				
	</div>
</div>

<div class="row">
	<div class="col">
		<table class="table table-hover table-bordered dt-responsive" style="font-size: small" id="inversion">
        <tr class="table-dark text-dark">
			<td style=" width:  5%;">#</td>
			<th style=" width: 15%;">Descripción de la inversión </th>
			<th style=" width:  5%;">Facturó</th>
			<th style=" width:  5%;">Ejecutó</th>
			<th style=" width: 65%;">En qué situación está ?</th>
			<th style=" width:  5%;">Modifica</th>
			<th style=" width:  5%;">Elimina</th>
		</tr>
		
		<?php 
		$contador = 1;
		while($fila   = mysqli_fetch_array($query, MYSQLI_BOTH)){

		?>

		<tr>
			<td>
				<?php echo $contador ?>
			</td>
			<td>
				<?php echo $fila['descripcion'] ?>
			</td>
			<td class=" text-center">
				<input type="checkbox" name="facturo" id="facturo" <?php if($fila['facturo'] == 1){ echo 'checked';} ?>>
			</td>
			<td class=" text-center">
				<input type="checkbox" name="ejecuto" id="ejecuto" <?php if($fila['ejecuto'] == 1){ echo 'checked';} ?>>
			</td>
			<td>
				<?php echo $fila['situacion'] ?>
			</td>
			<td class=" text-center">
				<a href="modificaDetalleInversion.php?id=<?php echo $fila['id'] ?>&id_proyecto=<?php echo $id ?>">
					<i class="fas fa-pencil-alt"></i>
				</a>
			</td>
			<td class=" text-center">
				<a href="javascript:borrarInversion(<?php echo $fila['id'] ?>)">
					<i class="fas fa-trash"></i>
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
