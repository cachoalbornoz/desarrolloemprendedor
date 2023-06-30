<?php
require('../accesorios/admin-superior.php');
require('../accesorios/accesos_bd.php');
$con=conectar();

?>

<form action ="CargarEntrevistaProaccer.php" method="post" class=" form-horizontal " enctype="multipart/form-data">
	
	<div class="card">
        <div class="card-header">

			<div class="row mb-5">
				<div class="col-lg-12">
					PLANILLA DE ENTREVISTA - <b>INSCRIPCION INICIAL</b>
				</div>
			</div>

        </div>

        <div class="card-body">				
			<div class="row mb-5">
				<div class="col-xs-12 col-sm-12 col-lg-12">
					<label class="mb-2">
						Técnico responsable de la entrevista
					</label>
					<select id="id_entrevistador" name="id_entrevistador" class="form-control" required>
					<option value="" disabled selected>Seleccione tecnico .... &nbsp;</option>
					<?php
					$registro  = mysqli_query($con, "SELECT id_usuario, nombre_usuario FROM usuarios WHERE estado = 'a' AND id_usuario not in (2,4) ORDER BY nombre_usuario asc");
					while ($fila = mysqli_fetch_array($registro)) {
						?>
					<option value=<?php echo $fila[0] ?> ><?php echo strtoupper($fila[1]) ?></option>
					<?php
					}
					?>
					</select>
				</div>
			</div>
				
			<div class="row mb-5">
				<div class="col-xs-12 col-sm-12 col-lg-12"> 
					<label class="mb-2">
						Emprendedor registrado en PROACCER
					</label>
					<select id="id_solicitante" name="id_solicitante" class="form-control" required>
					<option value="" disabled selected>Seleccione solicitante .... &nbsp;</option>
					<?php
					$registro  = mysqli_query($con, "SELECT DISTINCT t1.id_solicitante, t1.apellido, t1.nombres
					FROM solicitantes t1
					INNER JOIN habilitaciones t2 ON t1.id_solicitante = t2.id_solicitante
					INNER JOIN registro_solicitantes t3 ON t1.id_solicitante = t3.id_solicitante
					LEFT JOIN proaccer_inscripcion t4 ON t1.id_solicitante = t4.id_solicitante
					LEFT JOIN proaccer_seguimientos t5 ON t4.id = t5.id_proyecto
					WHERE t1.id_responsabilidad = 1 AND (t2.id_programa = 2 OR t2.id_programa is NULL) 
					AND t2.habilitado = 1 AND (t5.resultado_final > 49 OR t5.resultado_final IS NULL)
					ORDER BY t1.apellido, t1.nombres");
					while ($fila = mysqli_fetch_array($registro)) {
						?>
						<option value=<?php echo $fila[0] ?> ><?php echo strtoupper($fila[1]).', '.strtoupper($fila[2]) ?></option>
					<?php
					}
					?>
					</select>
				</div>
			</div>
				
			<div class="row mb-5">
				<div class="col-xs-12 col-sm-12 col-lg-12">
					<label class="mb-2">
						1) Describir <b>Tipo de Emprendendimiento</b>
					</label>
					<textarea id="tipoemprendimiento" name="tipoemprendimiento" type="text" class="form-control" required placeholder="Industrial, AgroIndustrial, etc ..."></textarea>
				</div>
			</div>
				
			<div class="row mb-5">
				<div class="col-xs-12 col-sm-12 col-lg-12">
					<label class="mb-2">
						2) Describir <b>Productos a ofrecer en eventos</b>
					</label>
					<textarea id="productos" name="productos" type="text" class="form-control" required placeholder="Packaging, fragmentación, precios, etc ..."></textarea>
				</div>
			</div>	
		
			<div class="row mb-5">
				<div class="col-xs-12 col-sm-12 col-lg-12">
					<label class="mb-2">
						3) Describir <b>Figura Legal</b>
					</label>
					<select id="id_formajuridica" name="id_formajuridica" size="1" class="form-control">
						<option value="" disabled selected></option>
						<?php
						$tipo_sociedades = "select id_forma, forma from tipo_forma_juridica order by forma";
						$registro = mysqli_query($con, $tipo_sociedades);
						while ($fila = mysqli_fetch_array($registro)) {
							echo "<option value=\"".$fila[0]."\">".$fila[1]."</option>\n";
						}
						?>
					</select>
				</div>
			</div>
			
			<div class="row mb-5">
				<div class="col-xs-12 col-sm-12 col-lg-12">
					<label class="mb-2">
						4) Describir <b>Inscripciones a organismos dedicados al comercio</b> (solicitar constancias de dichas inscripciones en formato papel).
					</label>
					<textarea id="inscripcion" name="inscripcion" type="text" class="form-control" required placeholder="Impositivos, Cámaras de Comercios, etc ..."></textarea>
				</div>
			</div>
		
			<div class="row mb-5">
				<div class="col-xs-12 col-sm-12 col-lg-12">
					<label class="mb-2">
						5) Objetivos que le interesa trabajar al emprendedor
					</label>
					<textarea id="objetivos" name="objetivos" type="text" class="form-control" required placeholder="Enúncielos "></textarea>
				</div>
			</div>
		
			<div class="row mb-5">
				<div class="col-xs-12 col-sm-12 col-lg-12">
					<label class="mb-2">
						<p>6) Describir <b>Ferias y Eventos</b> referidos al emprendimiento. <br></p>
					</label>
					<small>
						Lo consignado en este apartado no tiene carácter de aprobación previa por parte del técnico o profesional asesor de los gastos consignados como posibles en el apartado en el requerimiento logístico / material gráfico. La definición de los mismos surgirá a partir del trabajo de asesoramiento realizado, y en todos los casos
						será necesario para su aprobación la presentación de la documentación contable y jurídica para habilitarla. Ésto se realizará en el marco de la presentación de la presentación del plan de acción específico definida de manera conjunta entre el emprendedor y el asesor, conforme se detalla en el Anexo I - Apartado "Implementaciómn - IV.
						Desarrollo de plan específico y suscripción de convenio". 

						<p class="mt-2 font-weight-bold">Nombre feria / evento - Fecha - Localidad - Requerimiento logístico / material gráfico </p>
					</small>

					<textarea id="feriaseventos" name="feriaseventos" type="text" class="form-control" required placeholder="Complete por favor ... "></textarea>
				</div>
			</div>

			<div class="row mb-5">
				<div class="col-xs-12 col-sm-12 col-lg-12">
					<label class="mb-2">
						7)<i class="fa fa-file-pdf-o" aria-hidden="true"></i> Archivo Informe
					</label>                
					<input id="adjunto" name="adjunto" type="file" class="form-control" accept="application/pdf" />
				</div>
			</div>
					
		</div>

		<div class=" card-footer">
			<div class="row mb-5">
				<div class="col">
					<input type="reset" value="Limpiar" class="btn btn-secondary">
				</div>
				<div class="col text-right">
					<input type="submit" value="Guardar" class="btn btn-info">
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
    require_once('../accesorios/admin-inferior.php');  ?>
