<?php
require '../accesorios/admin-superior.php';

?>

    <div class="card-body">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class=" col-xs-12 col-sm-12 col-lg-12">
                        EXPEDIENTES SIN COBRAR DEL MES
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class=" col-xs-12 col-sm-12 col-lg-12">
                        <div id="detalle_nocobrado_2448">
                            <div id="estado" style="display:none">
                                Recuperando información, aguarde  <i class="fa fa-spinner fa-spin fa-fw"></i>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
    </div>


<?php
    require_once('../accesorios/admin-scripts.php'); ?>

<script type="text/javascript">

    $(document).ready(function(){
        $("#estado").show();
        $("#detalle_nocobrado_2448").load('detalle_nocobrado_2448.php',function(){
        })
    });
</script>


<?php require_once('../accesorios/admin-inferior.php'); ?>
