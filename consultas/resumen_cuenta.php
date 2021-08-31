<?php
    require('../accesorios/admin-superior.php');
    require_once("../accesorios/accesos_bd.php");
    $con=conectar();

?>

    <div class="card">
        <div class=" card-header">
            <div class="row">
                <div class=" col-xs-12 col-sm-12 col-lg-10">
                    RESUMEN DE CUENTA - PAGOS REALIZADOS
                </div>
                <div class=" col-xs-12 col-sm-12 col-lg-2">
                    <select id="id_cuenta" name="id_cuenta" class="form-control"> 
                        <option value="-1" selected>Nro cta destino</option>
                        <option value="0">090024/7</option>
                        <option value="1">662047/1</option>
                        <option value="2">620230/1</option>
                        <option value="3">622988/5</option> 
                    </select>
                </div>
            </div>
        </div>    

        
        <div class="card-body">
            
            <div class="row mb-3">
                <div class=" col-xs-12 col-sm-12 col-lg-12">
                    &nbsp;
                </div>
            </div>

            <div class="row mb-3">
                <div class=" col-xs-12 col-sm-12 col-lg-12">
                    
                    <div id="detalle_resumen"> 
                        <div id="estado" style="display:none">
                            Recuperando información, aguarde  <i class="fa fa-spinner fa-spin fa-fw"></i>
                        </div>
                    </div>
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
        $("#detalle_resumen").load('detalle_resumen.php');
    });

    
    $("#id_cuenta").on('change', function(){

        var id_cuenta = $("#id_cuenta").val();

        $("#detalle_resumen").load('detalle_resumen.php', {id_cuenta:id_cuenta});
    });
    

</script>

<?php require_once('../accesorios/admin-inferior.php'); ?>
