<?php 
    require('../accesorios/admin-superior.php'); 
    require('../accesorios/accesos_bd.php');
    $con=conectar();
?>

<div class="card">
    <div class="card-header">

        <div class="row">
            <div class="col-xs-12 col-md-12 col-lg-12">
                EXPEDIENTE NUEVO
            </div>
        </div>    
    </div>
    <div class="card-body"> 

        <form action ="agregar_expediente.php" method="post" name="expedientes" id="expedientes">    
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">Nro proyecto
                    <input type="number" name="nro_proyecto" id="nro_proyecto" class="form-control" required> 
                    </div>
                </div>
            <div class="col-sm-9">
                <div class="form-group">
                    Rubro
                    <select name="id_rubro" id="id_rubro" size="1" class="form-control">
                    <?php
                    $rubros = "select id_rubro, rubro from tipo_rubro_productivos order by rubro";
                    $registro = mysqli_query($con, $rubros); 
                    while($fila = mysqli_fetch_array($registro)){
                        echo "<option value=\"".$fila[0]."\">".$fila[1]."</option>\n";
                    }	

                    ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">    
            <div class="col-sm-6">
                <div class="form-group">
                    Nro expediente madre
                    <input type="number" name="nro_expediente_madre" id="nro_expediente_madre" required class="form-control">	
                </div>
            </div>        
            <div class="col-sm-6">
                <div class="form-group">       
                    Nro expediente control
                  <input type="text" name="nro_expediente_control" id="nro_expediente_control" class="form-control">
                </div>
            </div>
        </div>

        <div class="row">    
            <div class="col-sm-6">
                <div class="form-group"> 
                    Monto
                  <input type="number" name="monto" id="monto" class="form-control" step="any">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    Fecha otorgamiento
                  <input type="date" name="fecha_otorgamiento" id="fecha_otorgamiento" class="form-control">        
                </div>
            </div>
        </div> 

        <div class="row">        
            <div class="col-sm-6">
                <div class="form-group">
                Localidad
                <select name="id_localidad" tabindex="8" size="1" id="id_localidad" class="form-control">
                <?php
            
                $ciudades = "select localidades.id, localidades.nombre from localidades, departamentos, provincias where localidades.departamento_id = departamentos.id and departamentos.provincia_id = provincias.id and provincias.id = 7 order by localidades.nombre";
                $registro = mysqli_query($con, $ciudades); 
                while($fila = mysqli_fetch_array($registro)){
                    echo "<option value=\"".$fila[0]."\">".$fila[1]."</option>\n";
                }	               
                ?>
                </select>
                </div>
            </div>  
        </div>

        <div class="row">           
            <div class="col-sm-12">
                <div class="form-group">
                Observaciones
                    <textarea name="observaciones" id="observaciones" class="form-control" rows="2"></textarea>
                </div>
            </div>
        </div>  

        <div class="row m-5">    
            <div class="col-sm-12">

            </div>
        </div>

        <div class="row"> 
            <div class="col-sm-12 text-right">
                <div class="form-group">
                    <button  type="submit" title="Guardar" name="guardar" id="guardar" class="btn btn-secondary">Guardar</button> 
                </div>
            </div>           
        </div>       
        </form>
    </div>    
</div>

<?php 
    mysqli_close($con); 
    require_once('../accesorios/admin-scripts.php'); ?>

<script type="text/javascript">    
    
    function revisar_proyecto(){
        
        var url='leer_expediente.php'
        $.ajax({   
            type: 'GET',
            url:url,
            data:{id:nro_proyecto, fecha:fecha},
            success: function(resp)
            {   
                if(resp == 0)
                {    
                    document.getElementById("estado").innerHTML="Ya existe ese <b>Nro proyecto "+ nro_proyecto +"</b>. Controle por favor";
                    setTimeout(function(){document.getElementById("nro_proyecto").focus();}, 0);
                    return false
                }
            }
        });
    }
</script>

<?php require_once('../accesorios/admin-inferior.php'); ?>