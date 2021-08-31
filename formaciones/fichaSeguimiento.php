<?php 

require('../accesorios/admin-superior.php'); 

require_once('../accesorios/accesos_bd.php');
$con=conectar();

$id                     = $_GET['id'];
$solicitante            = $_GET['solicitante'];
$_SESSION['solicitante']= $solicitante;

// DATOS DEL SEGUIMIENTO
$query_seg  = mysqli_query($con, "SELECT * FROM formacion_detalle_seguimiento WHERE id_solicitante = $id" );
$fila_seg   = mysqli_fetch_array($query_seg);

if(isset($fila_seg)){

    $asistio1 = $fila_seg['asistio1'];
    $asistio2 = $fila_seg['asistio2'];
    $asistio3 = $fila_seg['asistio3'];
    $asistio4 = $fila_seg['asistio4'];
    $asistio5 = $fila_seg['asistio5'];
    $asistio6 = $fila_seg['asistio6'];

}else{
    
    mysqli_query($con, "INSERT INTO formacion_detalle_seguimiento (id_solicitante) values ($id)" ) or die('Ver inserción seguimiento Formacion');
    $asistio1 = 0;
    $asistio2 = 0;
    $asistio3 = 0;
    $asistio4 = 0;
    $asistio5 = 0;
    $asistio6 = 0;
}


?>

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-lg-6">
                PROGRAMA FORMACION  - <b>FICHA DE SEGUIMIENTO</b>
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
            <div class="col-xs-12 col-sm-12 col-lg-12">
                <br>
            </div>
        </div>


        <form name="formseguimiento" id="formseguimiento" > 
            
            <input type="hidden" class="form-control" name = "id_solicitante" id = "id_solicitante" value="<?php echo $id ?>">                    

                <div class="row text-center mb-5">

                    <div class="col-xs-12 col-sm-2 col-lg-2">
                        <p>¿Asistió al 1° encuentro?</p>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="radio2" name="asistio1" value="1" class="custom-control-input" <?php if($asistio1 == 1){ echo 'checked';} ?>>
                            <label class="custom-control-label" for="radio2">Si</label>                        
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="radio1" name="asistio1" value="0" class="custom-control-input" <?php if($asistio1 <> 1){ echo 'checked';} ?>>
                            <label class="custom-control-label" for="radio1">No</label> 
                        </div>                            
                    </div> 

                    <div class="col-xs-12 col-sm-2 col-lg-2">
                        <p>¿Asistió al 2° encuentro?</p>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="radio4" name="asistio2" value="1" class="custom-control-input" <?php if($asistio2 == 1){ echo 'checked';} ?>>
                            <label class="custom-control-label" for="radio4">Si</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="radio3" name="asistio2" value="0" class="custom-control-input" <?php if($asistio2 <> 1){ echo 'checked';} ?>>
                            <label class="custom-control-label" for="radio3">No</label>
                        </div>
                    </div>
                
                    <div class="col-xs-12 col-sm-2 col-lg-2">                        
                        <p>¿Asistió al 3° encuentro?</p>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="radio6" name="asistio3" value="1" class="custom-control-input" <?php if($asistio3 == 1){ echo 'checked';} ?>>
                            <label class="custom-control-label" for="radio6">Si</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="radio5" name="asistio3" value="0" class="custom-control-input" <?php if($asistio3 <> 1){ echo 'checked';} ?>>
                            <label class="custom-control-label" for="radio5">No</label>
                        </div>
                    </div>
                
                    <div class="col-xs-12 col-sm-2 col-lg-2">
                        <p>¿Asistió al 4° encuentro?</p>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="radio8" name="asistio4" value="1" class="custom-control-input" <?php if($asistio4 == 1){ echo 'checked';} ?>>
                            <label class="custom-control-label" for="radio8">Si</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="radio7" name="asistio4" value="0" class="custom-control-input" <?php if($asistio4 <> 1){ echo 'checked';} ?>>
                            <label class="custom-control-label" for="radio7">No</label>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-2 col-lg-2">
                        <p>¿Asistió al 5° encuentro?</p>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="radio10" name="asistio5" value="1" class="custom-control-input" <?php if($asistio5 == 1){ echo 'checked';} ?>>
                            <label class="custom-control-label" for="radio10">Si</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="radio9" name="asistio5" value="0" class="custom-control-input" <?php if($asistio5 <> 1){ echo 'checked';} ?>>
                            <label class="custom-control-label" for="radio9">No</label>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-2 col-lg-2">
                        <p>¿Asistió al 6° encuentro?</p>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="radio12" name="asistio6" value="1" class="custom-control-input" <?php if($asistio6 == 1){ echo 'checked';} ?>>
                            <label class="custom-control-label" for="radio12">Si</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="radio11" name="asistio6" value="0" class="custom-control-input" <?php if($asistio6 <> 1){ echo 'checked';} ?>>
                            <label class="custom-control-label" for="radio11">No</label>
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
            
        <div id="detalleFormacion" class="mb-3">
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

    var id = $("#id_solicitante").val();

    $("#estado").show();
    $("#detalleFormacion").load('detalleFormacion.php', {id:id});
    $("#detalleObservacion").load('detalleObservacion.php', {id:id});
});

function guardar(this1){

this1.disabled = true;
this1.innerHTML = 'Guardando <span class="spinner-border spinner-border-sm"></span>';

var url = "guardarSeguimiento.php";

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

function borrarObjetivos(id){

    var det= id;

    var id = $("#id_solicitante").val();
    
    if(confirm('Elimina objetivo/s seleccionado')){

        $("#detalleFormacion").load('detalleFormacion.php', {det:det, id:id});

    }
    
}

function borrarObservacion(id){

    var det= id;
    var id = $("#id_solicitante").val();

    if(confirm('Elimina observacion del solicitante')){

        $("#detalleObservacion").load('detalleObservacion.php', {id:id, det:det});

    }
}

</script>


<?php require_once('../accesorios/admin-inferior.php'); ?>
