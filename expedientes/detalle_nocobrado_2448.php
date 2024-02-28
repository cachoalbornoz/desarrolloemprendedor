<?php
    session_start();
    require("../accesorios/accesos_bd.php");
    $con=conectar();
?>

<script type="text/javascript">

    var table = $('#futuros').DataTable({ 
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
    <table id="futuros" class="table table-hover" style="font-size: small" >
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
    WHERE MONTH(edc.fecha_vcto) = MONTH(CURDATE()) AND YEAR(edc.fecha_vcto) = YEAR(CURDATE()) AND edc.estado = 0 AND rel_exp.id_responsabilidad = 1 AND (exped.estado = 1 or exped.estado = 6)
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
