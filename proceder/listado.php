<?php require('../accesorios/admin-superior.php'); ?>

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-12">
                PROGRAMA PROCEDER
            </div>
        </div>
    </div>
    <div class="card-body">
        <div id="detalle">
			<div id="estado" style="display:none">
                Recuperando información, aguarde  <i class="fa fa-spinner fa-spin fa-fw"></i>
            </div>
		</div>
    </div>
</div>

<?php require_once('../accesorios/admin-scripts.php'); ?>

<script type="text/javascript">

$(document).ready(function(){

    $("#estado").show();
    $("#detalle").load('detalle_proceder.php');

});

function editar_solicitante(id){
    window.location="../solicitantes/registro_edita.php?id_solicitante=" + id;
}

function habilita(id, valor){

    $("#estado").show();
    $("#detalle").load('detalle_proceder.php',{id:id, valor:valor});

}


</script>


<?php require_once('../accesorios/admin-inferior.php'); ?>
