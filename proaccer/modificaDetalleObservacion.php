<?php

require('../accesorios/admin-superior.php'); 

require_once('../accesorios/accesos_bd.php');
$con=conectar();

$id 	    = $_GET['id'];
$id_proyecto= $_GET['id_proyecto'];
$id_usuario = $_SESSION['id_usuario'];

if($id <> 0){

    // DATOS DE LA INVERSION
    $query  = mysqli_query($con, "SELECT * FROM proaccer_detalle_observaciones WHERE id = $id" );
    $fila   = mysqli_fetch_array($query);

    $observacion 	=  $fila['observacion'];
    $titulo         = 'Modifica detalle de observación' ;

}else{

    $observacion 	=  NULL;
    $titulo         = 'Agrega detalle de observación' ;

}

?>


<div class="card">

    <div class="card-header">
        <div class="row">
            <div class="col">
                PROGRAMA APOYO COMERCIAL  - <b>FICHA DE SEGUIMIENTO</b>
            </div>
            <div class="col text-right">
                <h3><?php echo $_SESSION['solicitante'] ?></h3>
            </div>
        </div>
    </div>

    <div class="card-body">

        <div class="row">
            <div class="col">
                <h5 class="card-title"><?php echo $titulo ?></h5>	
            </div>
            <div class="col text-right">
                <a href="javascript:window.location='fichaSeguimiento.php?id=<?php echo $id_proyecto ?>'" class="btn btn-default">
                    <i class="far fa-arrow-alt-circle-left"></i>
                </a>	
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col">
                    <br>
                </div>                    
            </div>
        </div>

        <form name="observacion" action="guardaDetalleObservacion.php" method="POST">
            
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <input type="hidden" name="idDetalle" id="idDetalle" value="<?php echo $id ?>">
                        <input type="hidden" name="id_proyecto" id="id_proyecto" value="<?php echo $id_proyecto ?>">
                        <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $id_usuario ?>">
                    </div>                    
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label>Observación del proyecto</label>
                        <textarea name="observacion" id="observacion" class="form-control" rows="3"><?php echo $observacion ?></textarea>
                    </div>                    
                </div>
            </div>

            <div class="form-group">     
		        <div class="row">
                    <div class="col text-right">				
                       <input type="submit" value="Guardar" class="btn btn-info">
                    </div>	
                </div>
            </div>


        </form>
    </div>

</div>
        
<?php mysqli_close($con); ?>
