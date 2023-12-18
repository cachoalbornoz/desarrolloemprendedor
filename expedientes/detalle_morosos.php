<?php
    session_start();
    require("../accesorios/accesos_bd.php");
    $con=conectar();


    $fecha = date('Y').'-'.date('m').'-10';

    $tabla_morosos = mysqli_query($con, "SELECT edc.id_expediente, exped.estado, MIN(edc.fecha_vcto) as fecha
        FROM expedientes exped
        INNER JOIN expedientes_detalle_cuotas edc ON exped.id_expediente = edc.id_expediente
        WHERE edc.fecha_vcto < '$fecha' AND edc.estado = 0 AND (exped.estado = 1 OR exped.estado = 6)
        GROUP BY edc.id_expediente");


    while($fila_morosos = mysqli_fetch_array($tabla_morosos)){

        $id_expediente = $fila_morosos['id_expediente'];        

        // Obtener el estado actual del expediente e insertar el nuevo estado del expediente en la tabla de Estados
        $tabla_estados      = mysqli_query($con,"SELECT id_tipo_estado FROM expedientes_estados WHERE id_expediente = $id_expediente ORDER BY fecha desc limit 1" );
        $fila_estado        = mysqli_fetch_array($tabla_estados);
        $id_tipo_estado_ant = $fila_estado[0];

        $fecha              = $fila_morosos['fecha'];
        $id_tipo_estado     = 2;
        mysqli_query($con, "INSERT INTO expedientes_estados (fecha, id_expediente, id_tipo_estado, id_tipo_estado_ant) VALUES ('$fecha', $id_expediente, $id_tipo_estado, $id_tipo_estado_ant)");	

        // Actualizar el estado del expediente a MOROSO
        mysqli_query($con, "UPDATE expedientes SET estado = $id_tipo_estado WHERE id_expediente = $id_expediente");
    }

?>

<script type="text/javascript">

    var table = $('#morosos').DataTable({ 
        "lengthMenu"    : [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        "pagingType"    : 'full_numbers',
        "dom"           : '<"wrapper"Brflitp>', 
        "info"          : true,
        "buttons"       : ['copy', 'excel', 'pdf',  'colvis'],
        "order"         : [[ 1, "asc" ]],
        "stateSave"     : true,
        "columnDefs"    : [{}, ],
        "language"      : { "url": "../public/DataTables/spanish.json" }
    });

</script>

<div class="table-responsive">
    <table id="morosos" class="table table-hover" style="font-size: small" >
    <thead>
    <tr>
        <th>#</th>
        <th>Apellido</th>
        <th>Nombres</th>
        <th>Localidad</th>
        <th>CodArea</th>
        <th>Movil</th>
        <th>Fijo</th>
        <th>Mail</th>
    </tr>
    </thead>
    <tbody>
    <?php

    $tabla_expedientes = mysqli_query($con, "SELECT edc.id_expediente, exped.nro_exp_control, exped.nro_proyecto, emp.apellido, emp.nombres, loca.nombre as localidad, emp.cod_area, emp.celular, emp.telefono, emp.email
        FROM expedientes exped
        INNER JOIN expedientes_detalle_cuotas edc ON exped.id_expediente = edc.id_expediente
        INNER JOIN rel_expedientes_emprendedores rel_exp ON exped.id_expediente = rel_exp.id_expediente
        INNER JOIN emprendedores as emp ON rel_exp.id_emprendedor = emp.id_emprendedor
        INNER JOIN localidades AS loca ON emp.id_ciudad = loca.id
        WHERE exped.estado = 2
        GROUP BY edc.id_expediente
        ORDER BY emp.apellido, emp.nombres");

    $total = 0;

    while($fila = mysqli_fetch_array($tabla_expedientes)){

        $id_expediente = $fila['id_expediente'];
        $id_proyecto = $fila['nro_proyecto'];

        ?>
        <tr>
            <td class="text-center">
                <a href="sesion_usuario_expediente.php?id=<?php echo $id_expediente; ?>&id_proyecto=<?php echo $id_proyecto; ?>" title="Ver expediente">
                    <?php echo $fila['nro_proyecto']; ?>
                </a>                
            </td>
            <td><?php echo $fila['apellido']; ?></td>
            <td><?php echo $fila['nombres']; ?></td>
            <td><?php echo $fila['localidad']; ?></td>
            <td class="text-center"><?php echo $fila['cod_area']; ?></td>
            <td class="text-center"><?php echo $fila['celular']; ?></td>
            <td class="text-center"><?php echo $fila['telefono']; ?></td>
            <td><?php echo $fila['email']; ?></td>
        </tr>
        <?php
    }
    ?>
    </tbody>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    </table>
</div>
<?php
mysqli_close($con);
