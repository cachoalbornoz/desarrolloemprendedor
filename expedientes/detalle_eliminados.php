<?php
    session_start();
    require("../accesorios/accesos_bd.php");
    $con=conectar();
?>

<script type="text/javascript">

    var table = $('#eliminados').DataTable({ 
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
    <table id="eliminados" class="table table-hover" style="font-size: small" >
    <thead>
    <tr>
        <th>#</th>
        <th>Año</th>
        <th>Ubicación</th>
        <th>Apellido</th>
        <th>Nombres</th>
        <th>Importe</th>
        <th>UltimoPago</th>
        <th>Localidad</th>
        <th>CodArea</th>
        <th>Movil</th>
        <th>Fijo</th>
        <th>Mail</th>
        <th>User</th>
        <th>F.Borrado</th>
    </tr>
    </thead>
    <tbody>
    <?php

    $tabla_expedientes = mysqli_query($con, "SELECT edc.id_expediente, exped.nro_exp_control, exped.nro_proyecto, emp.apellido, emp.nombres, loca.nombre as localidad, emp.cod_area, emp.celular, emp.telefono, emp.email, ea.usuario,
    year(exped.fecha_otorgamiento) AS aotorga
    FROM expedientes exped
    INNER JOIN expedientes_detalle_cuotas edc ON exped.id_expediente = edc.id_expediente
    LEFT JOIN expedientes_auditoria ea ON exped.id_expediente = ea.id_expediente 
    INNER JOIN rel_expedientes_emprendedores rel_exp ON exped.id_expediente = rel_exp.id_expediente
    INNER JOIN emprendedores as emp ON rel_exp.id_emprendedor = emp.id_emprendedor
    INNER JOIN localidades AS loca ON emp.id_ciudad = loca.id
    WHERE exped.estado = 99 AND emp.id_responsabilidad = 1
    GROUP BY edc.id_expediente
    ORDER BY emp.apellido, emp.nombres");

    $total = 0;

    while($fila = mysqli_fetch_array($tabla_expedientes)){

        $id_expediente = $fila['id_expediente'];
        $id_proyecto = $fila['nro_proyecto'];

        $tabla_deuda = mysqli_query($con, "SELECT SUM(edc.importe) FROM expedientes_detalle_cuotas edc 
        WHERE edc.fecha_vcto < CURDATE() AND edc.estado = 0 AND edc.id_expediente = $id_expediente");
        $registro_deuda = mysqli_fetch_array($tabla_deuda);

        $tabla_deuda_fecha = mysqli_query($con, "SELECT min(edc.fecha_vcto) FROM expedientes_detalle_cuotas edc 
        WHERE edc.fecha_vcto < CURDATE() AND edc.estado = 1 AND edc.id_expediente = $id_expediente");
        $registro_deuda_fecha = mysqli_fetch_array($tabla_deuda_fecha);

        $ultimo_pago = ( is_null($registro_deuda_fecha[0]) )?null:date('d-m-Y', strtotime($registro_deuda_fecha[0]));

        // OBTENER FECHA ELIMINACION
        $tabla_eliminacion = mysqli_query($con, "SELECT MAX(ee.fecha) FROM expedientes_estados ee
        WHERE ee.id_tipo_estado = 99 AND ee.id_expediente = $id_expediente");
        $registro_eliminacion = mysqli_fetch_array($tabla_eliminacion);
        $fecha_eliminacion = ( is_null($registro_eliminacion[0]) )?null:date('d-m-Y', strtotime($registro_eliminacion[0]));


        $tabla_ubicacion = mysqli_query($con, "SELECT tu.id_ubicacion, tu.ubicacion
            FROM rel_expedientes_ubicacion reu
            INNER JOIN expedientes_ubicaciones eu ON eu.id_ubicacion = reu.id_ubicacion
            INNER JOIN tipo_ubicaciones tu ON eu.id_tipo_ubicacion = tu.id_ubicacion
            WHERE reu.id_expediente = $id_expediente
            ORDER BY eu.fecha DESC LIMIT 1;");

        if($registro_ubicacion = mysqli_fetch_array($tabla_ubicacion)){

            // EXPEDIENTES CON UBICACION EN JOVENES - 1 / JURIDICOS - 2 / FISCALIA - 4
            if($registro_ubicacion[0] == 1 OR $registro_ubicacion[0] == 2 OR $registro_ubicacion[0] == 4){

            ?>
            <tr>
                <td class="text-center">
                    <a href="sesion_usuario_expediente.php?id=<?php echo $id_expediente; ?>&id_proyecto=<?php echo $id_proyecto; ?>" title="Ver expediente">
                        <?php echo $fila['nro_proyecto']; ?>
                    </a>                
                </td>
                <td><?php echo $fila['aotorga']; ?></td>
                <td><?php echo substr($registro_ubicacion['ubicacion'],0,8); ?></td>
                <td><?php echo $fila['apellido']; ?></td>
                <td><?php echo $fila['nombres']; ?></td>
                <td><?php echo $registro_deuda[0]; ?></td>
                <td><?php echo $ultimo_pago; ?></td>
                <td><?php echo substr($fila['localidad'],0,15); ?></td>
                <td class="text-center"><?php echo $fila['cod_area']; ?></td>
                <td class="text-center"><?php echo $fila['celular']; ?></td>
                <td class="text-center"><?php echo $fila['telefono']; ?></td>
                <td><?php echo $fila['email']; ?></td>
                <td><?php echo $fila['usuario']; ?></td>
                <td><?php echo $fecha_eliminacion; ?></td>
            </tr>
            
            <?php

                $total = $total + $registro_deuda[0];
            }           

        }
    }
    ?>
    </tbody>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><b><?php echo number_format($total,2,',','.') ?></b></td>
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
