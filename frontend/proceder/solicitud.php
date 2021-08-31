<?php
session_start();
if(!isset($_SESSION['usuario'])){
    header('location:../accesorios/salir.php');
    exit;
}


require_once($_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/frontend/accesorios/front-superior.php');

require_once($_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/accesorios/accesos_bd.php');
$con=conectar();

$id_solicitante = $_SESSION['id_usuario']; 

// RUTA DE EDICION

$ruta = '/desarrolloemprendedor/frontend/registro_edita.php?id_solicitante='.$id_solicitante;

// LEER REGISTRO INSCRIPCION

$tabla_registro = mysqli_query($con, "SELECT * FROM registro_solicitantes WHERE id_solicitante = $id_solicitante");
$registro       = mysqli_fetch_array($tabla_registro);

$id_rubro       = $registro['id_rubro'];
$id_medio       = $registro['id_medio'];
$id_programa    = $registro['id_programa'];
$id_empresa     = $registro['id_empresa'];
$resena         = $registro['observaciones'];

// LEER MEDIOS DE INFORMACION
$tabla_medios   = mysqli_query($con, "SELECT hab.id_medio, medios.medio, hab.id_programa, prog.programa 
FROM habilitaciones hab
INNER JOIN tipo_medios_contacto medios ON hab.id_medio = medios.id_medio
INNER JOIN tipo_programas prog ON hab.id_programa = prog.id_programa
WHERE hab.id_solicitante = $id_solicitante");

$registro_medios= mysqli_fetch_array($tabla_medios);


// INICIALIZO VARIABLES DEL PROYECTO

$historia   = NULL;
$detalleser = NULL;
$historia   = NULL;
$detallepro = NULL;
$resenia    = NULL;
$monto      = 0;
$rubro      = NULL;
$aspectos   = NULL;


// COMPROBAR SI EL USUARIO TIENE UN "PROYECTO PROCEDER"

$tabla_proyecto = mysqli_query($con, 
"SELECT * FROM rel_proceder rela
INNER JOIN proceder_proyectos proce ON rela.id_proyecto = proce.id_proyecto
WHERE rela.id_solicitante = $id_solicitante");

if($registro_proyecto = mysqli_fetch_array($tabla_proyecto)){

    // DATOS DEL PROYECTO

    $id_proyecto= $registro_proyecto['id_proyecto'];
    $id_inversor= $registro_proyecto['id_inversor'];
    $id_empresa = $registro_proyecto['id_empresa'];

    $detalleser = $registro_proyecto['detalleservicio'];
    $historia   = $registro_proyecto['historia'];
    $detallepro = $registro_proyecto['detalleproducto'];
    $resenia    = $registro_proyecto['resenia'];
    $monto      = $registro_proyecto['monto'];
    $rubro      = $registro_proyecto['rubro'];
    $aspectos   = $registro_proyecto['aspectos'];

}else{    

    // CREAR REGISTRO DE PROYECTO PROCEDER DESDE 0

    mysqli_query($con, "INSERT INTO proceder_proyectos () values ()") or die("Error inserción Proceder Proyecto");
    $id_proyecto = mysqli_insert_id($con);

    mysqli_query($con, "INSERT INTO proceder_inversores () values ()") or die("Error inserción Proceder Inversor");
    $id_inversor = mysqli_insert_id($con);

    mysqli_query($con, "INSERT INTO proceder_empresas () values ()") or die("Error inserción Proceder Empresa");
    $id_empresa = mysqli_insert_id($con);

    mysqli_query($con, "INSERT INTO rel_proceder 
    (id_proyecto, id_solicitante, id_inversor, id_empresa) 
    values ($id_proyecto, $id_solicitante, $id_inversor, $id_empresa)");

}

$_SESSION['id_proyecto']    = $id_proyecto ;
$_SESSION['id_empresa']     = $id_empresa ;
$_SESSION['id_inversor']    = $id_inversor ;

?>

<div class="container">

    <form id="solicitud" name="solicitud">


        <!-- Barra Flotante -->

        <div id="spopup" style="display: none;">
            <div class="btn-group" role="group" aria-label="botones">
                <a href="#principio" class="btn btn-default" title="Arriba">
                    <i class="fas fa-arrow-alt-circle-up"></i>
                </a>
                <a href="#final" class="btn btn-default" title="Abajo">
                    <i class="fas fa-arrow-alt-circle-down"></i>
                </a>
                <button type="button" class="btn btn-secondary" id="enviar" onclick="guardar(this);">
                    <i class="fas fa-save"></i> Guardar
                </button>
                <a href="imprimir.php" class="btn btn-default" title="Imprime proyecto">
                    <i class="fas fa-print"></i>
                </a>
                <a href="#" class="btn btn-default" onClick="salida()" title="Salir">
                    <i class="fas fa-sign-out-alt"></i> (salir)
                </a>
            </div>
        </div>

        <!-- Fin Barra      -->

        <div class="card" id="principio">
            <div class="card-header">
                <div class="row">                    
                    <div class="col">
                        <h4>Complete el siguiente formulario</h4>                                                
                        <input type="hidden" id="id_proyecto" name="id_proyecto" value="<?php echo $id_proyecto ; ?>">
                        <input type="hidden" id="id_inversor" name="id_inversor" value="<?php echo $id_inversor ; ?>">                    
                        <input type="hidden" id="id_empresa"  name="id_empresa"  value="<?php echo $id_empresa ;  ?>">                        
                    </div>     
                    <div class="col text-right">
                        <a href="imprimir.php" class="btn btn-default" title="Imprime proyecto">
                            <i class="fas fa-print"></i>
                        </a>
                    </div>        
                </div>
            </div>
        </div>   
        
        <div class="row">
            <div class="col">
                <br>
            </div>
        </div>  

        <!--Datos de Emprendedor -->
        <div class="card ">

            <div class="card-header bg-info text-white">
                <div class="row">
                    <div class="col">
                        <h3>Datos del solicitante</h3>
                    </div>
                    <div class="col text-right">                    
                        <a class=" text-white" href="<?php echo $ruta ?>">
                            <h5><i class="fas fa-edit"></i> Mis datos </h5>
                        </a>
                    </div>
                </div>                
            </div>

            <div class="card-body" id="detalle_solicitante">

            </div>

            <div class="card-body" id="detalle_empresa">

            </div>

        </div>

        <div class="row">
            <div class="col">
                <br>
            </div>                    
        </div>

        <!--Datos de Inversor -->
        <div class="card ">

            <div class="card-header bg-info text-white">
                <div class="row">
                    <div class="col">
                        <h3>Datos del Inversor</h3>
                    </div>
                </div>                
            </div>

            <div class="card-body" id="detalle_inversor">

            </div>

            <div class="card-body" id="detalle_empresai">

            </div>

        </div>

        <div class="row">
            <div class="col">
                <br>
            </div>                    
        </div>


        <!--Datos del Proyecto Actual -->
        <div class="card ">

            <div class="card-header bg-info text-white">
                <div class="row">
                    <div class="col">
                        <h3>Datos del Proyecto</h3>
                    </div>
                </div>                
            </div>

            <div class="card-body">

                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h4>Producción actual del emprendimiento</h4>
                        </div>
                    </div>                
                </div>
    
                <div class="row">    
                    <div class="col">                                 
                        <label class="p-3">Rubro del bien, servicio o proceso</label>
                        <textarea name="detalleser" id="detalleser" rows="3" class="form-control" required><?php echo $detalleser ?></textarea>
                        <small class="text-muted">Máximo 300 caracteres</small>
                    </div>
                </div>

                <div class="row">    
                    <div class="col">
                        <label class="p-3">Breve descripción de la historia del emprendimiento</label>
                        <textarea name="historia" id="historia" rows="7" class="form-control"><?php echo $historia ?></textarea>
                        <small class="text-muted">Máximo 600 caracteres</small>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col">
                        <label class="p-3">Tipo de Producto actualmente producidos, volumen y mercado (local, regional, nacional, internacional)</label>
                        <textarea name="detallepro" id="detallepro" rows="7" class="form-control"><?php echo $detallepro ?></textarea>
                        <small class="text-muted">Máximo 600 caracteres</small>
                    </div>                                       
                </div>

                <div class="row">
                    <div class="col">
                        <br>
                    </div>                    
                </div>

                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h4>Proyecto a desarrollar</h4>
                        </div>
                    </div>                
                </div>

                    
                <div class="row">    
                    <div class="col p-3">                                 
                        <label>Breve reseña del proyecto a desarrollar</label>
                        <textarea name="resenia" id="resenia" rows="7" class="form-control"><?php echo $resenia ?></textarea>                    
                        <small class="text-muted">Máximo 600 caracteres</small>
                    </div>
                </div>

                <div class="row">    
                    <div class="col-3">                                 
                        <label>Monto requerido</label>
                        <input name="monto" id="monto" type="number" class="form-control" value="<?php echo $monto ?>">
                    </div>
                </div>

                <div class="row">     
                    <div class="col p-3">                                 
                        <label>Rubros generales de utilización del mismo</label>
                        <textarea name="rubro" id="rubro" type="text" rows="3" class="form-control"><?php echo $rubro ?></textarea>
                        <small class="text-muted">Máximo 300 caracteres</small>
                    </div>
                </div>

                <div class="row">     
                    <div class="col p-3">                                 
                        <label>¿En qué aspectos considera que el desarrollo del proyecto de inversión representará una innovación o crecimiento para el emprendimiento ?</label>
                        <textarea name="aspectos" id="aspectos" rows="7" class="form-control"><?php echo $aspectos ?></textarea>                    
                        <small class="text-muted">Máximo 600 caracteres</small>
                    </div>
                </div>
                
            </div>
        </div>

        <div class="row">
            <div class="col">
                <br>
            </div>                    
        </div>

        <!-- Datos de Registro -->
        <div class="card" id="final">

            <div class="card-header bg-info text-white">
                <div class="row">
                    <div class="col">
                        <h3>DATOS DEL REGISTRO INICIAL</h3>
                    </div>
                </div>                
            </div>

            <div class="card-body">
                
                <div class="row">

                    <div class="col">
                        <label class="p-3">¿Cómo te enteraste de éstos Programas ?</label>

                        <div class="radio">                                
                            <label><input type="radio" name="id_medio" value="1" <?php if($id_medio == 1){ echo 'checked';}?> required > Facebook</label>
                        </div>
                        <div class="radio">                            
                            <label><input type="radio" name="id_medio" value="2" <?php if($id_medio == 2){ echo 'checked';}?>> Televisión</label>
                        </div>
                        <div class="radio">                            
                            <label><input type="radio" name="id_medio" value="3" <?php if($id_medio == 3){ echo 'checked';}?>> Radio</label>                                
                        </div> 
                        <div class="radio">                            
                            <label><input type="radio" name="id_medio" value="4" <?php if($id_medio == 4){ echo 'checked';}?>> Internet</label>                                
                        </div> 
                        <div class="radio">                            
                            <label><input type="radio" name="id_medio" value="5" <?php if($id_medio == 5){ echo 'checked';}?>> Diarios</label>                                
                        </div> 
                        <div class="radio">                            
                            <label><input type="radio" name="id_medio" value="6" <?php if($id_medio == 6){ echo 'checked';}?>> Otros</label>                                
                        </div>                           
                    </div>

                    <div class="col">
                        <label class="p-3">Cuál es tu interés?</label>
                        <div class="radio">                                
                            <label><input type="radio" name="id_programa" value="1" <?php if($id_programa == 1){ echo 'checked';}?> required > Jóvenes Emprendedores</label>
                        </div>
                        <div class="radio">                            
                            <label><input type="radio" name="id_programa" value="2" <?php if($id_programa == 2){ echo 'checked';}?>> Apoyo al Comercio emprendedor</label>
                        </div>
                        <div class="radio">                            
                            <label><input type="radio" name="id_programa" value="4" <?php if($id_programa == 4){ echo 'checked';}?>> Formación</label>                                
                        </div> 
                        <div class="radio">                            
                            <label><input type="radio" name="id_programa" value="5" <?php if($id_programa == 5){ echo 'checked';}?>> Consolidación de Emprendimientos</label>           
                        </div> 
                    </div>
                </div>    
                    
                <div class="row">
                    <div class="col">
                        <label class=" p-3">Reseña breve del proyecto</label>
                        <textarea name="idea" id="idea" class="form-control" rows="6" placeholder="Describa las cualidades principales. Máx 1800 caracteres" required><?php echo $reseniaoriginal ?></textarea>
                    </div>
                </div>

            </div>
        </div>    
    
    </form>

</div>
       

<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/frontend/accesorios/front-scripts.php'); ?>

<style>
    #spopup{
        opacity: 0.8;
        width:auto;
        position:fixed;
        bottom:13px;
        right:25px;
        display:none;
        z-index:90;
    }

    .hidden{ 
        display: none;
    }

</style>

<script>

    $(document).ready(function(){

        $("#monto").bind("cut copy paste",function(e) {
            e.preventDefault();
        });

        $("#detalle_solicitante").load('detalle_solicitante.php',{operacion:0});
        $("#detalle_empresa").load('detalle_empresa.php',{operacion:0});
        $("#detalle_inversor").load('detalle_inversor.php',{operacion:0});
        $("#detalle_empresai").load('detalle_empresai.php',{operacion:0});

    });


    $(window).scroll(function(){
        if($(document).scrollTop()>= ($(document).height()/50))
            $("#spopup").show("slow");
        else
            $("#spopup").hide("slow");
    });

    // Funcion incorporada de Internet para que no metan espacios en blancos y parezca un campo completado
    // Devuelve String sin espacios
    String.prototype.trimstring = function() { return this.replace(/^\s+|\s+$/g, ""); };
    //

    function guardar(this1){

        this1.disabled = true;
        this1.innerHTML = 'Guardando ' + '<i class="fa fa-refresh fa-spin"></i>';

        var url = "guardar_proyecto.php";

        $.ajax({
            type: "POST",
            url: url,
            data: $("#solicitud").serialize(),
            success: function(data){

                setTimeout(function(){ 
                    this1.disabled = false;
                    this1.innerHTML = 'Guardar';

                }, 1000);

                var dt      = new Date();
                var time    = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
                console.log(time + ' Dato que vuelve : ' + data) ;                
            }
        });

        return false;
}

</script>




<?php require_once($_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/frontend/accesorios/front-inferior.php'); ?>
