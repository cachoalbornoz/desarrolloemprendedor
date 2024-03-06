<?php
require '../accesorios/admin-superior.php';

?>

    <div class="card-body">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class=" col-xs-12 col-sm-12 col-lg-12">
                        EXPEDIENTES MOROSOS
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class=" col-xs-12 col-sm-12 col-lg-12">
                        <div id="detalle_morosos">
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
        $("#detalle_morosos").load('detalle_morosos.php',function(){
        })
    });
</script>


<?php require_once('../accesorios/admin-inferior.php'); ?>
