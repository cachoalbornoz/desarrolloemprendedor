	<?php 
	include $_SERVER['DOCUMENT_ROOT'] .'/desarrolloemprendedor/accesorios/header.php' ; 

	require_once($_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/accesorios/accesos_bd.php');
	$con=conectar();
	?>

		<style>
		
		</style>

		<?php include $_SERVER['DOCUMENT_ROOT'] .'/desarrolloemprendedor/accesorios/programas_desarrollo.php' ?>
		
		<div class="row">
			<div class="col text-center">
				<img src="/desarrolloemprendedor/public/imagenes/semanaemp.png" class="img-fluid"/>
			</div>
		</div>	
        
		
		<div class="row mb-3">
			<div class="col-xs-12 col-sm-12 col-lg-12">
				<h4 style="color: #7373F9;">SEMANA DEL EMPREDEDURISMO 2020</h4>
			</div>
		</div>

		<div class="row mb-5">
			<div class="col-xs-12 col-sm-12 col-lg-12">
                <p>
                    En la Semana del Emprendedurismo 2020 te invitamos a celebrar y a ser parte de las distintas actividades en Entre Ríos.
                </p>    

                <p>
                La edición 2020 contará con actividades que apuntan a potenciar el desarrollo del emprendedurismo local; visualizar el trabajo de emprendedores y emprendedoras de la provincia a través de rondas de negocios; y generar encuentros entre representantes de emprendimientos y empresas a fin de compartir recorridos y desafíos.
                </p>

			</div>
		</div>
        
        <div class="row">
			<div class="col-xs-12 col-sm-12 col-lg-12 col-sm-12 col-lg-12">
				<br>
			</div>
		</div>
        
        
        <div class="row">
			<div class="col-xs-12 col-sm-12 col-lg-12 col-sm-12 col-lg-12">
				<h4 style="color:#9968bc">CAPACITACIONES</h4>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-lg-12 col-sm-12 col-lg-12">
				<p class="m-3">
                    <li> Diseño industrial e innovación | Martes 17 de noviembre | 18hs </li>
				</p>
				<p class="m-3">
                    <li> Primeros pasos para la exportación | Jueves 19 de noviembre | 15hs </li>
				</p>
			</div>
		</div>
        
        <div class="row mt-2">
			<div class="col-xs-12 col-sm-12 col-lg-12 col-sm-12 col-lg-12">
                <a href="/desarrolloemprendedor/frontend/registro.php">
                    ¡Inscribite!
                </a>
			</div>
		</div>
        
        <div class="row mt-3 mb-5">
			<div class="col-xs-12 col-sm-12 col-lg-12 col-sm-12 col-lg-12">
				<br>
			</div>
		</div>
        
        
        <div class="row mb-2">
			<div class="col-xs-12 col-sm-12 col-lg-12 col-sm-12 col-lg-12">
				<h4 style="color: #4FCFF7;">CONCURSO #YoEmprendo</h4>
			</div>
		</div>
        
        <div class="row">
			<div class="col-xs-12 col-sm-12 col-lg-12 col-sm-12 col-lg-12">
				<p>
                    Mirá las bases y condiciones para participar. <a href="/desarrolloemprendedor/frontend/yoemprendo.php">Haz click aquí</a>
				</p>
			</div>
		</div>
        
        
        <div class="row mt-5 mb-5">
			<div class="col-xs-12 col-sm-12 col-lg-12 col-sm-12 col-lg-12">
				&nbsp;
			</div>
		</div>

		<?php

        $contador = 1;
        $tabla_agenda = mysqli_query($con, "SELECT * FROM agenda ORDER BY fecha asc");
        
        
		if(mysqli_num_rows($tabla_agenda) > 0){

			while($fila = mysqli_fetch_array($tabla_agenda)){
            
			?>	
			<div class="row mb-2">
				<div class="col-xs-12 col-sm-12 col-lg-12 col-sm-12 col-lg-12">

					<div class="table-responsive">

						<table class="table table-hover table-bordered" style="height: 100px;">
							<tr class="font-weight-bold" style="background-color: #e2e2e2;">
								<td class=" text-center" style="width: 200px;"> 
                                    <img src="/desarrolloemprendedor/public/imagenes/<?php echo $fila['logo'] ;?>" height="100px" width="100px"  class=" img-thumbnail"/>
								</td>
								<td class="text-center align-middle">
									<?php echo $fila['institucion'] ;?>
								</td>
							</tr>
							<tr>
								<td>
									Fecha y hora
								</td>
								<td>
								    <?php echo date('d/m/Y', strtotime($fila['fecha'])) ; ?> <?php echo $fila['hora'].' Hs.' ;?>
								</td>
							</tr>
							<tr>
								<td>
									Actividad
								</td>
								<td>
									<?php echo $fila['actividad'] ;?>
								</td>
							</tr>
							<tr>
								<td>
									Breve descripción
								</td>
								<td>
									<?php echo $fila['descripcion'] ;?>
								</td>
							</tr>
							<tr>
								<td>
									Otros datos
								</td>
								<td>
                                    <i class="fas fa-phone-square-alt text-black-50"></i> <?php echo $fila['telefono'] ; ?> / <i class="fas fa-envelope text-black-50"></i> <?php echo $fila['mail']; ?>
								</td>
							</tr>
						</table>

					</div>
					
				</div>
			</div>    
            <?
            
            }
            
		}else{
			echo '';
        }        

        
        
		?>	

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-lg-12 col-sm-12 col-lg-12">
				<br/>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-lg-12 col-sm-12 col-lg-12">
				<br/>
			</div>
		</div>		
		
		<div class="row">
			<div class="col">
				<br/>
			</div>
		</div>

	
<?php include $_SERVER['DOCUMENT_ROOT'] .'/desarrolloemprendedor/accesorios/script.php' ; ?>

<script>

    $(document).ready(function() {

    });

</script>
	
<?php include $_SERVER['DOCUMENT_ROOT'] .'/desarrolloemprendedor/accesorios/footer.php';?>