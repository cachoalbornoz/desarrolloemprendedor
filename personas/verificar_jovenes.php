<?php
require_once("../accesorios/accesos_bd.php");
$con = conectar();

$dni                = $_POST['dni'];

$tabla_proyectos    = mysqli_query($con, "SELECT t8.id_proyecto, t8.denominacion, rubro, t10.estado, t10.icono, t2.observacionesp, t8.id_estado, t8.update_at
    FROM solicitantes t1
    INNER JOIN registro_solicitantes t2 ON t1.id_solicitante = t2.id_solicitante
    INNER JOIN tipo_rubro_productivos t3 ON t2.id_rubro = t3.id_rubro
    INNER JOIN rel_proyectos_solicitantes t6 ON t1.id_solicitante = t6.id_solicitante
    INNER JOIN proyectos t8 ON t6.id_proyecto = t8.id_proyecto
    INNER JOIN tipo_estado t10 ON t8.id_estado = t10.id_estado
    WHERE t1.dni = $dni AND t2.id_programa = 2") or die('Revisar consulta Proyectos');

if (mysqli_num_rows($tabla_proyectos) > 0) {

    $result =  '<div class=" table-responsive">
                    <table id="autogestionados" class="table table-sm table-hover table-bordered" style="font-size: small" >
                    <thead>
                        <tr class="text-white" style=" background-color:#1e5571">
                            <td class="text-center">#ID Proyecto</td>                                              
                            <td class="text-center">Ver proyecto</td> 
                            <td class="text-center">Evaluación</td> 
                            <td class="text-center">Estado</td>
                            <td>Denominación</td>
                            <td>Rubro</td> 
                            <td class="text-center">Fecha novedad</td>                         
                        </tr>';

    while ($registro = mysqli_fetch_array($tabla_proyectos)) {

        switch ($registro['id_estado']) {
            case 25:                    // PROYECTO APROBADO
                {

                    $imprime        =
                        '<a href="../evaluaciones/ImprimirEvaluacion.php?IdProyecto=' . $registro['id_proyecto'] . '" title="Imprime evaluación ">
                        <i class="fas fa-print"></i>
                    </a>';
                    $lee            =
                        '<a href="../impresion/imprimirProyecto.php?IdProyecto=' . $registro['id_proyecto'] . '" title="Imprime proyecto ">
                        <i class="far fa-eye"></i>
                    </a>';

                    break;
                }
            case 24:                    // PROYECTO ENVIADO
                {
                    $imprime         = null;
                    $lee            =
                        '<a href="../impresion/imprimirProyecto.php?IdProyecto=' . $registro['id_proyecto'] . '">
                        <i class="far fa-eye"></i> 
                    </a>';

                    break;
                }
            case 22:                   // PROYECTO RECHAZADO
                {
                    $imprime         =
                        '<a href="../evaluaciones/ImprimirEvaluacion.php?IdProyecto=' . $registro['id_proyecto'] . '" title="Imprime evaluación">
                        <i class="fas fa-print"></i>
                    </a>';
                    $lee            =
                        '<a href="../impresion/imprimirProyecto.php?IdProyecto=' . $registro['id_proyecto'] . '">
                        <i class="far fa-eye"></i>
                    </a>';

                    break;
                }
            case 23:                    // PROYECTO APROBADO
                {

                    $imprime        =
                        '<a href="../evaluaciones/ImprimirEvaluacion.php?IdProyecto=' . $registro['id_proyecto'] . '" title="Imprime evaluación ">
                        <i class="fas fa-print"></i>
                    </a>';
                    $lee            =
                        '<a href="../impresion/imprimirProyecto.php?IdProyecto=' . $registro['id_proyecto'] . '" title="Imprime proyecto ">
                        <i class="far fa-eye"></i>
                    </a>';

                    break;
                }
            default: {
                    $imprime         = null;
                    $lee             = null;
                }
        }

        $id_proyecto = $registro['id_proyecto'];

        $result .=  '<tr>
                            <td class="text-center">' . $registro['id_proyecto'] . '</td>   
                            <td class="text-center">' . $lee . '</td> 
                            <td class="text-center">' . $imprime . '</td>               
                            <td class="text-center">' . $registro['icono'] . '</td>
                            <td>' . $registro['denominacion'] . '</td>
                            <td>' . $registro['rubro'] . '</td>
                            <td class="text-center">' . $registro['update_at'] . '</td>
                        </tr>';
    }

    $result .= '     </thead>
                    </table>
                </div>';

    $result .= '<input type="hidden" value="' . $id_proyecto . '" name="id_proyecto" id="id_proyecto">';
} else {
    $result = 0;
}

mysqli_close($con);

header('Content-Type: application/json');
echo json_encode($result);
