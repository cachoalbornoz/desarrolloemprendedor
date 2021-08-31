<?php
    require('../accesorios/admin-superior.php');
    require_once("../accesorios/accesos_bd.php");
    $con=conectar();

?>

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-lg-12">
                RENDICIONES
            </div>
        </div>
    </div>
    <div class="card-body">

        <div class="table table-responsive">
            <table class="table table-hover" style="font-size: small " id="rendiciones">
            <thead>
                <tr>
                    <td>Fecha</td>
                    <td>Cod Jov</td>
                    <td>Titular</td>
                    <td>Monto$</td>
                    <td>Comprobante</td>
                </tr>
            </thead>
            <tbody>
            <?php
            $tabla_rendiciones = mysqli_query($con, 
            "SELECT t4.fecha, t1.nro_proyecto, YEAR(t1.fecha_otorgamiento) as ano, t3.apellido, t3.nombres, t4.monto, if(t4.tipo = 1, 'Factura', '-') AS comprobante
            FROM expedientes t1
            INNER JOIN rel_expedientes_emprendedores t2 ON t1.id_expediente = t2.id_expediente
            INNER JOIN emprendedores t3 ON t2.id_emprendedor = t3.id_emprendedor
            INNER JOIN rendiciones t4 ON t1.id_expediente = t4.id_expediente
            WHERE t3.id_responsabilidad = 1
            ORDER BY t4.fecha ASC, t3.apellido ASC, t3.nombres ASC");

            $total_pagado = 0;

            while ($fila = mysqli_fetch_array($tabla_rendiciones)) {
                ?>
                <tr>
                    <td>
                        <?php 
                        if (isset($fila['fecha'])) {
                            echo date('d/m/Y', strtotime($fila['fecha'])) ;
                        } ?>
                    </td>
                    <td><?php echo $fila['nro_proyecto'] ?> / <?php echo $fila['ano'] ?></td>
                    <td><?php echo substr($fila['apellido'].', '.$fila['nombres'], 0, 25) ?></td>
                    <td><?php echo number_format($fila['monto'], 2, ',', '.') ?> </td>
                    <td><?php echo $fila['comprobante'] ?> </td>
                </tr>
            <?php
            $total_pagado = $total_pagado + $fila['monto'];
            }
            ?>
            </tbody>
            </table>
        </div>
    </div>
</div>

<?php
    mysqli_close($con);
    require_once('../accesorios/admin-scripts.php'); ?>

    <script type="text/javascript">

    $(document).ready(function() {

        var table = $('#rendiciones').DataTable({ 
        "lengthMenu"    : [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        "dom"           : '<"wrapper"Brflit>',        
        "buttons"       : ['copy', 'excel', 'pdf',  'colvis'],
        "order"         : [[ 1, "asc" ]],
        "stateSave"     : true,
        "columnDefs"    : [{}, ],
        "language"      : { "url": "../public/DataTables/spanish.json" }
        });
    });    

</script>

<?php require_once('../accesorios/admin-inferior.php'); ?>
