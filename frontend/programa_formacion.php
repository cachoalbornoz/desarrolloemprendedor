	<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/accesorios/header.php';

    require_once($_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/accesorios/accesos_bd.php');
    $con = conectar();
    ?>

	<style>
.cursado {
    background-image: url('/desarrolloemprendedor/public/imagenes/inscripciones_insc_formacion_c.jpeg');
    background-repeat: no-repeat;
    background-size: cover;
    opacity: 0.6;

}
	</style>

	<?php include $_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/accesorios/programas_desarrollo.php' ?>

	<div class="row">
	    <div class="col text-center">
	        <img src="/desarrolloemprendedor/public/imagenes/prog_formacion.png" class="img-fluid" />
	    </div>
	</div>

	<div class="row">
	    <div class="col-xs-12">
	        <br />
	    </div>
	</div>

	<div class="row">
	    <div class="col-xs-12">
	        <br />
	    </div>
	</div>

	<div class="row">
	    <div class="col-xs-12 col-sm-12 col-lg-12">
	        <h4 style="color:#9968bc">PROGRAMA DE FORMACION EMPRENDEDORA Y FORTALECIMIENTO MiPyME</h4>
	    </div>
	</div>

	<div class="row">
	    <div class="col-xs-12 col-sm-12 col-lg-12">
	        <p class="m-3">
	            El Programa de Formación Emprendedora y Fortalecimiento MiPyme impulsa <b>capacitaciones, talleres, seminarios, y jornadas</b> enfocadas en el desarrollo de actitudes y aptitudes para la consolidación del empredorismo y crecimiento de Mipymes en Entre Ríos.
	        </p>
	        <p class="m-3">
	            Los encuentros son de participación gratuita, organizados de manera conjunta con instituciones públicas y privadas del ecosistema
	            emprendedor y tienen lugar en todos los departamentos de la provincia.
	        </p>
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

	<div class="row">
	    <div class="col-xs-12 col-sm-12 col-lg-12">
	        <p>FORMACIONES DISPONIBLES</p>
	    </div>
	</div>

	<?php

    $contador = 1;
    $tabla_cursos = mysqli_query($con, "SELECT * FROM formacion_cursos WHERE activo = 1 ORDER BY fechaRealizacion asc");

    if (mysqli_num_rows($tabla_cursos) > 0) {

        while ($fila = mysqli_fetch_array($tabla_cursos)) {

    ?>
	<div class="row mb-2">
	    <div class="col-xs-12 col-sm-12 col-lg-12">

	        <div class="table-responsive">

	            <table class="table table-condensed table-hover table-bordered">
	                <tr class=" text-white font-weight-bold" style="background-color:#9968bc">
	                    <td>
	                        Nombre curso
	                    </td>
	                    <td class="text-center">
	                        <?php echo $fila['nombre'] ?>
	                    </td>
	                </tr>
	                <tr>
	                    <td>
	                        Hora
	                    </td>
	                    <td>
	                        <?php echo date('d/m/Y', strtotime($fila['fechaRealizacion'])) ?> <?php echo $fila['hora'] . ' Hs.' ?>
	                    </td>
	                </tr>
	                <tr>
	                    <td>
	                        Lugar
	                    </td>
	                    <td>
	                        <?php echo $fila['lugar'] ?>
	                    </td>
	                </tr>
	                <tr>
	                    <td>
	                        Reseña
	                    </td>
	                    <td>
	                        <?php echo $fila['resenia'] ?>
	                    </td>
	                </tr>
	                <tr>
	                    <td>
	                        Destinatarios
	                    </td>
	                    <td>
	                        <?php echo $fila['destinatarios'] ?>
	                    </td>
	                </tr>
	                <tr>
	                    <td colspan="2" class="text-right bg-secondary">
	                        <a data-toggle="modal" href="#inscribiteModal" class="text-white">
	                            Inscribite
	                        </a>
	                    </td>
	                </tr>
	            </table>

	        </div>

	    </div>
	</div>
	<?php
        }

    } else {
        echo '';
    }

    ?>

	<div class="row">
	    <div class="col-xs-12 col-sm-12 col-lg-6 favenir text-center mt-5">
	        <a data-toggle="modal" href="#emprendedorModal" class="text-dark">
	            <img src="/desarrolloemprendedor/public/imagenes/formacion-chica.png" class="img-fluid shadow mb-4" />

	            <h5>Estos son nuestros cursos</h5>
	        </a>
	    </div>
	    <div class="col-xs-12 col-sm-12 col-lg-6 favenir text-center mt-5">
	        <a data-toggle="modal" href="#institucionModal" class="text-dark">
	            <img src="/desarrolloemprendedor/public/imagenes/formacion-mesa.png" class="img-fluid shadow mb-4" />

	            <h5>Soy una institución pública / privada</h5>
	        </a>
	    </div>
	</div>

	<div class="row">
	    <div class="col">
	        <br />
	    </div>
	</div>


	<div class="row">
	    <div class="col">
	        <br />
	    </div>
	</div>

	<!-- Modal form to add -->
	<div id="emprendedorModal" class="modal fade" role="dialog">
	    <div class="modal-dialog modal-lg">
	        <div class="modal-content">
	            <div class="modal-header">
	                <div class="row mt-3 mb-5">
	                    <div class="col-xs-12 col-sm-12 col-lg-12">
	                        <a id="registro" href="/desarrolloemprendedor/frontend/registro.php">
	                            <i class="fas fa-edit"></i>
	                            Registrate aquí
	                        </a>
	                        y hacé el curso que más te guste
	                    </div>
	                </div>
	                <button type="button" class="close" data-dismiss="modal">×</button>
	            </div>
	            <div class="modal-body m-3">

	                <div class="row mt-3 mb-5">
	                    <div class="col-xs-12 col-sm-12 col-lg-12">
	                        <img src="/desarrolloemprendedor/public/imagenes/inscripciones_insc_formacion_c.jpeg" class="img-fluid shadow" />
	                    </div>
	                </div>

	                <table class="table table-striped table-hover" style="font-size: 0.8em;">
	                    <?php
                        $tabla_cursos     = mysqli_query($con, "SELECT * FROM tipo_formacion WHERE activo = 1");
                        while ($fila     = mysqli_fetch_array($tabla_cursos)) {
                        ?>
	                    <tr>
	                        <td>
	                            <?php echo $fila['formacion'] ?>
	                        </td>
	                    </tr>
	                    <?php
                        }
                        ?>
	                </table>

	            </div>

	            <div class="modal-footer">
	                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
	            </div>

	        </div>
	    </div>
	</div>
	<!-- Fin Modal form -->

	<!-- Modal form to add -->
	<div id="institucionModal" class="modal fade" role="dialog">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <div class="row mt-3 mb-5">
	                    <div class="col-xs-12 col-sm-12 col-lg-12">
	                        SOY INSTITUCION
	                    </div>
	                </div>
	                <button type="button" class="close" data-dismiss="modal">×</button>
	            </div>
	            <div class="modal-body">

	                <form class="form-horizontal" method="post" id="contacto">
	                    <div class="row mt-3">
	                        <div class="col-xs-12 col-sm-12 col-lg-12">
	                            <img src="/desarrolloemprendedor/public/imagenes/emergente-institucion.jpeg" class="img-fluid" />
	                        </div>
	                    </div>
	                </form>

	            </div>

	            <div class="modal-footer">
	                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
	            </div>

	        </div>
	    </div>
	</div>
	<!-- Fin Modal form -->

	<!-- Modal form to add -->
	<div id="inscribiteModal" class="modal fade" role="dialog">
	    <div class="modal-dialog">
	        <div class="modal-content ">
	            <div class="modal-header cursado">
	                <div class="row mt-3 mb-5">
	                    <div class="col-xs-12 col-sm-12 col-lg-12">
	                        &nbsp;
	                    </div>
	                </div>
	                <button type="button" class="close" data-dismiss="modal">×</button>
	            </div>
	            <div class="modal-body">

	                <div class="row mt-3 mb-5">
	                    <div class="col-xs-12 col-sm-12 col-lg-12">
	                        <h5 class="border border-secondary text-center p-3"> Quiero hacer un curso </h5>
	                    </div>
	                </div>
	                <div class="row mt-3">
	                    <div class="col-xs-12 col-sm-12 col-lg-12">
	                        <p class="p-3">
	                            * Si ya tenés usuario, ingresá <a href="/desarrolloemprendedor/ingresar/" class=" btn btn-link">aquí</a> y elegí <br>
	                            la capacitación de tu interés, en el menú <i class="fab fa-leanpub text-black-50"></i> Formación.
	                        </p>

	                        <p class="p-3">
	                            *Si <b>no tenés</b> usuario, <a id="registro" href="/desarrolloemprendedor/frontend/registro.php"> <i class="fas fa-edit"></i> registrate</a> por favor.
	                        </p>

	                    </div>
	                </div>

	                <div class="row mt-3 mb-5">
	                    <div class="col-xs-12 col-sm-12 col-lg-12">
	                        &nbsp;
	                    </div>
	                </div>



	            </div>

	            <div class="modal-footer">
	                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
	            </div>

	        </div>
	    </div>
	</div>
	<!-- Fin Modal form -->


	<?php include $_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/accesorios/script.php'; ?>

	<script>
$(document).ready(function() {

});
	</script>

	<?php include $_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/accesorios/footer.php'; 