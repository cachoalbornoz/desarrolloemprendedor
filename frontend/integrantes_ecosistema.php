<?php include $_SERVER['DOCUMENT_ROOT'] .'/desarrolloemprendedor/accesorios/header.php' ; ?>

		<?php include $_SERVER['DOCUMENT_ROOT'] .'/desarrolloemprendedor/accesorios/programas_desarrollo.php' ?>

		<div class="row">
			<div class="col text-center">
				<img src="/desarrolloemprendedor/public/imagenes/prog_jovenes.png" class="img-fluid"/>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-lg-12">
				<br/>
			</div>
		</div>

		<div class="row m-2">
			<div class="col-xs-12 col-sm-12 col-lg-12">
				<h4>ENTIDADES INTEGRANTES DEL GRUPO EMPRENDEDOR</h4>
			</div>
		</div>
		<div class="row m-2">
			<div class="col-xs-12 col-sm-12 col-lg-12">
				<hr>
			</div>
		</div>

		<div class="row m-2">
			<div class="col-xs-12 col-sm-12 col-lg-12">
				<p>
				</p>
			</div>
		</div>


		<div class="row">
			<div class="col-xs-12 col-sm-12 col-lg-12">
				<br>
			</div>
		</div>

		<div class="row mb-3">
            <div class="col-xs-12 col-sm-12 col-lg-12">

				<?php
					require_once('../accesorios/conexion.php');

					$con=conectar();

					$registro   = $con->query("SELECT * FROM maestro_entidades WHERE id_entidad > 0 and estado = 0");

				?>

                <div class="row mb-5">

					<?php

					$contador = 1;

					while($fila = $registro->fetch_array()){
						$foto  = (strlen($fila['foto'])>0)?'<img src="/desarrolloemprendedor/entidades/image/'.$fila['foto'].'" class="img-fluid shadow mb-3" height="100" width="100"/>':NULL;
					?>
						<div class=" col-xs-12 col-sm-4 col-lg-4 my-auto text-center">
							<a href="<?php echo $fila['url'] ?>" target="_blank" >
								<?php echo $foto ?>
								<p><?php echo $fila['entidad'] ?></p>
							</a>
						</div>

					<?php
						$contador ++;

						if($contador >= 4){
							$contador = 1;
							echo '</div>' ;
							echo '<div class="row mb-5">';
						}
					}
					?>
                </div>
				<?php

					mysqli_close($con);

				?>
            </div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-lg-12">
				<br/>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-lg-12">
				<br/>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-lg-12">
				<br/>
			</div>
		</div>

		<?php include $_SERVER['DOCUMENT_ROOT'] .'/desarrolloemprendedor/accesorios/script.php' ; ?>

		<?php include $_SERVER['DOCUMENT_ROOT'] .'/desarrolloemprendedor/accesorios/footer.php' ; ?>
