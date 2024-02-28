<?php
require '../accesorios/admin-superior.php';
require '../accesorios/accesos_bd.php';
$con = conectar();
?>

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col">
                COBROS REALIZADOS - INGRESO PROYECTADO
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table table-responsive">
            <table id="pagos" class="table table-hover" style="font-size: small" >
            <thead>
            <tr>
                <th>Mes</th>
                <th>Año</th>
                <th>Cobrado</th>
                <th>A_Cobrar</th>
                <th>%_Real_Cobrado</th>
            </tr>
            </thead>
            <tbody>

            <?php
            $tabla_pagos = mysqli_query(
                $con,
                'SELECT year(exp.fecha) as ano, month(exp.fecha) as mes, sum(exp.monto) as pagos
                FROM expedientes_pagos as exp, tipo_pago as tp, expedientes as exped,  rel_expedientes_emprendedores as rel_exp, emprendedores as emp
                WHERE tp.id_tipo_pago = exp.id_tipo_pago 
                AND exp.id_expediente = exped.id_expediente 
                AND exped.id_expediente = rel_exp.id_expediente 
                AND rel_exp.id_emprendedor = emp.id_emprendedor 
                AND rel_exp.id_responsabilidad = 1 
                AND year(exp.fecha) > 2012
                GROUP BY ano, mes 
                ORDER BY ano DESC, mes DESC'
            );

$total_cobrado = 0;
$total_acobrar = 0;

while($registro_pagos = mysqli_fetch_array($tabla_pagos)) {

    $ano = $registro_pagos['ano'];
    $mes = $registro_pagos['mes'];

    $tabla_cobros = mysqli_query(
        $con,
        "SELECT year(exp_c.fecha_vcto) as ano, month(exp_c.fecha_vcto) as mes, sum(exp_c.importe) as acobrar
                                FROM expedientes_detalle_cuotas exp_c, rel_expedientes_emprendedores as rel_exp, emprendedores as emp, expedientes as exped 
                                WHERE  exp_c.id_expediente = rel_exp.id_expediente and exped.id_expediente = rel_exp.id_expediente
                                AND rel_exp.id_emprendedor = emp.id_emprendedor AND rel_exp.id_responsabilidad = 1
                                AND month(exp_c.fecha_vcto) = $mes AND year(exp_c.fecha_vcto) = $ano 
                                AND year(exp_c.fecha_vcto) > 2012"
    );

    $registro_cobros = mysqli_fetch_array($tabla_cobros);

    $total_a_cobrar = $registro_cobros['acobrar'];

    $total_cobrado = $registro_pagos['pagos'];

    $subtotal = ($total_a_cobrar - $total_cobrado);

    if($subtotal !== 0 and $total_a_cobrar > 0) {
        $porcentaje = 100 - (($subtotal / $total_a_cobrar) * 100);
    } else {
        $porcentaje = 0;
    }

    ?>
                <tr>
                    <td><?php print $registro_pagos['ano']; ?></td>
                    <td><?php print $registro_pagos['mes']; ?></td>
                    <td><?php print number_format($total_cobrado, 2, ',', '.'); ?></td>
                    <td><?php print number_format($total_a_cobrar, 2, ',', '.'); ?></td>
                    <td><?php print number_format($porcentaje, 2, ',', '.'); ?> %</td>
                </tr>
                <?php
}
?>
            </tbody>

            </table>
        </div>
    </div>
</div>

<?php
    mysqli_close($con);
require_once '../accesorios/admin-scripts.php'; ?>

<script type="text/javascript">

    $(document).ready(function() {

        var table = $('#pagos').DataTable({ 
        "lengthMenu"    : [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        "dom"           : '<"wrapper"Brflitp>',        
        "buttons"       : ['copy', 'excel', 'pdf',  'colvis'],
        "order"         : [[ 1, "asc" ]],
        "stateSave"     : true,
        "columnDefs"    : [{}, ],
        "language"      : { "url": "../public/DataTables/spanish.json" }
        });
    }); 

</script>

<?php require_once '../accesorios/admin-inferior.php'; ?>
