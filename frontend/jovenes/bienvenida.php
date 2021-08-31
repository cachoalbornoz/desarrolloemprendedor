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

$tabla          = mysqli_query($con, "SELECT id_solicitante, fecha_nac FROM solicitantes WHERE id_solicitante = $id_usuario");
if ($registro    = mysqli_fetch_array($tabla)) {

    $id_solicitante     = $registro['id_solicitante'];
    $fecha_nac          = $registro['fecha_nac'];
}


$tabla_habilitaciones = mysqli_query($con, "SELECT habilitado FROM habilitaciones WHERE id_programa = 1 AND id_solicitante = $id_solicitante");

if ($registro_habilitaciones = mysqli_fetch_array($tabla_habilitaciones)) {
    $habilitado = $registro_habilitaciones[0]; // 0 = NO ESTA HABILITADO - 1 = HABILITADO PARA SOLICITAR CREDITOS
}

$tabla_solicitantes = mysqli_query($con, "SELECT t2.id_proyecto, t2.id_estado, t3.icono
    FROM rel_proyectos_solicitantes t1
    INNER JOIN proyectos t2 on t1.id_proyecto = t2.id_proyecto
    INNER JOIN tipo_estado t3 on t2.id_estado = t3.id_estado
    WHERE t2.id_estado <> 25 AND t1.id_solicitante = $id_solicitante");

if ($registro_solicitantes = mysqli_fetch_array($tabla_solicitantes)) {

    $id_estado  = $registro_solicitantes['id_estado'];
    $id_proyecto = $registro_solicitantes['id_proyecto'];
    $icono      = $registro_solicitantes['icono'];
}

if (isset($registro_solicitantes) and $id_estado > 0) {

    $tabla_solicitantes = mysqli_query($con, "SELECT proy.id_proyecto, proy.id_estado, icono, comentario, resultado_final
    FROM rel_proyectos_solicitantes rel
    INNER JOIN proyectos proy on rel.id_proyecto = proy.id_proyecto
    INNER JOIN tipo_estado est on proy.id_estado = est.id_estado
    INNER JOIN proyectos_seguimientos proy_segui on proy.id_proyecto = proy_segui.id_proyecto 
    WHERE est.id_estado <> 25 AND id_solicitante = $id_solicitante ");

    $registro_solicitantes = mysqli_fetch_array($tabla_solicitantes);

    if (isset($registro_solicitantes['id_estado'])) { // PREGUNTO TIENE NOTA CARGADA

        $id_estado  = $registro_solicitantes['id_estado'];
        $_SESSION['id_estado_proyecto'] = $id_estado;
        $icono = $registro_solicitantes['icono'];

        ############### AGREGO COMENTARIOS Y PUNTAJE DE LOS PROYECTOS EVALUADOS ###################

        if ($id_estado == 22 or $id_estado == 23) {

            $tabla_evaluacion = mysqli_query($con, "SELECT comentario, resultado_final FROM proyectos_seguimientos WHERE id_proyecto = $id_proyecto");
            $registro_evaluacion = mysqli_fetch_array($tabla_evaluacion);
            if (isset($registro_evaluacion)) {
                $observacion = $registro_evaluacion['comentario'];
                $resultado_final = $registro_evaluacion['resultado_final'];
            }
            ########### FIN ##############
        }
    } else {

        // SI NO TIENE NOTA CARGADA

    }
} else {

    $id_estado = 0;
}

// CALCULAR LA EDAD
list($ano, $mes, $dia) = explode("-", $fecha_nac);
$ano_diferencia     = date("Y") - $ano;
$mes_diferencia     = date("m") - $mes;
$dia_diferencia     = date("d") - $dia;
if ($dia_diferencia < 0 || $mes_diferencia < 0)
    $ano_diferencia--;

// SI TIENE MAS DE 40 AÑOS
if ($ano_diferencia > 40) {

    $id_estado = 99; // EXCESO DE EDAD

}


require_once($_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/frontend/accesorios/front-scripts.php');

?>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-lg-12">
        <br>
    </div>
</div>

<div class="card mb-2">

    <div class="card-header text-white" style=" background-color: #1e5571;">

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-lg-12 p-3">
                Programa Jóvenes Emprendedores
            </div>
        </div>

    </div>

    <div class="card-body">

        <div class="row">
            <div class="col-xs-12 col-md-12 col-lg-12 p-3">

                <?php

                // USUARIO NO HABILITADO

                if ($habilitado == 0 and $id_estado <> 99) { ?>

                    <div class="alert alert-info alert-dismissible">
                        Te llamaremos en la brevedad para habilitar el formulario.
                    </div>

                    <?php
                } else {

                    // SI ESTA HABILITADO Y RECIEN EMPIEZA A CARGAR (ESTADO = 0) ó VUELVE PARA CORREGIR (ESTADO = 20) ó DEVOLVIO TODA LA PLATA (ESTADO = 25)

                    if (($id_estado == 0) or ($id_estado == 20) or ($id_estado == 25)) { ?>

                        <div class="alert alert-info alert-dismissible">
                            <b><?php echo ucwords(strtolower($_SESSION['nombres'] . ' ' . $_SESSION['apellido'])); ?> </b> estás habilitado, por favor completá el formulario desde
                            <a href="solicitud.php"> éste enlace <i class="fas fa-edit"></i> </a>
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
                        } else {
                            if ($id_estado == 99) { // EXCESO EDAD

                                echo '
                                    <div class="alert alert-warning alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <i class="icon fa fa-check"></i> No cumples con el requisito de edad solicitado. 
                                    </div>';
                            }
                        }
                    }
                }

                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 p-3">

                <p>El Programa Jóvenes Emprendedores asesora, capacita y financia a emprendimientos en marcha de
                    jóvenes residentes en Entre Ríos, con ideas de emprendimientos innovadores, sustentables y con
                    potencial para crecer.
                    Es una de las herramientas integrales que constituyen el Régimen de Promoción para el
                    Emprendedorismo Joven Entrerriano, creado por la ley provincial 10.394.
                    <br>
                    Registrate para acceder a los distintos programas vigentes, noticias, instancias de capacitación y
                    contacto con el equipo técnico de Jóvenes Emprendedores.
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <p class="m-3">
                    <b><span style="color:#1e5571;">Requisitos <?php echo date('Y') ?></span></b>
                    <br>
                <div class="m-3">
                    * Tener entre dieciocho (18) y cuarenta (40) años de edad.
                </div>
                <div class="m-3">
                    * Detentar domicilio real en la Provincia de Entre Ríos.
                </div>
                <div class="m-3">
                    * Realizar actividades vinculadas a la producción industrial y TICs, agropecuarios o de servicios.
                    asociados a estos sectores
                </div>
                <div class="m-3">
                    * Presentar un proyecto en funcionamiento con antigüedad demostrable mínima de 3 meses.
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-md-12 col-lg-12">
                <div class="embed-responsive embed-responsive-16by9">

                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-lg-12">
            <br>
        </div>
    </div>

    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/desarrolloemprendedor/frontend/accesorios/front-inferior.php'); ?>