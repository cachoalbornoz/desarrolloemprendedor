<?php

require('../accesorios/admin-superior.php'); 

require_once('../accesorios/accesos_bd.php');
$con=conectar();

$id 	        = $_GET['id'];
$id_solicitante = $_GET['id_solicitante'];

if($id <> 0){

    // DATOS DE LA INVERSION
    $query  = mysqli_query($con, "SELECT * FROM formacion_detalle_formaciones WHERE id = $id" );
    $fila   = mysqli_fetch_array($query);

    $objetivos      = $fila['objetivos'];
    $acciones       = $fila['acciones'];
    $cumplio 	    = $fila['cumplio'];

    $titulo         = 'Modifica detalle de formación' ;

}else{

    $objetivos  = NULL;
    $acciones   = NULL;
    $cumplio    = 0;

    $titulo         = 'Agrega detalle de formación' ;

}

?>


<div class="card">

    <div class="card-header">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-lg-12">
                PROGRAMA FORMACION - <b>FICHA DE SEGUIMIENTO</b>
            </div>
        </div>
    </div>

    <div class="card-body">

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-lg-12">
                <p class="card-title">
                    <b><?php echo $titulo ?> </b> <?php echo $_SESSION['solicitante'] ?>
                </p>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <br>
                </div>                    
            </div>
        </div>

        <form name="formacion" action="guardaDetalleFormacion.php" method="POST">            
            
            <div class="row mb-4">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <input type="hidden" name="idDetalle" id="idDetalle" class="form-control" value="<?php echo $id ?>">
                    <input type="hidden" name="id_solicitante" id="id_solicitante" class="form-control" value="<?php echo $id_solicitante ?>">
                </div>                    
            </div>
        
            <div class="row mb-4">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                        <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                Problemática
                            </span>
                        </div>
                        <input name="objetivos" id="objetivos" class="form-control" value="<?php echo $objetivos ?>" required >
                    </div>                        
                </div> 
            </div>

            <div class="row mb-4">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                        <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                Objetivos
                            </span>
                        </div>
                        <input name="acciones" id="acciones" class="form-control" value="<?php echo $acciones ?>" required>
                    </div>                        
                </div>   
            </div>   

            <div class="row mb-4">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <p>¿Cumplió ?</p>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="radio1" name="cumplio" value="0" class="custom-control-input" <?php if($cumplio <> 1){ echo 'checked';} ?>>
                        <label class="custom-control-label" for="radio1">No</label> 
                    </div>    
                    <div class="custom-control custom-radio">
                        <input type="radio" id="radio2" name="cumplio" value="1" class="custom-control-input" <?php if($cumplio == 1){ echo 'checked';} ?>>
                        <label class="custom-control-label" for="radio2">Si</label>                        
                    </div>    
                </div>  
            </div>             
        
            <div class="row mb-4">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <input type="submit" value="Guardar" class="btn btn-info">
                </div>	
            </div>

        </form>
    </div>

</div>
        
<?php 

require_once('../accesorios/admin-scripts.php'); 
mysqli_close($con); 

?>
