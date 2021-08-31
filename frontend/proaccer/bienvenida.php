<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header('location:../accesorios/salir.php');
    exit;
}


require_once($_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/frontend/accesorios/front-superior.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/accesorios/accesos_bd.php');
$con = conectar();


$id_usuario = $_SESSION['id_usuario'];

$id_estado  = 0;
$habilitado = 0;


$tabla          = mysqli_query($con, "SELECT id_solicitante FROM solicitantes WHERE id_solicitante = $id_usuario");
$registro       = mysqli_fetch_array($tabla);
$id_solicitante = $registro['id_solicitante'];

$tabla_habilitaciones = mysqli_query($con, "SELECT habilitado FROM habilitaciones WHERE id_programa = 1 AND id_solicitante = $id_solicitante");

if ($registro_habilitaciones = mysqli_fetch_array($tabla_habilitaciones)) {
    $habilitado = $registro_habilitaciones[0]; // 0 = NO ESTA HABILITADO - 1 = HABILITADO PARA SOLICITAR CREDITOS
}

$tabla_solicitantes = mysqli_query($con, "SELECT proy.id_estado, proy.id_proyecto, te.icono
    FROM rel_proyectos_solicitantes rel
    INNER JOIN proyectos proy on rel.id_proyecto = proy.id_proyecto
    INNER JOIN tipo_estado te on te.id_estado = proy.id_estado
    WHERE rel.id_solicitante = $id_solicitante");

if ($registro_solicitantes = mysqli_fetch_array($tabla_solicitantes)) {

    $id_estado  = $registro_solicitantes[0];
    $id_proyecto = $registro_solicitantes[1];
    $icono      = $registro_solicitantes[2];
}

if (isset($registro_solicitantes) and $id_estado > 0) {
    $tabla_solicitantes = mysqli_query($con, "SELECT proy.id_proyecto, proy.id_estado, icono, comentario, resultado_final
        FROM rel_proyectos_solicitantes rel
        INNER JOIN proyectos proy on rel.id_proyecto = proy.id_proyecto
        INNER JOIN tipo_estado est on proy.id_estado = est.id_estado
        INNER JOIN proyectos_seguimientos proy_segui on proy.id_proyecto = proy_segui.id_proyecto and rel.id_solicitante = $id_solicitante ");

    $registro_solicitantes = mysqli_fetch_array($tabla_solicitantes);

    if (isset($registro_solicitantes['id_estado'])) { // PREGUNTO TIENE NOTA CARGADA
        $id_estado  = $registro_solicitantes['id_estado'];
        $_SESSION['id_estado_proyecto'] = $id_estado;
        $icono = $registro_solicitantes['icono'];
        ############### AGREGO COMENTARIOS Y PUNTAJE DE LOS PROYECTOS EVALUADOS ###################
        if ($id_estado == 22 or $id_estado == 23) {
            $tabla_evaluacion = mysqli_query($con, "select comentario, resultado_final from proyectos_seguimientos WHERE id_proyecto = $id_proyecto");
            $registro_evaluacion = mysqli_fetch_array($tabla_evaluacion);
            if (isset($registro_evaluacion)) {
                $observacion = $registro_evaluacion['comentario'];
                $resultado_final = $registro_evaluacion['resultado_final'];
            }
            ########### FIN ##############
        }
    } else { // SI NO TIENE NOTA CARGADA

    }
} else {

    $id_estado = 0;
}


require_once($_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/frontend/accesorios/front-scripts.php');

?>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-lg-12">
        <br>
    </div>
</div>

<div class="card">
    <div class="card-header text-dark" style=" background-color: #c67d26;">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-lg-12 p-3">
                Programa Proaceer
            </div>
        </div>
    </div>

    <div class="card-body">

        <div class="row">
            <div class="col-xs-12 col-md-12 col-lg-12 p-3">

                <?php

                // USUARIO NO HABILITADO

                if ($habilitado == 0) { ?>

                    <div class="alert alert-info alert-dismissible">
                        Te llamaremos en la brevedad para habilitar el formulario.
                    </div>

                    <?php
                } else {

                    // SI ESTA HABILITADO Y RECIEN EMPIEZA A CARGAR (ESTADO = 0) ó VUELVE PARA CORREGIR (ESTADO = 20) ó DEVOLVIO TODA LA PLATA (ESTADO = 25)

                    if (($id_estado == 0) or ($id_estado == 20) or ($id_estado == 25)) { ?>

                        <div class="alert alert-dismissible" style="background-color: #c67d26; ">
                            <?php echo ucwords(strtolower($_SESSION['nombres'] . ' ' . $_SESSION['apellido'])); ?> </b>, estás habilitada /o
                        </div>

                <?php
                    }
                }


                if ($id_estado == 22) { // RECHAZADO
                    echo '
                        <div class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="icon fa fa-check"></i> Tu proyecto ha sido evaluado, al finalizar la convocatoria y corrección de todos los proyectos presentados, nos pondremos en contacto para informar quienes han sido los adjudicatarios del Crédito teniendo en cuenta los mayores puntajes. </br></br> Muchas Gracias por tu participación en el Programa
                        </div>';
                } else {
                    if ($id_estado == 23) { // APROBADO
                        echo '
                        <div class="alert alert-info alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="icon fa fa-check"></i> Tu proyecto ha sido evaluado, al finalizar la convocatoria y corrección de todos los proyectos presentados, nos pondremos en contacto para informar quienes han sido los adjudicatarios del Crédito teniendo en cuenta los mayores puntajes. </br></br> Muchas Gracias por tu participación en el Programa
                        </div>';
                    } else {
                        if ($id_estado == 24) { // ENVIADO
                            echo '
                            <div class="alert alert-info alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <i class="icon fa fa-check"></i> Enviado ! Tu proyecto se ha enviado correctamente, te informaremos por este medio el resultado obtenido.
                                &nbsp;
                                <a class="text-right" href="../../impresion/imprimirProyecto.php?IdProyecto=' . $id_proyecto . '">
                                    <i class="fas fa-print"></i> Imprimir proyecto
                                </a>
                            </div>';
                        }
                    }
                }
                ?>
            </div>
        </div>


        <div class="row pb-3">
            <div class="col-xs-12 col-sm-12 col-lg-12">
                <p>El Programa de Apoyo al Comercio Emprendedor de Entre Ríos acompaña, asesora y financia la
                    participación de emprendimientos o empresas entrerrianas en eventos específicos para impulsar la
                    ampliación de sus ventas. El programa apunta a una inserción en el mercado, que permita mejorar su
                    sustentabilidad y posibilidades de consolidación.
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-lg-12">
                <h5 style="color:#c67d26">Requisitos</h5>
                <p>
                    * Tener entre dieciocho (18) y cuarenta (40) años de edad
                </p>
                <p>
                    * Detentar domicilio real en la Provincia de Entre Ríos
                </p>
                <p>
                    * Realizar actividades vinculadas a la producción industrial y TICs, agropecuarios o de servicios
                    asociados a estos sectores.
                </p>
                <p>
                    * Estar inscripto/a en los organismos tributarios.
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-md-12 col-lg-12">
                &nbsp;
            </div>
        </div>

    </div>
</div>


<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/frontend/accesorios/front-inferior.php'); ?>