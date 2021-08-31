<?php
    session_start();
    require("../accesorios/accesos_bd.php");
    $con=conectar();

    if(isset($_POST['id_cuenta'])){

        $id_cuenta = " and id_cuenta =".$_POST['id_cuenta']." ";

    }else{

        $id_cuenta = "";

    }
?>

<script type="text/javascript">

    $(document).ready(function() {

        var table = $('#resumen').DataTable({ 
        "lengthMenu"    : [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        "dom"           : '<"wrapper"Brflit>',        
        "buttons"       : ['copy', 'excel', 'pdf',  'colvis'],
        "order"         : [[ 0, "desc" ]],
        "stateSave"     : true,
        "columnDefs"	: [ {  targets: 0, render: $.fn.dataTable.render.moment('DD-MM-YYYY', 'DD-MM-YYYY')	} ],
        "language"      : { "url": "../public/DataTables/spanish.json" }
        });
    }); 
    

</script>

<div class="table-responsive">
    <table class="table table-striped table-hover text-center" style="font-size: small" id="resumen">
    <thead>
    <tr>
            <td>Fecha</td>
            <td>Cod_Jov</td>
            <td>Titular</td>
            <td>Monto</td>
            <td>Nro_cuenta</td>
            <td>Tipo_Movimiento</td>
            <td>Nro_Operacion</td>
    </tr>
    </thead>
    <tbody>
        <?php
        $tabla_pagos = mysqli_query($con, "select exped.nro_proyecto, year(exped.fecha_otorgamiento) as ano, emp.apellido, emp.nombres , exp.id_pago, exp.id_cuenta, exp.fecha, exp.monto, exp.nro_operacion, tp.pago
        from expedientes_pagos as exp, tipo_pago as tp, expedientes as exped,
        rel_expedientes_emprendedores as rel ,emprendedores as emp
        where tp.id_tipo_pago = exp.id_tipo_pago and exp.id_expediente = exped.id_expediente
        and exped.id_expediente = rel.id_expediente and rel.id_emprendedor = emp.id_emprendedor
        and emp.id_responsabilidad = 1 $id_cuenta
        order by exp.fecha desc");

        $filas_pagos = mysqli_num_rows($tabla_pagos);
        $total_pagado = 0;

        while ($fila = mysqli_fetch_array($tabla_pagos)) {
            ?>
        <tr>
            <td><?php echo date('d-m-Y', strtotime($fila['fecha'])); ?></td>
            <td><?php echo $fila['nro_proyecto'] ?> / <?php echo substr($fila['ano'], -2) ?></td>
            <td><?php echo substr($fila['apellido'].', '.$fila['nombres'], 0, 25) ?></td>
            <td style="color:#900; font-weight:bold;"><?php echo number_format($fila['monto'], 2, ',', '.') ?> </td>
            <td>
            <?php
            if ($fila['id_cuenta'] == 0) {
                echo "090024/7";
            } else {
                if ($fila['id_cuenta'] == 1) {
                    echo "662047/1";
                } else {
                    if ($fila['id_cuenta'] == 2) {
                        echo "620230/1";
                    }else{
                        echo "622988/5";
                    }
                }
            } ?>
            </td>
            <td><?php echo $fila['pago'] ?></td>
            <td><?php echo $fila['nro_operacion'] ?></td>
        </tr>
        <?php
        $total_pagado = $total_pagado + $fila['monto'];
        }
        ?>
    </tbody>
    </table>
</div>

<?php mysqli_close($con);
