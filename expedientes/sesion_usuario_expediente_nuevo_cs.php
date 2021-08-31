<?php 
    require('../accesorios/admin-superior.php');
    require_once('../accesorios/accesos_bd.php');
    $con=conectar();
?>	

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-12">
                CAPITAL SEMILLA NUEVO
            </div>
        </div>
    </div>    
    <div class="card-body">

            <form action ="agregar_expediente_cs.php" method="post" name="expedientes" id="expedientes">    
                <div class="row">
                <div class="col-sm-3">
                    Código Jov. Emp.
                    <input type="text" name="nro_proyecto" id="nro_proyecto" tabindex="1" onkeypress="return ValidaNumero(event)" class="form-control" required>
                </div>
                <div class="col-sm-3">
                    Rubro
                    <select name="id_rubro" id="id_rubro" size="1" tabindex="2" class="form-control">
                    <?php
                    $rubros = "select id_rubro, rubro from tipo_rubro_productivos where tipo = 1 order by rubro";
                    $registro = mysqli_query($con, $rubros); 
                    while($fila = mysqli_fetch_array($registro)){
                        echo "<option value=\"".$fila[0]."\">".$fila[1]."</option>\n";
                    }	
                    ?>
                    </select>
                </div>
            </div>

            <div class="row">    
                <div class="col-sm-3">
                    DNI
                    <input type="text" name="dni" id="dni" tabindex="3" onkeypress="return ValidaNumero(event)" class="form-control" required>
                </div>        
                <div class="col-sm-3">      
                    APELLIDO
                    <input type="text" name="apellido" id="apellido" tabindex="4" class="form-control" required>
                </div>
                <div class="col-sm-6">     
                    NOMBRES
                    <input type="text" name="nombres" id="nombres" tabindex="5" class="form-control" required>
                </div>
             </div>

             <div class="row">    
                <div class="col-sm-3">
                    Teléfono 
                    <input type="text" name="telefono" id="telefono" tabindex="6" class="form-control" required>
                </div>        
                <div class="col-sm-9">     
                    E-mail
                    <input type="email" name="email" id="email" tabindex="7" class="form-control" required>
                </div>
             </div>

             <div class="row">   
                <div class="col-sm-3">
                    Monto $
                    <input type="text" name="monto" id="monto" tabindex="8" onkeypress="return ValidaNumeroPunto(event)"  class="form-control">
                </div>
                <div class="col-sm-3">
                    Fecha otorgamiento
                    <input type="date" name="fecha_otorgamiento" id="fecha_otorgamiento" tabindex="9" class="form-control">        
                </div>
            </div> 

            <div class="row">        
                <div class="col-sm-6">
                    Localidad
                    <select name="id_localidad" tabindex="10" size="1" id="id_localidad" class="form-control">
                    <?php
                    $ciudades = "select localidades.id, localidades.nombre from localidades, departamentos, provincias where localidades.departamento_id = departamentos.id and departamentos.provincia_id = provincias.id and provincias.id = 7 order by localidades.nombre";
                    $registro = mysqli_query($con, $ciudades); 
                    while($fila = mysqli_fetch_array($registro)){
                        echo "<option value=\"".$fila[0]."\">".$fila[1]."</option>\n";
                    }	              
                    ?>
                    </select>
                </div>         
                <div class="col-sm-6">
                    Observaciones
                    <input type="text" name="observaciones" id="observaciones" tabindex="11" size="30" onkeyup="this.value=this.value.toUpperCase();" class="form-control">        
                </div>
            </div>  

            <div class="row"> 
                <div class="col-sm-12">&nbsp;</div>            
            </div>

            <div class="row"> 
                <div class="col-sm-6">

                </div>

                <div class="col-sm-3">
                    <button  tabindex="29" type="submit" title="Guardar" name="guardar" id="guardar" class="btn btn-default">Guardar</button> 
                </div>

                <div class="col-sm-3">    
                    <button  tabindex="30" type="button" name="salir" id="salir" onClick="window.location='padron_expedientes.php'" class="btn btn-default">Salir</button>
                </div>            
            </div>       
        </form>
    </div>
</div>
	
<?php 

mysqli_close($con); 

require_once('../accesorios/admin-scripts.php'); 

require_once('../accesorios/admin-inferior.php'); 

?>




