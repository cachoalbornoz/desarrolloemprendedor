<?php
require('../accesorios/admin-superior.php');

require_once('../accesorios/accesos_bd.php');

$con=conectar();

$idProyecto = $_GET['IdProyecto'];
$solicitante= $_GET['solicitante']; 

?>

  	
<div class="card">
    <div class="card-header">      
        <div class="row">
            <div class="col-lg-12">
                INFORME TECNICO PROYECTO - Corresponde a <strong><?php echo $solicitante ?> </strong> - <i class="fas fa-chevron-right"></i> <?php echo str_pad($idProyecto,4,'0',STR_PAD_LEFT)?>          
            </div>
        </div>
    </div>

    <div class="card-body">
        <form class="form-horizontal" method="post" role="form" action="Agregar_Informe_Final.php?id_proyecto=<?php echo $idProyecto ;?>" enctype="multipart/form-data">
            <ul class="list-group">
                
                <li class="list-group-item">              
                    <div class="form-group">
                        <div class="col-md-9">
                            <label><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Archivo Informe</label>                
                            <input id="archivo" name="archivo" type="file" class="form-control" accept="application/pdf" />
                        </div>	      			
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="submit" class="btn btn-info" value="Agregar Informe  &raquo;">
                        </div>
                    </div>    
                </li>
            </ul>    
        </form>      	
    </div>
</div>

<?php require_once('../accesorios/admin-scripts.php'); ?>

<?php require_once('../accesorios/admin-inferior.php'); ?>

