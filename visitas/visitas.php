<?php 

    require('../accesorios/admin-superior.php'); 

    require_once('../accesorios/accesos_bd.php');
    $con=conectar();

    $id_proyecto = $_GET['id_proyecto'];

    $tabla    = mysqli_query($con, "SELECT informe FROM proyectos WHERE id_proyecto = '$id_proyecto'");

    if ($registro = mysqli_fetch_array($tabla)) {
        $informe    = $registro['informe'];
    } ;
?> 
    
    <div class="card">
        <div class="card-header">   
            <div class="row">
                <div class="col-6">
                    <b><?php echo $_SESSION['titular'] ?> </b> - Visitas realizadas
                </div>  
                <div class="col-6">    
                    <?php include('../accesorios/menu_expediente.php');?>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">       
                <div class="col-md-2">Fecha         </div>
                <div class="col-md-3">Motivo        </div>
                <div class="col-md-3">Responsable   </div>
                <div class="col-md-4">Resultado     </div>
            </div>
            <div class="row">       
                <div class="col-md-2"><input id="fecha" type="date" tabindex="1" class="form-control" value="">   </div>
                <div class="col-md-3"><input id="motivo" type="text" tabindex="2" class="form-control" value="">    </div>
                <div class="col-md-3"><input id="responsable" type="text" tabindex="3" class="form-control" value="">  </div>
                <div class="col-md-4"><input id="resultado" type="text" tabindex="4" class="form-control" value=""></div>
            </div> 
            <div class="row">
                <div class="col-12">
                    <br>
                </div>
            </div>
            <div class="row">   
                <div class="col-sm-12">
                    
                    <div style="float:right">
                        <button type="button" class="btn btn-info" onClick="guardar_visita()">Guardar visita</button> 
                    </div>
                    <div style="float:right; display:none; font-weight:bold; color:#090;" id="estado">          
                    </div>
                </div>                  
            </div>

            <div class="row">
                <div class="col-12">
                    <br>
                </div>
            </div>
            
            <div style="overflow:scroll; width:100%; height:200px; overflow-x: hidden;">
                <div id="detalle_visitas">  </div>
                <div class="row">
                    <div class="col-md-12">&nbsp;</div>            
                </div>
            </div>
            
        </div>
    </div>


<?php require_once('../accesorios/admin-scripts.php'); ?>

<script>
    
    $(document).ready(function(){
        
    $("#detalle_visitas").load('detalle_visitas.php',{});
    }); 
    
    function guardar_visita(){
    
    var fecha       = document.getElementById('fecha').value;
    var motivo      = document.getElementById('motivo').value;
    var responsable = document.getElementById('responsable').value;
    var resultado   = document.getElementById('resultado').value;
    
    if(fecha.length == 0 || motivo.length == 0 || responsable.length == 0 || resultado.length == 0){
        $('#estado').css('color','#FF0000'); // COLOR ROJO
        $("#estado").html("Todo los campos son Obligatorios "); 
        $("#estado").fadeIn(0);
        $("#estado").fadeOut(2000);
        $("#estado").fadeIn(0);
        $("#estado").fadeOut(2000);
        $('#estado').css('color','#088A4B'); // COLOR VERDE
    }else{
        $("#detalle_visitas").load('detalle_visitas.php',{operacion:1,fecha:fecha,motivo:motivo,responsable:responsable,resultado:resultado});
    }
        
    }
    
    function borrar_visita(id){        
        if(confirm('Seguro que desea eliminar esta vista ? ')){
            $("#detalle_visitas").load('detalle_visitas.php',{operacion:2,id:id});
        }        
    }
        
</script> 

<?php require_once('../accesorios/admin-inferior.php'); ?>