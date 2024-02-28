<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('location:../accesorios/salir.php');
    exit;
}

require_once('../accesorios/accesos_bd.php');

$con = conectar();

$tabla_evaluaciones = mysqli_query(
    $con,
    "SELECT t1.id_proyecto, t1.id_estado, t5.apellido, t5.nombres, t1.denominacion, t2.icono, t1.monto, t6.nombre as ciudad, t7.nombre as depto, t8.resultado_final, t5.dni, t3.tipo as sector, rubro, t3.id_rubro, t6.id as id_localidad, t1.fnovedad as fechan, informe, t1.latitud, t1.longitud, t1.funciona, t8.ultima_fecha as fechae
        FROM proyectos t1
        INNER JOIN tipo_estado t2 ON t1.id_estado = t2.id_estado
        INNER JOIN tipo_rubro_productivos t3 ON t1.id_rubro = t3.id_rubro
        LEFT JOIN  rel_proyectos_solicitantes t4 ON t1.id_proyecto = t4.id_proyecto
        LEFT JOIN  solicitantes t5 ON t4.id_solicitante = t5.id_solicitante
        INNER JOIN localidades t6 ON t5.id_ciudad = t6.id
        INNER JOIN departamentos t7 ON t6.departamento_id = t7.id
        LEFT JOIN proyectos_seguimientos t8 ON t1.id_proyecto = t8.id_proyecto
        WHERE t5.id_responsabilidad = 1 AND t1.id_estado > 0 AND t1.id_estado != 25
        ORDER BY t5.apellido, t5.nombres");

?>


<script type="text/javascript">
    $(document).ready(function() {

        var table = $('#proyectos').DataTable({
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "Todos"]
            ],
            "dom": '<"wrapper"Brflitp>',
            "buttons": ['copy', 'excel', 'pdf', 'colvis'],
            "order": [
                [1, "asc"]
            ],
            "stateSave": true,
            "columnDefs": [{}, ],
            "language": {
                "url": "../public/DataTables/spanish.json"
            }
        });

    });

    function eliminar(id, soli) {
        if (confirm('Elimina Informe de ' + soli + ' ?')) {
            window.location = 'Eliminar_Informe.php?id=' + id + '&solicitante=' + soli;
        }

    }
</script>

<div class="table-responsive">
    <table class="table table-striped table-hover table-condensed nowrap" style="font-size: small" id="proyectos">
        <thead>
            <th>Titular</th>
            <th><i class="fas fa-user-friends" title="Cantidad de asociados"></i> </th>
            <th>#Nro</th>
            <th>Denominacion</th>
            <th>Monto</th>
            <th>Sec.</th>
            <th>Rubro</th>
            <th title="Funciona el emprendimiento">Func</th>
            <th>Localidad</th>
            <th>Departamento</th>
            <th>Lat </th>
            <th>Long </th>
            <th>I</th>
            <th style="width:auto">Fecha</th>
            <th>Obs</th>
            <th>Estado</th>
            <th title="Puntaje Obtenido">P</th>
            <th title="Fecha Evaluación">Fecha</th>
            <th><i class="fas fa-th-list"></i></th>
            <th><i class="fas fa-print"></i></th>
            <th><i class="far fa-eye"></i></th>
            <th><i class="fas fa-exclamation-triangle"></i></th>
            <th>FI</th>
        </thead>
        <tbody>
            <?php

            while ($registro =  mysqli_fetch_array($tabla_evaluaciones, MYSQLI_BOTH)) {

                $solicitante = substr($registro['apellido'] . ', ' . $registro['nombres'], 0, 25);
                $id_proyecto = $registro['id_proyecto'];

                //NROS DE SOLICITANTES
                $query_solicitantes = mysqli_query($con, "select count(id_solicitante) from rel_proyectos_solicitantes where id_proyecto = $id_proyecto");
                $registro_soli      = mysqli_fetch_array($query_solicitantes, MYSQLI_BOTH);
                //
                // DNI SOLICITANTES
                //
                $dni = $registro['dni'];
                $tabla_proyectos = mysqli_query($con, "select te.icono
            from expedientes as exp, rel_expedientes_emprendedores as ree, emprendedores as emp, tipo_estado as te, tipo_rubro_productivos as rp
            where exp.id_expediente = ree.id_expediente and ree.id_emprendedor = emp.id_emprendedor and emp.dni = $dni
            and exp.estado = te.id_estado and exp.id_rubro = rp.id_rubro
            order by emp.apellido,emp.nombres asc");
                $registro_proy = mysqli_fetch_array($tabla_proyectos, MYSQLI_ASSOC);
                if ($registro) {
                    $icono = $registro_proy['icono'];
                } else {
                    $icono = NULL;
                }
            ?>
                <tr>
                    <td>
                        <?php echo $solicitante ?>
                    </td>
                    <td class="text-center">
                        <?php echo $registro_soli[0] ?>
                    </td>
                    <td>
                        <?php echo str_pad($id_proyecto, 4, '0', STR_PAD_LEFT) ?>
                    </td>
                    <td>
                        <?php echo strtoupper($registro['denominacion']) ?>
                    </td>
                    <td class=" text-right">
                        <?php echo number_format($registro['monto'], 0, ',', '.') ?>
                    </td>
                    <td class="text-center">
                        <?php
                        if ($registro['sector'] == 0) {
                            echo 'A <i class="fas fa-tractor"></i>';
                        } else {
                            echo 'I <i class="fas fa-industry"></i>';
                        }
                        ?>
                    </td>
                    <td>
                        <?php echo $registro['rubro'] ?>
                    </td>
                    <td>
                        <?php echo $registro['funciona'] ?>
                    </td>
                    <td>
                        <?php echo $registro['ciudad'] ?>
                    </td>
                    <td>
                        <?php echo $registro['depto'] ?>
                    </td>
                    <td>
                        <?php echo substr($registro['latitud'], 0, 6) ?>
                    </td>
                    <td>
                        <?php echo substr($registro['longitud'], 0, 6) ?>
                    </td>
                    <td class="text-center">
                        <?php
                        if (isset($registro['informe'])) { ?>
                            <!-- Tiene Informe -->
                            <a href="../evaluaciones/informes/<?php echo $registro['informe'] ?>">
                                <i class="fa fa-folder-open" aria-hidden="true" title="Ver informe"></i>
                            </a>

                            <a onclick="eliminar(<?php echo $registro['id_proyecto'] ?>,'<?php echo $solicitante ?>')">
                                <i class="fas fa-eraser" title="Eliminar informe de <?php echo $solicitante ?>"></i>
                            </a>

                        <?php
                        } else { ?>
                            <!-- No tiene Informe -->
                            <a href="../evaluaciones/Agregar_Informe.php?IdProyecto=<?php echo $registro['id_proyecto'] ?>&solicitante=<?php echo $solicitante ?>"><i class="fa fa-paperclip" aria-hidden="true" title="Agregar Informe Técnico"></i> </a>
                        <?php
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if (isset($registro['fechan'])) {
                            echo date('Y-m-d', strtotime($registro['fechan']));
                        } else {
                            echo '';
                        }
                        ?>
                    </td>
                    <td class="text-center">
                        <?php echo $icono ?>
                    </td>
                    <td class="text-center">
                        <?php echo $registro['icono'] ?>
                    </td>
                    <td class="text-center">
                        <span class=" badge badge-secondary">
                            <?php echo $registro['resultado_final'] ?>
                        </span>
                    </td>
                    <td>
                        <?php

                        if (isset($registro['fechae'])) {
                            echo  date("Y-m-d", strtotime($registro['fechae']));
                        } else {
                            echo '';
                        }
                        ?>

                    </td>
                    <?php
                    switch ($registro['id_estado']) {
                        case 24:                    // PROYECTO ENVIADO
                            {   ?>
                                <td class="text-center">
                                    <a href="../evaluaciones/Agregar_Evaluacion.php?IdProyecto=<?php echo $registro['id_proyecto'] ?>&solicitante=<?php echo $solicitante ?>">
                                        <i class="fas fa-th-list"></i>
                                    </a>
                                </td>
                                <td class="text-center">
                                    &nbsp;
                                </td>
                                <td class="text-center">
                                    <a href="../impresion/imprimirProyecto.php?IdProyecto=<?php echo $registro['id_proyecto'] ?>">
                                        <i class="far fa-eye"></i>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <?php
                                    if ($_SESSION['tipo_usuario'] == 'c') { ?>
                                        <a href="#" onClick="eliminar_proy(<?php echo $registro['id_proyecto'] ?>,'<?php echo substr($registro['apellido'] . ', ' . $registro['nombres'], 0, 25) ?>')">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </a>
                                </td>
                            <?php
                                    }
                                    break;
                                }
                            case 22:                    // PROYECTO RECHAZADO
                                {   ?>
                            <td class="text-center">
                                <a href="../evaluaciones/Modificar_Evaluacion.php?IdProyecto=<?php echo $registro['id_proyecto'] ?>&solicitante=<?php echo $solicitante ?>">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <a href="../evaluaciones/ImprimirEvaluacion.php?IdProyecto=<?php echo $registro['id_proyecto'] ?>">
                                    <i class="fas fa-print"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <a href="../impresion/imprimirProyecto.php?IdProyecto=<?php echo $registro['id_proyecto'] ?>">
                                    <i class="far fa-eye"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <?php
                                    if ($_SESSION['tipo_usuario'] == 'c') { ?>
                                    <a href="#" onClick="eliminar_proy(<?php echo $registro['id_proyecto'] ?>,'<?php echo substr($registro['apellido'] . ', ' . $registro['nombres'], 0, 25) ?>')"> <i class="fas fa-exclamation-triangle"></i></a>
                            </td>
                        <?php
                                    }
                                    break;
                                }
                            case 23:                    // PROYECTO APROBADO
                                {   ?>
                        <td class="text-center">
                            <a href="../evaluaciones/Modificar_Evaluacion.php?IdProyecto=<?php echo $registro['id_proyecto'] ?>&solicitante=<?php echo $solicitante ?>">
                                <i class="fas fa-edit"></i></span>
                            </a>
                        </td>
                        <td class="text-center">
                            <a href="../evaluaciones/ImprimirEvaluacion.php?IdProyecto=<?php echo $registro['id_proyecto'] ?>">
                                <i class="fas fa-print"></i>
                            </a>
                        </td>
                        <td class="text-center">
                            <a href="../impresion/imprimirProyecto.php?IdProyecto=<?php echo $registro['id_proyecto'] ?>">
                                <i class="far fa-eye"></i>
                            </a>
                        </td>
                        <td class="text-center">
                            <?php
                                    if ($_SESSION['tipo_usuario'] == 'c') { ?>
                                <a href="#" onClick="eliminar_proy(<?php echo $registro['id_proyecto'] ?>,'<?php echo substr($registro['apellido'] . ', ' . $registro['nombres'], 0, 25) ?>')">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </a>
                        </td>
                    <?php
                                    }
                                    break;
                                }
                            default: {
                    ?>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
        <?php
                                }
                        }
        ?>
        <td class="text-center">
            <?php
                if ($registro['id_estado'] == 23) { ?>
                <a href="../expedientes/su_expediente_nuevo_financiado.php?solicitante=<?php echo $solicitante ?>&IdProyecto=<?php echo $registro['id_proyecto'] ?>&IdRubro=<?php echo $registro['id_rubro'] ?>&rubro=<?php echo $registro['rubro'] ?>&IdLocalidad=<?php echo $registro['id_localidad'] ?>&localidad=<?php echo $registro['ciudad'] ?>" title="Financia Proyecto y pasa a Expediente ">
                    FI
                </a>
            <?php
                } else {
                    echo '&nbsp;';
                }
            ?>
        </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
        <tfoot>

        </tfoot>
    </table>
</div>

<?php mysqli_close($con);
