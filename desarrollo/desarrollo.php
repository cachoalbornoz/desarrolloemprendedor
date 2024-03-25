<?php
require '../accesorios/admin-superior.php';

require_once '../accesorios/accesos_bd.php';
$con = conectar();

$query = 'SELECT edc.id_expediente, edc.fecha_vcto, edc.estado
    FROM expedientes exped
    INNER JOIN expedientes_detalle_cuotas edc ON exped.id_expediente = edc.id_expediente
    WHERE exped.estado = 6 AND edc.estado = 0 
    AND YEAR(edc.fecha_vcto)=YEAR(NOW())
    AND MONTH(edc.fecha_vcto) = MONTH(NOW()) + 1';

$tabla_prorroga = mysqli_query($con, $query);

while($fila_prorroga = mysqli_fetch_array($tabla_prorroga)) {

}

?>

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-xs-12 col-md-12 col-lg-12">
                AMBIENTE DESARROLLO
            </div>
        </div>
    </div>

    <div class="card-body">

        <div class="row mt-5 mb-5">
            <div class="col-xs-12 col-md-12 col-lg-12">

            Testing
                
            </div>
        </div>

    </div>
</div>

<?php require_once '../accesorios/admin-scripts.php'; ?>


<script type="text/javascript">
    $(document).ready(function() {
        
    })    
</script>

<?php require_once '../accesorios/admin-inferior.php';
