<?php
    session_start();
    require("../accesorios/accesos_bd.php");
    $con=conectar();
?>

<script type="text/javascript">

    var table = $('#morosos').DataTable({ 
        "lengthMenu"    : [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        "pagingType"    : 'full_numbers',
        "dom"           : '<"wrapper"Brflitp>', 
        "info"          : true,
        "buttons"       : ['copy', 'excel', 'pdf',  'colvis'],
        "order"         : false,
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
        <th>Año</th>
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

    $tabla_expedientes = mysqli_query($con, "SELECT edc.id_expediente, exped.nro_exp_control, exped.nro_proyecto, emp.apellido, emp.nombres, loca.nombre as localidad, 
        emp.cod_area, emp.celular, emp.telefono, emp.email, year(exped.fecha_otorgamiento) AS aotorga
        FROM expedientes exped
        INNER JOIN expedientes_detalle_cuotas edc ON exped.id_expediente = edc.id_expediente
        INNER JOIN rel_expedientes_emprendedores rel_exp ON exped.id_expediente = rel_exp.id_expediente
        INNER JOIN emprendedores as emp ON rel_exp.id_emprendedor = emp.id_emprendedor
        INNER JOIN localidades AS loca ON emp.id_ciudad = loca.id
        WHERE exped.estado = 2
        GROUP BY edc.id_expediente
        ORDER BY year(exped.fecha_otorgamiento), emp.apellido, emp.nombres");

    $total = 0;

    while($fila = mysqli_fetch_array($tabla_expedientes)){

        $id_expediente = $fila['id_expediente'];
        $id_proyecto = $fila['nro_proyecto'];

        $tabla_ubicacion = mysqli_query($con, "SELECT tu.id_ubicacion
            FROM rel_expedientes_ubicacion reu
            INNER JOIN expedientes_ubicaciones eu ON eu.id_ubicacion = reu.id_ubicacion
            INNER JOIN tipo_ubicaciones tu ON eu.id_tipo_ubicacion = tu.id_ubicacion
            WHERE reu.id_expediente = $id_expediente
            ORDER BY eu.fecha DESC LIMIT 1;");

        if($registro_ubicacion = mysqli_fetch_array($tabla_ubicacion)){

            if($registro_ubicacion[0] == 1){

            ?>
            <tr>
                <td class="text-center">
                    <a href="sesion_usuario_expediente.php?id=<?php echo $id_expediente; ?>&id_proyecto=<?php echo $id_proyecto; ?>" title="Ver expediente">
                        <?php echo $fila['nro_proyecto']; ?>
                    </a>                
                </td>
                <td><?php echo $fila['aotorga']; ?></td>
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
