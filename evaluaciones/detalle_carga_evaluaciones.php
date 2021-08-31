<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('location:../accesorios/salir.php');
    exit;
}

require_once('../accesorios/accesos_bd.php');

$con=conectar();


if (isset($_POST['opcion']) and $_POST['opcion'] == 1) {
    $anio =  $_POST['anio'];

    $tabla_evaluaciones = mysqli_query($con, 
    "SELECT t1.id_proyecto, t1.id_programa, t1.id_estado, t3.id_solicitante, t1.resumen_ejecutivo, t5.resultado_final, YEAR(t5.ultima_fecha) as anio, t5.id_usuario
    FROM proyectos t1
    LEFT JOIN rel_proyectos_solicitantes t2 ON t1.id_proyecto = t2.id_proyecto
    LEFT JOIN solicitantes t3 ON t2.id_solicitante = t3.id_solicitante
    LEFT JOIN registro_solicitantes t4 ON t3.id_solicitante = t4.id_solicitante
    LEFT JOIN proyectos_seguimientos t5 ON t2.id_proyecto = t5.id_proyecto
    WHERE t3.id_responsabilidad = 1 
    AND t1.id_estado > 0 AND t1.id_estado != 25 AND t5.resultado_final > 0 
    AND t1.id_proyecto NOT IN (
        SELECT id_proyecto FROM maestro_puntajes WHERE anio = $anio) AND (YEAR(t5.ultima_fecha) = $anio)");

    while ($registro =  mysqli_fetch_array($tabla_evaluaciones)) {
        $id_proyecto        = $registro['id_proyecto'];
        $id_programa        = $registro['id_programa'];
        $id_estado          = $registro['id_estado'];
        $id_solicitante     = $registro['id_solicitante'];
        $id_usuario         = $registro['id_usuario'];
        $resumen_ejecutivo  = $registro['resumen_ejecutivo'];
        $resultado_final    = $registro['resultado_final'];
        $anio               = $registro['anio'];

        $query  = "INSERT INTO maestro_puntajes
            (id_proyecto, id_programa, id_estado, id_solicitante, id_usuario, resumen_ejecutivo, resultado_final, anio)
            VALUES ($id_proyecto, $id_programa, $id_estado, $id_solicitante, $id_usuario, '$resumen_ejecutivo', $resultado_final, '$anio') ";

        mysqli_query($con, $query) or die('Revisar ingreso de evaluaciones') ;
    };
}

$tabla_evaluaciones = mysqli_query($con, 
"SELECT mae.id_programa, mae.id_solicitante, sol.apellido, sol.nombres, sol.dni, mae.resumen_ejecutivo, mae.resultado_final, mae.anio, mae.id_usuario
FROM maestro_puntajes mae
INNER JOIN solicitantes sol on sol.id_solicitante = mae.id_solicitante
ORDER BY sol.apellido, sol.nombres;");

?>

<script type="text/javascript">

    $(document).ready(function() {

        var table = $('#evaluaciones').DataTable({ 
        "lengthMenu"    : [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        "dom"           : '<"wrapper"Brflit>',        
        "buttons"       : ['copy', 'excel', 'pdf',  'colvis'],
        "order"         : [[ 1, "asc" ]],
        "stateSave"     : true,
        "columnDefs"    : [{className: 'rowspanning', targets: [6]}, ],
        "language"      : { "url": "../public/DataTables/spanish.json" }
        });
    }); 

</script>

<div class="table-responsive">
    <table id="evaluaciones" class="table table-hover table-striped" style="font-size: small">
        <thead>
            <tr>
                <td>#Prog</td>
                <td>Año</td>
                <td>#Soli</td>
                <td>Apellido</td>
                <td>Nombres</td>
                <td>Dni</td>
                <td>ResEjec</td>
                <td>Puntos</td>
                <td>#User</td>
            </tr>
        </thead>
        <tbody>
        <?php
        while ($registro =  mysqli_fetch_array($tabla_evaluaciones)) {
            ?>
          <tr>
              <td><?= $registro['id_programa'] ?></td>
              <td><?= $registro['anio'] ?></td>
              <td><?= $registro['id_solicitante'] ?></td>
              <td><?= $registro['apellido'] ?></td>
              <td><?= $registro['nombres'] ?></td>
              <td><?= $registro['dni'] ?></td>
              <td><?= $registro['resumen_ejecutivo'] ?></td>
              <td><b><?= $registro['resultado_final'] ?></b></td>
              <td><?= $registro['id_usuario'] ?></td>
        </tr>

        <?php
        }?>
        </tbody>
    </table>
</div>
<?php    mysqli_close($con);
