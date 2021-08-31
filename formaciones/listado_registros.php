<?php require('../accesorios/admin-superior.php'); ?>

    <div class="card">

        <div class="card-header">
            <div class="row">
                <div class="col-xs-12">
                    CAPACITACIONES REGISTRADAS
                </div>
            </div>
        </div>

        <div class="card-body">
            <div id="detalle_registro">
                <div id="estado" style="display:none">
                    Recuperando información, aguarde  <i class="fa fa-spinner fa-spin fa-fw"></i>
                </div>
            </div>
        </div>
    </div>

    <?php require_once('../accesorios/admin-scripts.php'); ?>


    <script type="text/javascript">

    $(function(){
        $("#estado").show();
        $("#detalle_registro").load('detalle_registro.php',function(){ });
    });

    </script>

    <?php require_once('../accesorios/admin-inferior.php'); ?>
