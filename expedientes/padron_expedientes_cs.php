<?php 
    require('../accesorios/admin-superior.php');
?>
 	
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-12">
                    PADRON CAPITAL SEMILLA
                </div>
            </div>
        </div>    
        <div class="card-body">
            <div id="detalle_expediente">  
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
        $("#detalle_expediente").load('detalle_expedientes_cs.php');
    });

    function eliminar_expediente(id_exped, expediente){
    if (confirm("BORRAR EXPEDIENTE COMPLETO DE : \n\n" + expediente + " ?")){

        $("#detalle_expediente").load('detalle_expedientes_cs.php',{id:id_exped});} 
    }

</script>

<?php require_once('../accesorios/admin-inferior.php'); ?>