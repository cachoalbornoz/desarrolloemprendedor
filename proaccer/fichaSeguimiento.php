<?php require('../accesorios/admin-superior.php'); 

require_once('../accesorios/accesos_bd.php');
$con=conectar();

$id         = $_GET['id'];
$solicitante= $_GET['solicitante'];

// DATOS DEL SEGUIMIENTO
$query_seg  = mysqli_query($con, "SELECT * FROM proaccer_detalle_seguimiento WHERE id_proyecto = $id" );
$fila_seg   = mysqli_fetch_array($query_seg);

if(isset($fila_seg)){

    $presentoexpediente = $fila_seg['presentoexpediente'];
    $sepago             = $fila_seg['sepago'];
    $solicitovideo      = $fila_seg['solicitovideo'];
    $presentorendicion  = $fila_seg['presentorendicion'];

}else{
    
    mysqli_query($con, "INSERT INTO proaccer_detalle_seguimiento (id_proyecto) values ($id)" ) or die('Ver inserción seguimiento Proaccer');
    $presentoexpediente = 0;
    $sepago             = 0;
    $solicitovideo      = 0;
    $presentorendicion  = 0;
}


?>

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-lg-6">
                PROGRAMA APOYO COMERCIAL  - <b>FICHA DE SEGUIMIENTO</b>
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-6 text-right font-weight-bold">
                <p><?php echo $solicitante ?></p>
            </div>
        </div>
    </div>

    <div class="card-body">

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-lg-12">
                <div class="text-right">
                    
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <br>
            </div>
        </div>


        <form name="formseguimiento" id="formseguimiento" > 
            
            <input type="hidden" class="form-control" name = "idProaccer" id = "idProaccer" value="<?php echo $id ?>">                    

                <div class="row text-center mb-5">

                    <div class="col-xs-12 col-sm-3 col-lg-3">
                        <p>¿Se presentó el expediente ?</p>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="radio1" name="presentoexpediente" value="0" class="custom-control-input" <?php if($presentoexpediente == 0){ echo 'checked';} ?>>
                            <label class="custom-control-label" for="radio1">No</label> 
                        </div>    
                        <div class="custom-control custom-radio">
                            <input type="radio" id="radio2" name="presentoexpediente" value="1" class="custom-control-input" <?php if($presentoexpediente == 1){ echo 'checked';} ?>>
                            <label class="custom-control-label" for="radio2">Si</label>                        
                        </div>    
                    </div> 

                    <div class="col-xs-12 col-sm-3 col-lg-3">
                        <p>¿Se pagó ?</p>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="radio3" name="sepago" value="0" class="custom-control-input" <?php if($sepago == 0){ echo 'checked';} ?>>
                            <label class="custom-control-label" for="radio3">No</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="radio4" name="sepago" value="1" class="custom-control-input" <?php if($sepago == 1){ echo 'checked';} ?>>
                            <label class="custom-control-label" for="radio4">Si</label>
                        </div>
                    </div>
                
                    <div class="col-xs-12 col-sm-3 col-lg-3">                        
                        <p>¿Solicitó video ?</p>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="radio5" name="solicitovideo" value="0" class="custom-control-input" <?php if($solicitovideo == 0){ echo 'checked';} ?>>
                            <label class="custom-control-label" for="radio5">No</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="radio6" name="solicitovideo" value="1" class="custom-control-input" <?php if($solicitovideo == 1){ echo 'checked';} ?>>
                            <label class="custom-control-label" for="radio6">Si</label>
                        </div>
                    </div>
                
                    <div class="col-xs-12 col-sm-3 col-lg-3">
                        <p>¿Presentó rendición ?</p>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="radio7" name="presentorendicion" value="0" class="custom-control-input" <?php if($presentorendicion == 0){ echo 'checked';} ?>>
                            <label class="custom-control-label" for="radio7">No</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="radio8" name="presentorendicion" value="1" class="custom-control-input" <?php if($presentorendicion == 1){ echo 'checked';} ?>>
                            <label class="custom-control-label" for="radio8">Si</label>
                        </div>
                    </div>

                </div>
               
		        <div class="row">
                    <div class="col-xs-12 col-sm-9 col-lg-9 text-center">

                    </div>
                    <div class="col-xs-12 col-sm-3 col-lg-3 text-center">				
                        <button type="button" class="btn btn-info mr-3" id="enviar" onclick="guardar(this);">
                            <i class="fas fa-save"></i> Guardar
                        </button>
                        <a href="javascript:window.location='imprimirSeguimiento.php?id=<?php echo $id?>'" class="btn btn-info" title="Imprime seguimiento">
                            <i class="fas fa-print"></i> Imprimir
                        </a>
                    </div>	
                </div>

            </div>

        </form>
            
        <div id="detalleInversion">
            <div id="estado" style="display:none">
                Recuperando información, aguarde  <i class="fa fa-spinner fa-spin fa-fw"></i>
            </div>
        </div>

        <div id="detalleObservacion">
            <div id="estado" style="display:none">
                Recuperando información, aguarde  <i class="fa fa-spinner fa-spin fa-fw"></i>
            </div>
        </div>
        
        

    </div>
    
</div>

<?php require_once('../accesorios/admin-scripts.php'); ?>

<script type="text/javascript">

$(document).ready(function(){

    var id = $("#idProaccer").val();

    $("#estado").show();
    $("#detalleInversion").load('detalleInversion.php', {id:id});
    $("#detalleObservacion").load('detalleObservacion.php', {id:id});
});

function guardar(this1){

this1.disabled = true;
this1.innerHTML = 'Guardando <span class="spinner-border spinner-border-sm"></span>';

var url = "guardarProyecto.php";

$.ajax({
    type: "POST",
    url: url,
    data: $("#formseguimiento").serialize(),
    success: function(data){

        setTimeout(function(){ 
            this1.disabled = false;
            this1.innerHTML = '<i class="fas fa-save"></i> Guardar';

        }, 1000);

        var dt      = new Date();
        var time    = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
        console.log(time + ' Dato que vuelve : ' + data) ;                
    }
});

return false;
}

function borrarInversion(id){

    var det= id;
    var id = $("#idProaccer").val();

    if(confirm('Elimina inversion del Proyecto')){

        $("#detalleInversion").load('detalleInversion.php', {id:id, det:det});

    }
    
}

function borrarObservacion(id){

    var det= id;
    var id = $("#idProaccer").val();

    if(confirm('Elimina observacion del Proyecto')){

        $("#detalleObservacion").load('detalleObservacion.php', {id:id, det:det});

    }
}

</script>


<?php require_once('../accesorios/admin-inferior.php'); ?>
