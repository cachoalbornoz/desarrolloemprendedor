<?php include $_SERVER['DOCUMENT_ROOT'] .'/desarrolloemprendedor/accesorios/header.php' ; ?>

<?php include $_SERVER['DOCUMENT_ROOT'] .'/desarrolloemprendedor/accesorios/programas_desarrollo.php' ?>



<div class="row">
	<div class="col-xs-12 col-sm-12 col-lg-12">
		<br />
	</div>
</div>

<div class="row m-2">
	<div class="col-xs-12 col-sm-12 col-lg-12">
		<h4>ESTACION COWORKING</h4>
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
			La Estación Coworking de Concordia surge en 2021 como parte del Programa Encuentro Emprendedor y MiPyME (E3) de la Secretaría de Desarrollo Económico y Emprendedor de la provincia.
		</p>

		<p>
			La misma es impulsada por la Municipalidad de Concordia y cuenta con el apoyo de la Universidad Tecnológica Nacional (UTN) sede Concordia.
		</p>

		<p class="mt-5 m-3">
			<b>¿Dónde queda?</b> El espacio funciona en el Centro de Convenciones de Concordia.
		</p>
		<p class="m-3">
			<b>¿Qué propone?</b> Busca ser un punto de encuentro para emprendedores y MiPyMEs de Concordia y la región. También se brindan capacitaciones y talleres.
		</p>

	</div>
</div>


<div class="row mt-5 m-2">
	<div class="col-xs-12 col-sm-12 col-lg-12">
		<h5>Contacto</h5>
	</div>
</div>


<div class="row m-2">
	<div class="col-xs-12 col-sm-12 col-lg-12">
		<p>Instagram: <b>@laestacioncoworking </b> </p>
		<p>Mail: <b>coworkingconcordia@gmail.com </b> </p>
		<p>Celular: <b>3454036939</b></p>
	</div>
</div>

  


<div class="row mt-5 mb-5">
	<div class="col-xs-12 col-sm-12 col-lg-12">
		<br>
	</div>
</div>

<div class="row mt-5 mb-3">
	<div class="col-xs-12 col-sm-12 col-lg-12">

		<?php
                    require_once('../accesorios/conexion.php');

$con=conectar();

$registro   = $con->query("SELECT * FROM maestro_entidades WHERE id_entidad > 0 and estado = 0");

?>

		<div class="row mb-5">

			<?php

    $contador = 1;

while($fila = $registro->fetch_array()) {
    $foto  = (strlen($fila['foto'])>0)?'<img src="/desarrolloemprendedor/entidades/image/'.$fila['foto'].'" class="img-fluid shadow mb-3" height="100" width="100"/>':null;
    ?>
			<div class=" col-xs-12 col-sm-4 col-lg-4 my-auto text-center">
				<a href="<?php echo $fila['url'] ?>" target="_blank">
					<?php echo $foto ?>
					<p><?php echo $fila['entidad'] ?></p>
				</a>
			</div>

			<?php
        $contador ++;

    if($contador >= 4) {
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
		<br />
	</div>
</div>

<div class="row">
	<div class="col-xs-12 col-sm-12 col-lg-12">
		<br />
	</div>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-lg-12">
		<br />
	</div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] .'/desarrolloemprendedor/accesorios/script.php' ; ?>

<?php include $_SERVER['DOCUMENT_ROOT'] .'/desarrolloemprendedor/accesorios/footer.php' ; ?>