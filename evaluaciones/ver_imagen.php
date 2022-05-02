<?php

require('../accesorios/admin-superior.php');

require_once('../accesorios/accesos_bd.php');

$con=conectar();

$idProyecto = $_GET['IdProyecto'];
$solicitante= $_GET['solicitante']; 
$foto           = $_GET['foto'];

?>

  	
<div class="card">
    <div class="card-header">      
        <div class="row">
            <div class="col-lg-12">
                IMAGEN DEL PROYECTO - Corresponde a <strong><?php echo $solicitante ?> </strong> - IdProyecto <i class="fas fa-chevron-right"></i> <?php echo str_pad($idProyecto,4,'0',STR_PAD_LEFT)?>          
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-lg-12">
            <img src="/desarrolloemprendedor/frontend/jovenes/fotos/<?php echo $foto ?>" alt="" class=" img-fluid">
            </div>
        </div>     	
    </div>
</div>

<?php require_once('../accesorios/admin-scripts.php'); ?>

<?php require_once('../accesorios/admin-inferior.php'); ?>

