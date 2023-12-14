<?php
    session_start();
    require("../accesorios/accesos_bd.php");
    $con=conectar();
?>

<script type="text/javascript">

    var table = $('#futuros').DataTable({ 
        "lengthMenu"    : [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        "dom"           : '<"wrapper"Brflit>',        
        "buttons"       : ['copy', 'excel', 'pdf',  'colvis'],
        "order"         : [[ 1, "asc" ]],
        "stateSave"     : true,
        "columnDefs"    : [{}, ],
        "language"      : { "url": "../public/DataTables/spanish.json" }
    });

</script>

<div class="table-responsive">
    <table id="futuros" class="table table-hover text-center" style="font-size: small" >
    
    <thead>
    <tr>
        <td>MES</td>
        <td>AÑO</td>
        <td>PROYECCION INGRESOS</td>
    </tr>
    </thead>
    <tbody>
    <?php

    
    $tabla_expedientes = mysqli_query($con, " select month(exp_c.fecha_vcto) as mes, year(exp_c.fecha_vcto) as ano, sum(exp_c.importe) as monto
    from expedientes_detalle_cuotas exp_c, rel_expedientes_emprendedores as rel_exp, emprendedores as emp,
    expedientes as exped where exp_c.id_expediente = rel_exp.id_expediente and exped.id_expediente = rel_exp.id_expediente
    and rel_exp.id_emprendedor = emp.id_emprendedor and fecha_vcto >= curdate() and emp.id_responsabilidad = 1
    and (exped.estado = 1 or exped.estado = 6)
    group by ano, mes asc  ");

    $total = 0;

    while($fila = mysqli_fetch_array($tabla_expedientes)){

        ?>
        <tr>
            <td><?php echo $fila['mes']; ?></td>
            <td><?php echo $fila['ano']; ?></td>
            <td><?php echo number_format($fila['monto'],2,',','.') ?></td>
        </tr>
        <?php
        $total = $total + $fila['monto'];

    }
    
    ?> 
    </tbody>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><b>
            <?php // echo number_format($total,2,',','.') ?>
        </b></td>
    </tr>
    
    </table>
</div>
<?php
mysqli_close($con);
