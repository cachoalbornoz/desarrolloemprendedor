<?php
require('../accesorios/admin-superior.php');
require_once('../accesorios/accesos_bd.php');
$con = conectar();

?>

<div class="card">
    <div class="card-header">
        <div class="row mb-3">
            <div class="col-xs-12 col-sm-4 col-lg-4">
                <b><?php echo $_SESSION['titular'] ?> </b>
            </div>
            <div class="col-xs-12 col-sm-4 col-lg-4">
                Emprendedores del expediente
            </div>
            <div class="col-xs-12 col-sm-4 col-lg-4">
                <?php include('../accesorios/menu_expediente.php'); ?>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-xs-12 col-sm-12 col-lg-12">
                <a href="../emprendedores/emprendedor_nuevo.php">(+) Agregar codeudor </a>
            </div>
        </div>

    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-xs-12 col-sm-12 col-lg-12">

                <div id="detalle_emprendedor">

                    <div id="estado" style="display:none">
                        Recuperando información, aguarde <i class="fa fa-spinner fa-spin fa-fw"></i>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<?php require_once('../accesorios/admin-scripts.php'); ?>

<script type="text/javascript">
$(document).ready(function() {
    $("#estado").show();
    $("#detalle_emprendedor").load('detalle_emprendedores.php', function() {});
});

function eliminar_emprendedor(id, emprendedor) {
    if (confirm("Esta seguro que desea borrar Emprendedor \n" + emprendedor + " ?")) {

        $("#detalle_emprendedor").load('eliminar_emprendedor.php', {
            id: id
        });
        $("#detalle_emprendedor").load('detalle_emprendedores.php', function() {});

    }
}
</script>

<?php require_once('../accesorios/admin-inferior.php'); ?>