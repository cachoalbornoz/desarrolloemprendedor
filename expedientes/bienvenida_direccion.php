<?php
require '../accesorios/admin-superior.php';
?>        
         
    <div class="card-body">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class=" col-xs-12 col-sm-12 col-lg-12">
                        SISTEMA DE EXPEDIENTES - SECRETARIA DESARROLLO ECONOMICO
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class=" col-xs-12 col-sm-6 col-lg-6">
                        Bienvenida/o <strong> <?php print ucwords($_SESSION['usuario']); ?> </strong>
                    </div>
                    <div class=" col-xs-12 col-sm-6 col-lg-6">
                        <div id="actualizacion_expedientes">
                            <div id="estado" style="display:none">
                                Comprobando información del sistema, aguarde  <i class="fa fa-spinner fa-spin fa-fw"></i>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
    </div>

    <?php
    require_once '../accesorios/admin-scripts.php'; ?>

<script type="text/javascript">

    $(document).ready(function(){
        $("#estado").show();
        $("#actualizacion_expedientes").load('actualizacion_expedientes.php',function(){
        })
    });
</script>


<?php require_once '../accesorios/admin-inferior.php'; ?>