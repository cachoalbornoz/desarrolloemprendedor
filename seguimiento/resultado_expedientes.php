<?php
    require('../accesorios/admin-superior.php');

    $id_usuario = $_SESSION['id_usuario'];

?>

<div class="card">

    <div class="card-header">
        <div class="row clearfix">
            <div class="col-lg-12">
                RESULTADOS - PROYECTOS FINANCIADOS
            </div>
        </div>
    </div>
    <div class="card-body">
        <div id="detalle_rexpedientes">
            <div id="estado" style="display:none">
                Recuperando información, aguarde  <i class="fa fa-spinner fa-spin fa-fw"></i>
            </div>
        </div>
    </div>

</div>

<?php
    require_once('../accesorios/admin-scripts.php');
?>

<script type="text/javascript">

$(document).ready(function(){
    $("#estado").show();
    $("#detalle_rexpedientes").load('detalle_rexpedientes.php',function(){});
});
</script>

<?php
require_once('../accesorios/admin-inferior.php');
