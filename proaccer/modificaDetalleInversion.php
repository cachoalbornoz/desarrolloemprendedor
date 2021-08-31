<?php

require('../accesorios/admin-superior.php'); 

require_once('../accesorios/accesos_bd.php');
$con=conectar();

$id 	    = $_GET['id'];
$id_proyecto= $_GET['id_proyecto'];

if($id <> 0){

    // DATOS DE LA INVERSION
    $query  = mysqli_query($con, "SELECT * FROM proaccer_detalle_inversiones WHERE  id = $id" );
    $fila   = mysqli_fetch_array($query, MYSQLI_BOTH);

    $descripcion 	=  $fila['descripcion'];
    $facturo 	    =  $fila['facturo'];
    $ejecuto 	    =  $fila['ejecuto'];
    $situacion 	    =  $fila['situacion'];

    $titulo         = 'Modifica detalle de inversión' ;

}else{

    $descripcion 	=  NULL;
    $facturo 	    =  0;
    $ejecuto 	    =  0;
    $situacion 	    =  NULL;

    $titulo         = 'Agrega detalle de inversión' ;

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

        <form name="inversion" action="guardaDetalleInversion.php" method="POST">
            
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <input type="hidden" name="idDetalle" id="idDetalle" class="form-control" value="<?php echo $id ?>">
                        <input type="hidden" name="id_proyecto" id="id_proyecto" class="form-control" value="<?php echo $id_proyecto ?>">
                    </div>                    
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label>Descripción de la inversión</label>
                        <input name="descripcion" id="descripcion" class="form-control" value="<?php echo $descripcion ?>">
                    </div>                    
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label>
                            Facturó
                            <input type="checkbox" name="facturo" id="facturo" <?php if($facturo == 1){ echo 'checked';} ?>>
                        </label>
                    </div>                    
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label>Ejecutó
                            <input type="checkbox" name="ejecuto" id="ejecuto" <?php if($ejecuto == 1){ echo 'checked';} ?>>
                        </label>
                    </div>                    
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label>En qué situación está ?</label>
                        <textarea name="situacion" id="situacion" rows="3" class="form-control"><?php echo $situacion ?></textarea>
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
