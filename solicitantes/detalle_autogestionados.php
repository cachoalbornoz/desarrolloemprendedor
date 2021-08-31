<?php
session_start();

require_once("../accesorios/accesos_bd.php");

$con=conectar();
?>

<style>
    th.rotate   { height: 150px;transform: rotate(-90deg); }
    td.rowspanning div { width:100%;  overflow-y:auto;  overflow-x:auto;}
</style>


<?php




$contador = 1;

$seleccion = 
"SELECT DISTINCT t1.id_solicitante, t1.apellido, t1.nombres, t1.telefono, t1.celular, t1.fecha, t1.dni, t1.email, t4.nombre as ciudad, t2.observaciones as resena, rubro, estado, t9.icono, if(habilitado=1,'SI',if(habilitado=0,'NO','NO')) as habilitado, t8.fecha as fechar, t2.observacionesp, abreviatura 
FROM solicitantes t1
INNER JOIN registro_solicitantes t2 ON t1.id_solicitante = t2.id_solicitante
INNER JOIN tipo_rubro_productivos t3 ON t2.id_rubro = t3.id_rubro
INNER JOIN localidades t4 ON t1.id_ciudad = t4.id
LEFT JOIN rel_proyectos_solicitantes t5 ON t1.id_solicitante = t5.id_solicitante
LEFT JOIN habilitaciones t6 ON t1.id_solicitante = t6.id_solicitante
LEFT JOIN proyectos t7 ON t7.id_proyecto = t5.id_proyecto
LEFT JOIN seguimiento_proyectos t8 ON t1.id_solicitante = t8.id_solicitante
LEFT JOIN tipo_estado t9 ON t7.id_estado = t9.id_estado
INNER JOIN tipo_programas t10 ON t2.id_programa = t10.id_programa
WHERE t1.id_responsabilidad = 1
ORDER BY t1.apellido";

$_SESSION['consulta']=$seleccion;

$tabla_autogestionados = mysqli_query($con, $seleccion);

?>



<div class="table-responsive">
    <table class="table table-condensed" style="font-size: smaller" id="autogestionados" >
		<thead>
		<tr>
			<th></th>
			<th>#Id</th>
			<th>Titular</th>
			<th>Ciudad</th>
			<th>Rubro</th>
			<th>Prog</th>
			<th>Reseña</th>
			<th>Habil</th>
			<th>Estado</th>
			<th>Fecha_Regist</th>
			<th>Exped</th>
			<th>Fecha_Relev</th>
			<th>Correo </th>
			<th>Celular</th>
		</tr>
		</thead>
		<tbody>
			<?php
			while ($fila = mysqli_fetch_array($tabla_autogestionados, MYSQLI_BOTH)) {
				$emprendedor = $fila['apellido'].', '.$fila['nombres'] ;

				$dni = $fila['dni'];
				$tabla_proyectos = mysqli_query($con, 
				"SELECT te.icono
				FROM expedientes as exp, rel_expedientes_emprendedores as ree, emprendedores as emp, tipo_estado as te, tipo_rubro_productivos as rp
				WHERE exp.id_expediente = ree.id_expediente and ree.id_emprendedor = emp.id_emprendedor and emp.dni = $dni and exp.estado = te.id_estado and exp.id_rubro = rp.id_rubro
				ORDER BY emp.apellido,emp.nombres asc");

				$registro = mysqli_fetch_array($tabla_proyectos);
				if ($registro) {
					$icono = $registro['icono'];
				} else {
					$icono = null;
				}

				?>
			<tr>
				<td class="text-center">
					<input type="checkbox" name="proyecto[]" value="<?php echo $fila['id_solicitante'] ?>">
				</td>
				<td>
					<?php echo $fila['id_solicitante'] ?>
				</td>
				<td>
					<a href="javascript:void(0)" title="Editar datos" onclick="editar_solicitante(<?php echo $fila['id_solicitante'] ?>)">
						<?php echo $emprendedor ?>
					</a>
				</td>
				<td>
					<?php echo $fila['ciudad'] ?>
				</td>
				<td>
					<?php echo $fila['rubro'] ?>
				</td>
				<td>
					<?php echo $fila['abreviatura']; ?>
				</td>
				<td class="rowspanning text-justify" title="<?php echo $fila['resena']; ?>">
					<div style="max-width: 15em; max-height: 5em">
						<?php echo ucfirst($fila['resena']); ?>
					</div>
				</td>
				<td class="text-center">
					<?php echo $fila['habilitado'] ?>
				</td>
				<td>
					<?php echo $fila['estado'] ?>
				</td>
				<td>
					<?php echo date('Y-m-d', strtotime($fila['fecha'])) ?>
				</td>
				<td class="text-center">
					<?php echo $icono ?>
				</td>
				<td>
                    <?php
                    if ($fila['fechar']) {
						echo date('Y-m-d', strtotime($fila['fechar']));
					}
                    ?>
                </td>
				<td>
					<?php echo $fila['email'] ?>
				</td>
				<td>
					<?php echo $fila['celular'] ?>
				</td>
			</tr>
			<?php
			$contador ++;
		}
		?>
		</tbody>
	</table>
</div>

<?php mysqli_close($con);
