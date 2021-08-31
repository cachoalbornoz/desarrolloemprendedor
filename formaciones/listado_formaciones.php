<?php require('../accesorios/admin-superior.php'); ?>

    <div class="card">

        <div class="card-header">
            <div class="row">
                <div class="col-xs-12">
                    LISTADO DE TEMAS <a href="crear_formacion.php"> (+) Agregar tema</a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div id="detalle_formacion">
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
        $("#detalle_formacion").load('detalle_formacion.php',function(){ });
    });

    </script>

    <?php require_once('../accesorios/admin-inferior.php'); ?>
