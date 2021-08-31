<?php 
    require('../accesorios/admin-superior.php');
    require('../accesorios/accesos_bd.php');
    $con=conectar();
?>     
 
    <div class="card">
        <div class="card-header">
            ADMINISTRACION EMPRENDEDORES - EXPEDIENTES
        </div>
        <div class="card-body">
            <div id="detalle_emprendedor">

                <div id="estado" style="display:none">
                    Recuperando información, aguarde  <i class="fa fa-spinner fa-spin fa-fw"></i> 
                </div>

            </div> 
        </div>
    </div>
    
    
<?php 
    mysqli_close($con);
    require_once('../accesorios/admin-scripts.php'); ?>
    

<script type="text/javascript">

    $(document).ready(function(){
        $("#estado").show();
        $("#detalle_emprendedor").load('det_emprendedores.php',function(){});
    });

    function eliminar_emprendedor(id, id_soli){
        if(confirm('Eliminar emprendedor '+ id_soli + ' ?')){
            $("#detalle_emprendedor").load('det_emprendedores.php',{id:2,id_proyecto:id, id_soli: id_soli});
        }  
    }

</script>

<?php require_once('../accesorios/admin-inferior.php'); ?>  