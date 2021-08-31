<?php

require_once('../accesorios/accesos_bd.php');
$con=conectar();

if(isset($_POST['id']) and isset($_POST['valor']) ){

    $id_solic   = $_POST['id'];
    $valor      = $_POST['valor'];
    $seleccion  = "UPDATE habilitaciones SET habilitado = $valor WHERE id_solicitante = $id_solic";
    mysqli_query($con, $seleccion);
}

?>

<script type="text/javascript">

    $(document).ready(function() {

        var table = $('#proceder').DataTable({ 
            "lengthMenu"    : [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            "dom"           : '<"wrapper"Brflit>',        
            "buttons"       : ['copy', 'excel', 'pdf',  'colvis'],
            "order"         : [[ 1, "asc" ]],
            "stateSave"     : true,
            "columnDefs"    : [{ }, ],
            "language"      : { "url": "../public/DataTables/spanish.json" }
        }); 
    })

</script>



<div class="row">
	<div class="col">
		<table class="table table-hover table-striped dt-responsive" style="font-size: small" id="proceder">
        <thead>
        <tr class='text-center'>
            <th>Solicitante</th>
            <th>Ciudad</th>
            <th>Rubro</th>
            <th>Reseña</th>
            <th>Habilitado</th>
			<th style="width: 8%">Fecha Reg</th>
			<th style="width: 8%">Fecha Insc</th>
        </tr>
        </thead>
        <tbody>
        <?php

        $contador = 1;

        $seleccion = "SELECT t1.id_solicitante, CONCAT(t1.apellido, ' ', t1.nombres) as solicitante, t4.nombre as ciudad, t3.rubro, 
        t2.observaciones, habilitado, t1.fecha, t7.update_at
        FROM solicitantes t1
        INNER JOIN registro_solicitantes t2 ON t1.id_solicitante = t2.id_solicitante
        INNER JOIN tipo_rubro_productivos t3 ON t2.id_rubro = t3.id_rubro
        INNER JOIN localidades t4 ON t1.id_ciudad = t4.id
        LEFT JOIN  habilitaciones t5 ON t1.id_solicitante = t5.id_solicitante
        LEFT JOIN  rel_proceder t6 ON t1.id_solicitante = t6.id_solicitante
        LEFT JOIN  proceder_proyectos t7 ON t6.id_proyecto = t7.id_proyecto
        WHERE t5.id_programa = 5
        GROUP BY t1.id_solicitante
        ORDER BY t1.apellido, t1.nombres";

        $_SESSION['consulta']=$seleccion;

        $tabla_proceder = mysqli_query($con, $seleccion);

        while ($fila = mysqli_fetch_array($tabla_proceder, MYSQLI_BOTH)) {

        $id_solicitante = $fila['id_solicitante'];
        
        ?>
		<tr class='text-center'>
			<td><a href="javascript:void(0)" title="Editar datos" onclick="editar_solicitante(<?php echo $id_solicitante ?>)"> <?php echo $fila['solicitante'] ?></a></td>
			<td><?php echo $fila['ciudad'] ?></td>
			<td style="text-align: justify"><?php echo $fila['rubro'] ?></td>
			<td style="text-align: justify"><?php echo strtolower($fila['observaciones']); ?></td>
			<td class="text-center">
				<?php if ($fila['habilitado'] == 0) {
                    $valor = 1;
                    $texto = "NO";
                } else {
                    $valor = 0;
                    $texto = "SI";
                } ?>

                <a href="#" onclick="habilita(<?php echo $id_solicitante?>, <?php echo $valor?>)"><?php echo $texto?></a>

			</td>
			<td>
                <?php if ($fila['fecha'] <> null) {
                    echo  date('Y-m-d', strtotime($fila['fecha']));
                } else {
                    echo '';
                } ?>
            </td>
			<td>
                <?php if ($fila['update_at'] <> null) {
                    echo  date('Y-m-d', strtotime($fila['update_at']));
                } else {
                    echo NULL;
                } ?>
            </td>
        </tr>
		<?php
        $contador ++;
        }
        ?>
        </tbody>
		</table>
	</div>
</div>
<?php mysqli_close($con);
