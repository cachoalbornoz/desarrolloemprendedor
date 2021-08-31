<?php

require('../accesorios/admin-superior.php'); 

require_once('../accesorios/accesos_bd.php');
$con=conectar();

$id 	        = $_GET['id'];
$id_solicitante = $_GET['id_solicitante'];
$id_usuario     = $_SESSION['id_usuario'];

if($id <> 0){

    // DATOS DE LA INVERSION
    $query  = mysqli_query($con, "SELECT * FROM formacion_detalle_observaciones WHERE id = $id" );
    $fila   = mysqli_fetch_array($query);

    $observacion 	= $fila['observacion'];
    $id_usuario     = $fila['id_capacitador'];

    $titulo         = 'Modifica detalle de observación' ;

}else{

    $observacion 	= NULL;

    $titulo         = 'Agrega detalle de observación' ;

}

?>


<div class="card">

    <div class="card-header">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-lg-12">
                PROGRAMA FORMACION  - <b>FICHA DE SEGUIMIENTO</b>
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
                <div class="col">
                    <br>
                </div>                    
            </div>
        </div>

        <form name="observacion" action="guardaDetalleObservacion.php" method="POST">
            
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <input type="hidden" name="idDetalle" id="idDetalle" class="form-control" value="<?php echo $id ?>">
                        <input type="hidden" name="id_solicitante" id="id_solicitante" class="form-control" value="<?php echo $id_solicitante ?>">
                    </div>                    
                </div>
            </div>

            <div class="form-group">
                <div class="row mb-5">
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <label class="mb-2">
                            Tutor
                        </label>
                        <select id="id_usuario" name="id_usuario" class="form-control" required>
                        <option value="" disabled selected>Seleccione tutor .... &nbsp;</option>
                        <?php
                        $registro  = mysqli_query($con, "SELECT id_usuario, CONCAT(apellido, ', ',nombres ) FROM usuarios WHERE estado = 'f' ORDER BY nombre_usuario asc");
                        while ($fila = mysqli_fetch_array($registro)) {

                            if($fila['id_usuario'] == $id_usuario){
                                ?>
                                <option value=<?php echo $fila[0] ?> selected ><?php echo strtoupper($fila[1]) ?></option>
                                <?php

                            }else{
                                ?>
                                <option value=<?php echo $fila[0] ?> ><?php echo strtoupper($fila[1]) ?></option>
                                <?php
                            }
                        }
                        ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label>Acciones</label>
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
