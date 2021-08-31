<?php
require_once("../accesorios/accesos_bd.php");
$con = conectar();

$dni                = $_POST['dni'];

$tabla_proyectos    = mysqli_query($con, "SELECT t1.id_expediente, nro_proyecto, concat(apellido, ', ' , nombres) AS solicitante, YEAR(fecha_otorgamiento) AS anio, dni, icono, t4.estado, rubro, monto, saldo, t3.id_emprendedor, dni, fecha_otorgamiento, t4.id_estado
FROM expedientes t1
INNER JOIN rel_expedientes_emprendedores t2 ON t1.id_expediente = t2.id_expediente
INNER JOIN emprendedores t3 ON t2.id_emprendedor = t3.id_emprendedor
INNER JOIN tipo_estado t4 ON t1.estado = t4.id_estado
INNER JOIN tipo_rubro_productivos t5 ON t1.id_rubro = t5.id_rubro
WHERE t3.dni = $dni ") or die('Revisar consulta Proyectos');

if (mysqli_num_rows($tabla_proyectos) > 0) {

    $result =  '<div class="table-responsive">
                    <table class="table table-hover table-striped" style="font-size: small" id="expedientes">
                        <thead>
                        <tr>
                            <th>NroExpediente</th>
                            <th>Año</th>
                            <th>Icono</th>
                            <th>Estado</th>
                            <th>Finalidad</th>
                            <th>FechaOtorgam</th>
                            <th>Monto</th>
                            <th>Saldo</th>
                        </tr>	
                        </thead>';

    while ($registro = mysqli_fetch_array($tabla_proyectos)) {

        switch ($registro['id_estado']) {
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

        // 
        $id_expediente  = $registro['id_expediente'];
        $dni            = $registro['dni'];

        $tabla_proyecto = mysqli_query(
            $con,
            "SELECT proy.id_proyecto FROM proyectos proy 
                INNER JOIN rel_proyectos_solicitantes relps on relps.id_proyecto = proy.id_proyecto 
                INNER JOIN solicitantes soli on soli.id_solicitante = relps.id_solicitante 
                    WHERE proy.id_estado = 25 AND soli.dni = $dni"
        );

        $registro_proyecto = mysqli_fetch_array($tabla_proyecto);

        if ($registro_proyecto) {
            $id_proyecto = $registro_proyecto['id_proyecto'];
        } else {
            $id_proyecto = 0;
        }
        //

        $result .=  '<tr>
                            <td>' . '<a href="../expedientes/sesion_usuario_expediente.php?id=' . $id_expediente . '&id_proyecto=' . $id_proyecto . '" title="Ver expediente">' . $registro['nro_proyecto'] . '</a>' . '</td>
                            <td>' . $registro['anio'] . '</td> 
                            <td>' . $registro['icono'] . '</td>
                            <td>' . $registro['estado'] . '</td>
                            <td>' . $registro['rubro'] . '</td>
                            <td>' . date('d/m/Y', strtotime($registro['fecha_otorgamiento'])) . '</td>
                            <td>' . number_format($registro['monto'], 0, '.', ',') . '</td>
                            <td>' . number_format($registro['saldo'], 0, '.', ',') . '</td>
                        </tr>';
    }

    $result .= '     </table>
                </div>';
} else {
    $result = 0;
}

mysqli_close($con);

header('Content-Type: application/json');
echo json_encode($result);
