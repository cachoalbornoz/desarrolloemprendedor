<?php

require_once('../accesorios/accesos_bd.php');
$con=conectar();


if(isset($_POST['det'])){

	$idDetalle = $_POST['det'];
	mysqli_query($con, "DELETE FROM proaccer_detalle_observaciones WHERE id = $idDetalle" );
}

// DATOS DE LA OBSERVACION

$id 	=  $_POST['id'];
$query  = mysqli_query($con, "SELECT obser.id, obser.observacion, obser.updated_at, CONCAT(usu.apellido, ' ',usu.nombres) AS usuario
FROM proaccer_detalle_observaciones obser
INNER JOIN usuarios usu ON usu.id_usuario = 	obser.id_usuario
WHERE id_proyecto =  $id" );

?>

<div class="row">
	<div class="col">
		<h5 class="card-title">
			Detalle de observaciones				
			<a href="modificaDetalleObservacion.php?id=0&id_proyecto=<?php echo $id ?>">
				<i class="fas fa-plus"></i>
			</a>		
		</h5>
	</div>
</div>

<div class="row">
	<div class="col">
		<table class="table table-hover table-bordered dt-responsive" style="font-size: small">
        <tr class="table-dark text-dark">
			<td style=" width: 5%;">#</td>
			<th>Observación </th>
			<th style=" width: 15%;">Usuario que registró </th>
			<th style=" width: 8%;">Fecha registro</th>
			<th style=" width: 5%;">Modifica</th>
			<th style=" width: 5%;">Elimina</th>
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
					<?php echo $fila['observacion'] ?>
				</td>
				<td>
					<?php echo $fila['usuario'] ?>
				</td>
				<td>
					<?php echo date('Y-m-d', strtotime($fila['updated_at'])) ?>
				</td>
				<td class=" text-center">
					<a href="modificaDetalleObservacion.php?id=<?php echo $fila['id'] ?>&id_proyecto=<?php echo $id ?>">
						<i class="fas fa-pencil-alt"></i>
					</a>
				</td>
				<td class=" text-center">
					<a href="javascript:borrarObservacion(<?php echo $fila['id'] ?>)">
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
