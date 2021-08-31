<?php 
require('../accesorios/admin-superior.php');
require_once('../accesorios/accesos_bd.php');
$con=conectar();

$id_emprendedor=$_GET['id'];

$tabla_emprendedores = mysqli_query($con, 
    "SELECT * 
    FROM emprendedores 
    WHERE id_emprendedor = '$id_emprendedor'" ) or die("Error leer emprendedores");
    
$registro = mysqli_fetch_array($tabla_emprendedores) ;

$apellido         = $registro['apellido'];	
$nombres          = $registro['nombres'];
$dni              = $registro['dni'];
$cuit             = $registro['cuit'];
$direccion        = $registro['direccion']; 
$fecha_nacimiento = $registro['fecha_nac'];
$id_localidad     = $registro['id_ciudad'];
$celular          = $registro['celular'];
$telefono         = $registro['telefono'];
$cod_area         = $registro['cod_area'];
$email            = $registro['email'];

$id_responsabilidad = $registro['id_responsabilidad'];
$id_condicion_laboral = $registro['id_condicion_laboral'];
//////////////////////////////////////////////////////////////////////////////////////////
$tabla_responsabilidad = mysqli_query($con,"SELECT responsabilidad FROM tipo_responsabilidad where id_responsabilidad = '$id_responsabilidad'");
if ($registro_responsabilidad = mysqli_fetch_array($tabla_responsabilidad)){
	$responsabilidad = $registro_responsabilidad['responsabilidad'];
}
///////////////////////////////////////////////////////////////////////////////////////////
$tabla_condicion_laboral = mysqli_query($con,"SELECT condicion_laboral FROM tipo_condicion_laboral where id_condicion_laboral = '$id_condicion_laboral'");
if ($registro_condicion_laboral = mysqli_fetch_array($tabla_condicion_laboral)){
	$condicion_laboral = $registro_condicion_laboral['condicion_laboral'];
}
//////////////////////////////////////////////////////////////////////////////////////////
$tabla_ciudad = mysqli_query($con,"SELECT nombre FROM localidades where id = '$id_localidad'");
if ($registro_ciudad = mysqli_fetch_array($tabla_ciudad)){
	$localidad = $registro_ciudad['nombre'];
}
///////////////////////////////////////////////////////////////////////////////////////////
if($id_localidad == 0){
    $id_provincia = 0;
    $provincia = ' ';

}else{
    $tabla_provincia = mysqli_query($con,"SELECT provincias.id, provincias.nombre FROM localidades, departamentos, provincias where localidades.departamento_id = departamentos.id and departamentos.provincia_id = provincias.id and localidades.id = '$id_localidad'");
    if ($registro_prov = mysqli_fetch_array($tabla_provincia)){
        $id_provincia = $registro_prov['id'];
        $provincia = $registro_prov['nombre'];
    }
}
///////////////////////////////////////////////////////////////////////////////////////////
$observaciones = $registro['observaciones'];

if($observaciones == 1){
    $consulta_observaciones = "SELECT observaciones FROM observaciones_emprendedores where id_emprendedor = '$id_emprendedor'";
    $tabla_observaciones = mysqli_query($con, $consulta_observaciones); 

    $registro_observaciones = mysqli_fetch_array($tabla_observaciones);
    $observaciones = $registro_observaciones['observaciones']; 	
	
}else{
    $observaciones = '';
}

?>	

    
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-sm-12">
            SOLICITANTE DEL CREDITO
          </div>
        </div>
      </div>
      <div class="card-body">

        <form method="post" name="emprendedor" id="emprendedor" action="editar_emprendedor.php?id=<?php echo $id_emprendedor?>" >
          
          <div class="row m-3">
            <div class="col-xs-12 col-sm-12 col-lg-4">
              DNI
              <input id="dni" name="dni" type="number" value="<?php echo $dni ?>" class="form-control" required autofocus>
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-4">  
              CUIT / CUIL
              <input id="cuit" name="cuit" type="number" value="<?php echo $cuit ?>" class="form-control" maxlength="11" required />
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-4">
              RESPONSABILIDAD 
              <select name="id_responsabilidad" id="id_responsabilidad" class="form-control">
                <?php
                  $responsabilidades = "SELECT * FROM tipo_responsabilidad";
                  $registro = mysqli_query($con, $responsabilidades); 
                  while($fila = mysqli_fetch_array($registro)){

                    if($id_responsabilidad == $fila[0]){
                      echo "<option value=".$fila[0]." selected >".$fila[1]."</option>";
                    }else{
                      echo "<option value=".$fila[0].">".$fila[1]."</option>";
                    }                    
                  }	
                ?>
              </select>  
              </div>
        </div>
        <div class="row m-3">
          <div class="col-xs-12 col-sm-12 col-lg-4">
            APELLIDO
            <input id="apellido" name="apellido" type="text" class="form-control mayus" value="<?php echo $apellido ?>">
          </div>
          <div class="col-xs-12 col-sm-12 col-lg-4">
            NOMBRES
            <input id="nombres" name="nombres" type="text" class="form-control mayus" value="<?php echo $nombres ?>">
          </div>
          <div class="col-xs-12 col-sm-12 col-lg-4">
          CONDICION LABORAL
            <select name="id_condicion_laboral" size="1" id="id_condicion_laboral" class="form-control">
              <?php
                $registro = mysqli_query($con, "SELECT * FROM tipo_condicion_laboral WHERE id_condicion_laboral <> 1 order by condicion_laboral"); 
                while($fila = mysqli_fetch_array($registro)){
                  if($id_condicion_laboral == $fila[0]){
                    echo "<option value=".$fila[0]." selected >".$fila[1]."</option>";
                  }else{
                    echo "<option value=".$fila[0].">".$fila[1]."</option>";
                  }
                }	                
                ?>
            </select>
          </div>
        </div> 

        <div class="row m-3">
          <div class="col-xs-12 col-sm-12 col-lg-4">
              DOMICILIO
            <input id="direccion" name="direccion" type="text" class="form-control mayus"  value="<?php echo $direccion ?>">
          </div>
          <div class="col-xs-12 col-sm-12 col-lg-4">
            E-MAIL
            <input name="email" type="email" id="email" class="form-control"  value="<?php echo $email ?>"/>
          </div>
          <div class="col-xs-12 col-sm-12 col-lg-4">
            FECHA NACIMIENTO
            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento"  class="form-control"  value="<?php echo $fecha_nacimiento ?>"/>
          </div>            
        </div>

        <div class="row m-3">
          <div class="col-xs-12 col-sm-12 col-lg-4">
            PROVINCIA
              <select name="provincia" id="provincia" size="1" onchange="from(document.emprendedor.provincia.value,'ciudad','ciudades.php')" class="form-control">
                <?php
                $registro   = mysqli_query($con, "SELECT id, nombre FROM provincias ORDER BY nombre"); 
                while($fila = mysqli_fetch_array($registro)){

                  if($id_provincia == $fila[0]){
                    echo "<option value=".$fila[0]." selected >".$fila[1]."</option>";
                  }else{
                    echo "<option value=".$fila[0].">".$fila[1]."</option>";
                  }

                }	
                ?>
              </select>
            
          </div>
          <div class="col-xs-12 col-sm-12 col-lg-8">
            LOCALIDAD
              <div id="ciudad">
                <select name="id_ciudad" id="id_ciudad" size="1" class="form-control">
                  <option value="<?php echo $id_localidad ?>" selected><?php echo $localidad ?></option>
                </select>
              </div>            
          </div>
        </div>

          
        <div class="row m-3">
          <div class="col-xs-12 col-sm-12 col-lg-4">
            COD. AREA 
            <input id="cod_area" name="cod_area" type="text" class="form-control"  value="<?php echo $cod_area ?>">
          </div>
          <div class="col-xs-12 col-sm-12 col-lg-4">
            CELULAR - Sin 15 
            <input id="celular" name="celular" type="text" class="form-control" value="<?php echo $celular ?>">
          </div>
          <div class="col-xs-12 col-sm-12 col-lg-4">
            FIJO
            <input id="telefono" name="telefono" type="text" class="form-control" value="<?php echo $telefono ?>">
          </div>            
        </div>
        
        <div class="row m-3">
          <div class="col-xs-12 col-sm-12 col-lg-6">
            &nbsp;
          </div>
        </div>

        <div class="row m-3">
          <div class="col-xs-12 col-sm-12 col-lg-12">
            OBSERVACIONES
            <input id="observaciones" name="observaciones" type="text" class="form-control mayus"  value="<?php echo $observaciones ?>">
          </div>            
        </div>

        <div class="row m-3">
          <div class="col-xs-12 col-sm-12 col-lg-6">
            &nbsp;
          </div>
        </div>

        <div class="row m-3">
          <div class="col-xs-12 col-sm-6 col-lg-6">
            (*) Todos los datos son obligatorios
          </div>
          <div class="col-xs-12 col-sm-6 col-lg-6 text-right">
            <button type="submit" name="guardar" id="guardar" class="btn btn-primary"> Guardar </button>
          </div>
        </div>  

    </div>

    </form>
    
<?php 

  mysqli_close($con); 
  require_once('../accesorios/admin-scripts.php');    ?>


<script type="text/javascript">
    
    function chequea_cuit(){
    
    var cuit = document.getElementById('cuit').value
    var url='verifica_emprendedor.php'
    
    $.ajax({   
        type: 'GET',
        url:url,
        data:{id:cuit},
        success: function(resp) {   
            if(resp == 0){    
                document.getElementById("estado").innerHTML="CUIT ya está registrado, presione Guardar.";
                setTimeout(function(){document.getElementById("cuit").focus();}, 0);
                return false
            }
        }
    });
    
    document.getElementById("estado").innerHTML=""
    return true 
    }
    
</script>

<?php require_once('../accesorios/admin-inferior.php'); ?>
