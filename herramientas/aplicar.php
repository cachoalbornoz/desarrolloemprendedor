<?php
require_once("../accesorios/accesos_bd.php");

$con=conectar();

$consulta	= $_POST['query'];

if(strlen($consulta) > 0){

	$query		= mysqli_query($con, $consulta);
	$row		= mysqli_affected_rows($con);

}else{

	$consulta	= 'SELECT * FROM usuarios WHERE id_usuario = 0';
	$query		= null;
	$row		= 0;
}


?>

	<script type="text/javascript">

	$(document).ready(function() {

		var table = $('#consulta').DataTable({ 
		"lengthMenu"    : [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
		"dom"           : '<"wrapper"Brflit>',        
		"buttons"       : ['copy', 'excel', 'pdf',  'colvis'],
		"order"         : [[ 1, "asc" ]],
		"stateSave"     : true,
		"columnDefs"    : [{}, ],
		"language"      : { "url": "../public/DataTables/spanish.json" }
		});        


	} );

	</script>

	<div class="table-responsive">

		<table class="table table-hover table-striped" style="font-size: small" id="consulta">

		<?php
		// SI LA QUERY NO TIENE "INSERT" "DELETE" "UPDATE" 
		if (strpos($consulta,'alter') === false and strpos($consulta,'insert') === false and strpos($consulta,'delete') === false and strpos($consulta,'update') === false) {  
			

			if ($resultado = mysqli_query($con, $consulta)) {

				$nroCampos = mysqli_num_fields($resultado);

				?>

				<thead>
					<tr>
						<?php

							$fieldinfo = mysqli_fetch_fields($resultado);

							foreach ($fieldinfo as $val)
							{
								echo "<th>".$val->name."</th>";

							}

						?>
					</tr>
				</thead>


				<?php

				while ($row = mysqli_fetch_array($resultado, MYSQLI_BOTH)) {

				?>
				<tr>
					<?php

						for ($i=0; $i < $nroCampos ; $i++) {

							?>
								<td>
									<?php echo $row[$i] ?>
								</td>
							<?php
						}

					?>
				</tr>
				<?php
				}
			}
		}
		?>

	</table>
</div>
<?php
mysqli_close($con);
