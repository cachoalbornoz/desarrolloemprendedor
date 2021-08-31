<?php require('../accesorios/admin-superior.php'); ?>
    
<div class="card">

    <div class="card-header">      
        <div class="row">
            <div class="col-lg-12">
                GESTION ARCHIVOS DE RELEVAMIENTO        
            </div>                
        </div>
    </div>
    <div class="card-body">

        <form action="carga_resultados.php" method="post" enctype="multipart/form-data" name="form_expedientes">
        <div class="row">    
            <div class="col-sm-6">
                <input type="file" name="archivo" class="form-control">        
            </div>
            <div class="col-sm-6">       
                <input type="submit" value="Subir resultados" class="btn btn-default">
            </div>    
        </div>
        </form>

    </div>

</div>    
 
<?php

require_once('../accesorios/admin-scripts.php'); 

require_once('../accesorios/admin-footer.php'); 
