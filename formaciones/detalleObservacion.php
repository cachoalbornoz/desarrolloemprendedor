<?php

require_once('../accesorios/accesos_bd.php');
$con=conectar();


if(isset($_POST['det'])){

	$idDetalle = $_POST['det'];
	mysqli_query($con, "DELETE FROM formacion_detalle_observaciones WHERE id = $idDetalle" );
}

// DATOS DE LA OBSERVACION

$id 	=  $_POST['id'];
$query  = mysqli_query($con, "SELECT obser.id, obser.observacion, obser.updated_at, CONCAT(usu.apellido, ' ',usu.nombres) AS usuario, updated_at
FROM formacion_detalle_observaciones obser
INNER JOIN usuarios usu ON usu.id_usuario = obser.id_capacitador
WHERE id_solicitante =  $id
ORDER BY obser.updated_at DESC" );

?>

<div class="row">
	<div class="col-xs-12 col-sm-12 col-lg-12">
		<p class="card-title">
			Detalle de las acciones				
			<a href="modificaDetalleObservacion.php?id=0&id_solicitante=<?php echo $id ?>">
				<i class="fas fa-plus"></i>
			</a>		
		</p>
	</div>
</div>

<div class="row">
	<div class="col-xs-12 col-sm-12 col-lg-12">
		<table class="table table-hover table-bordered text-center" style="font-size: smaller" id="observacion">
        <tr class="table-dark text-dark">
			<td style=" width: 5%;">#</td>
			<th style=" width: 40%;">Acciones</th>
			<th style=" width: 35%;">Tutor </th>
			<th style=" width: 10%;">Fecha Novedad</th>			
			<th style=" width: 5%;">Modifica</th>
			<th style=" width: 5%;">Elimina</th>
        </tr>
		
		<?php 
		$contador = 1;
		while($fila   = mysqli_fetch_array($query)){

			?>

			<tr>
				<td>
					<?php echo $contador ?>
				</td>
				<td class="text-left">
					<?php echo $fila['observacion'] ?>
				</td>
				<td class="text-left">
					<?php echo $fila['usuario'] ?>
				</td>				
				<td>
					<?php echo $fila['updated_at'] ?>
				</td>
				<td>
					<a href="modificaDetalleObservacion.php?id=<?php echo $fila['id'] ?>&id_solicitante=<?php echo $id ?>">
						<i class="fas fa-pencil-alt"></i>
					</a>
				</td>
				<td>
					<a href="javascript:borrarObservacion(<?php echo $fila['id'] ?>)">
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
