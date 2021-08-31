<?php require('../accesorios/admin-superior.php'); ?>
    
<div class="card">

    <div class="card-header">      
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-lg-12">
                GESTION ARCHIVOS DE RELEVAMIENTO        
            </div>                
        </div>
    </div>
    <div class="card-body">

        <form action="resultados_ext.php" method="post" enctype="multipart/form-data" name="form_expedientes">
        
            <div class="row">    
                <div class="col-xs-12 col-sm-6 col-lg-6">
                    <input type="file" name="archivo" class="form-control-file">        
                </div>
            
                <div class="col-xs-12 col-sm-6 col-lg-6">       
                    <input type="submit" value="Subir resultados" class="btn btn-secondary">
                </div>    
            </div>            

        </form>

    </div>

</div>    
 
<?php

    require_once('../accesorios/admin-scripts.php'); 
    require_once('../accesorios/admin-inferior.php');

    