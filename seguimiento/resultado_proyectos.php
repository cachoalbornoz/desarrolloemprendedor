<?php
    require('../accesorios/admin-superior.php');

    $id_usuario = $_SESSION['id_usuario'];

?>

<div class="card">

    <div class="card-header">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-lg-6">
                RESULTADOS - AUTOGESTIONADOS
            </div>
            <div class="col-lg-6" style="text-align: right">
                <a href="javascript:void(0)" title="Exportar a Excel" onClick="exportar()">Exportar</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div id="detalle_rproyectos">
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
    $("#detalle_rproyectos").load('detalle_rproyectos.php',function(){});
});
</script>
