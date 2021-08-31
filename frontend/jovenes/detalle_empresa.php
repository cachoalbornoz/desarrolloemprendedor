<?php

session_start();

require($_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/accesorios/accesos_bd.php');
$con=conectar();


$id_solicitante     = $_SESSION['id_usuario'];

if(isset($_POST['eliminar'])){

    $id_empresa = $_POST['id_empresa'];

    mysqli_query($con, "DELETE FROM maestro_empresas WHERE id = $id_empresa");

    mysqli_query($con, "UPDATE registro_solicitantes SET id_empresa = 0 WHERE id_solicitante = $id_solicitante");


}

// INICIALIZO DATOS DE LA EMPRESA
$id_empresa			= 0;
$razon_social       = NULL;
$cuite              = NULL;
$id_tipo_sociedad   = NULL;
$fecha_inscripcion  = NULL;
$fecha_inicio       = NULL;
$domiciliol         = NULL;
$nrol               = NULL;
$id_ciudadl         = NULL;
$ciudadl            = NULL;
$departamentol      = NULL;
$id_departamentol   = NULL;
$domicilior         = NULL;
$nror               = NULL;
$id_ciudadr         = NULL;
$ciudadr            = NULL;
$id_departamentor   = NULL;
$departamentor      = NULL;
$representante      = NULL;
$codigoafip         = NULL;
$actividadafip      = NULL;
$otrosregistros     = NULL;
$nroexportador      = 0;  

// LEER DATOS DE LA EMPRESA
      
$tabla_empresa      = mysqli_query($con, 
    "SELECT t2.* 
    FROM registro_solicitantes t1
    INNER JOIN maestro_empresas t2 ON t1.id_empresa = t2.id
    WHERE t1.id_solicitante = $id_solicitante");

if($registro_empresa   = mysqli_fetch_array($tabla_empresa)){

    $id_empresa         = $registro_empresa['id'];
    $razon_social       = $registro_empresa['razon_social'];
    $cuite              = $registro_empresa['cuit'];
    $id_tipo_sociedad   = $registro_empresa['id_tipo_sociedad'];
    
    if(!$id_tipo_sociedad){
        $id_tipo_sociedad   = 0;
    }    
    
    $tabla_sociedades   = mysqli_query($con, "SELECT forma FROM tipo_forma_juridica WHERE id_forma = $id_tipo_sociedad");
    $registro_sociedad  = mysqli_fetch_array($tabla_sociedades);
    $sociedad           = $registro_sociedad[0];        

    if(strtotime($registro_empresa['fecha_inscripcion']) > 0){
        $fecha_inscripcion = date('d/m/Y', strtotime($registro_empresa['fecha_inscripcion']));
    }else{
        $fecha_inscripcion = NULL;
    }

    if(strtotime($registro_empresa['fecha_inicio']) > 0){
        $fecha_inicio = date('d/m/Y', strtotime($registro_empresa['fecha_inicio']));
    }else{
        $fecha_inicio = NULL;
    }

    $domiciliol         = $registro_empresa['domicilio'];
    $nrol               = $registro_empresa['nro'];
    $id_ciudadl         = $registro_empresa['id_localidad'];
    if(!$id_ciudadl){
        $id_ciudadl = 0;
    }
    $tabla_localidades   = mysqli_query($con, 
        "SELECT loc.nombre, dep.id as id_departamento, dep.nombre as departamento
        FROM localidades loc 
        INNER JOIN departamentos dep on loc.departamento_id = dep.id 
        WHERE loc.id = $id_ciudadl");
        $registro_localidades= mysqli_fetch_array($tabla_localidades);

    $ciudadl = $registro_localidades['nombre'];
    $id_departamentol = $registro_localidades['id_departamento'];
    $departamentol = $registro_localidades['departamento'];


    $domicilior         = $registro_empresa['domicilio_actividad'];
    $nror               = $registro_empresa['nro_actividad'];
    $id_ciudadr         = $registro_empresa['id_localidad_actividad'];

    if(!$id_ciudadr){
        $id_ciudadr = 0;
    }
    
    $tabla_localidades   = mysqli_query($con, 
        "SELECT loc.nombre, dep.id as id_departamento, dep.nombre as departamento
        FROM localidades loc 
        INNER JOIN departamentos dep on loc.departamento_id = dep.id 
        WHERE loc.id = $id_ciudadr");
        $registro_localidades= mysqli_fetch_array($tabla_localidades);

    $ciudadr = $registro_localidades['nombre'];
    $id_departamentor = $registro_localidades['id_departamento'];
    $departamentor = $registro_localidades['departamento'];

    $representante      = $registro_empresa['representante'];
    $codigoafip         = $registro_empresa['codigoafip'];
    $actividadafip      = $registro_empresa['actividadafip'];
    $otrosregistros     = $registro_empresa['otrosregistros'];
    $nroexportador      = $registro_empresa['nroexportador'];         

}

?>

                       
    
<div class="row mb-3">
    <div class="col-xs-12 col-sm-12 col-lg-6">
        <b>Nombre de la Empresa o Razón Social</b>
        <input name="id_empresa" id="id_empresa" type="hidden" value="<?php echo $id_empresa ?>">
        <input name="razon_social" id="razon_social" type="text" class="form-control formu mayus" value="<?php echo $razon_social ?>">
    </div>
    <div class="col-xs-12 col-sm-12 col-lg-3">
        <label>Nro de CUIT</label>
        <input name="cuite"  type="text" id="cuite" class="form-control formu" maxlength="11" value="<?php echo $cuite ?>" placeholder="Ingrese Nro sin puntos" >
    </div>
    <div class="col-xs-12 col-sm-12 col-lg-3">
        <label>Tipo Sociedad</label>
        <select id="id_tipo_sociedad" name="id_tipo_sociedad" size="1" class="form-control">
            <?php
            $tipo_sociedades = "SELECT id_tipo, tipo FROM tipo_sociedad order by tipo";
            $registro = mysqli_query($con, $tipo_sociedades); 
            while($fila = mysqli_fetch_array($registro)){

                if($fila[0] == $id_tipo_sociedad){
                    echo "<option value=".$id_tipo_sociedad." selected \>".$sociedad."</option>\n";
                }else{
                    echo "<option value=".$fila[0].">".$fila[1]."</option>\n";
                }  
            }	
            ?>
        </select>
    </div>
</div>

<div class="row mb-3">

    <div class="col-xs-12 col-sm-12 col-lg-4">
        <label>Domicilio <b>legal</b></label>
        <input type="text" name="domiciliol" id="domiciliol" value="<?php echo $domiciliol ?>" class="form-control formu mayus">
    </div>

    <div class="col-xs-12 col-sm-12 col-lg-2">
        <label>Nro</label>
        <input type="text" name="nrol" id="nrol" value="<?php echo $nrol ?>" class="form-control formu mayus">
    </div>

    <div class="col-xs-12 col-sm-12 col-lg-3">
        <label>Departamento</label>
        <select name="departamento" id="departamento"  onchange="from(this.value,'ciudadl','ciudades.php')" class="form-control formu">
        <?php
            $departamentos = "SELECT id, nombre FROM departamentos WHERE provincia_id = 7 order by nombre";
            $registro = mysqli_query($con, $departamentos);
            while ($fila = mysqli_fetch_array($registro)) {
                
                if($fila[0] == $id_departamentol){
                    echo "<option value=".$id_departamentol." selected \>".$departamentol."</option>\n";
                }else{
                    echo "<option value=".$fila[0].'-id_ciudadl'.">".$fila[1]."</option>";
                }  
            }
        ?>
        </select>
    </div>
    <div class="col-xs-12 col-sm-3 col-lg-3">
        <label>Localidad</label>
        <div id="ciudadl">
        <select name="id_ciudadl"  id="id_ciudadl" class="form-control formu" >
            <option value="<?php echo $id_ciudadl;?> " selected><?php echo $ciudadl; ?></option>
        </select>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-xs-12 col-sm-12 col-lg-4">
        <label>Domicilio <b>radicación</b></label>
        <input type="text" name="domicilior" id="domicilior" value="<?php echo $domicilior ?>" class="form-control formu mayus">
    </div>
    <div class="col-xs-12 col-sm-12 col-lg-2">
        <label>Nro</label>
        <input type="text" name="nror" id="nror" value="<?php echo $nror ?>" class="form-control formu">
    </div>

    <div class="col-xs-12 col-sm-12 col-lg-3">
        <label>Departamento</label>
        <select name="departamentor" id="departamentor"  onchange="from(this.value,'ciudadr','ciudades.php')" class="form-control formu">
        <option value="" disabled selected></option>
        <?php
        $departamentos = "SELECT id, nombre FROM departamentos WHERE provincia_id = 7 order by nombre";
        $registro = mysqli_query($con, $departamentos);

        while ($fila = mysqli_fetch_array($registro)) {
            if($fila[0] == $id_departamentor){
                echo "<option value=".$id_departamentor." selected \>".$departamentor."</option>\n";
            }else{
                echo "<option value=".$fila[0].'-id_ciudadr'.">".$fila[1]."</option>";
            }
        }
        ?>
        </select>
    </div>
    <div class="col-xs-12 col-sm-12 col-lg-3">
        <label>Localidad</label>
        <div id="ciudadr">
        <select name="id_ciudadr"  id="id_ciudadr" class="form-control formu">
        <option value="<?php echo $id_ciudadr;?> " selected><?php echo $ciudadr; ?></option>
        </select>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-xs-12 col-sm-12 col-lg-6">
        <label>Representante Legal</label>
        <input name="representante" type="text" id="representante" value="<?php echo $representante ?>" class="form-control formu mayus" placeholder="Datos del representante">
    </div>
</div>    

<div class="row mb-3">
    <div class="col-xs-12 col-sm-12 col-lg-12">
        <hr style="border-color: grey">
    </div>
</div>    

<div class="row mb-3">
    <div class="col-xs-12 col-sm-12 col-lg-2">
        <label>Codigo Afip</label>
        <input name="codigoafip" type="text" id="codigoafip" value="<?php echo $codigoafip ?>" class="form-control formu" >
    </div>
    <div class="col-xs-12 col-sm-12 col-lg-4">
        <label>Actividad Codigo Afip</label>
        <input name="actividadafip" type="text" id="actividadafip" value="<?php echo $codigoafip ?>" class="form-control formu">
    </div>
    <div class="col-xs-12 col-sm-12 col-lg-3">
        <label>Fecha Inscripción</label>
        <input name="fecha_inscripcion" id="fecha_inscripcion" value="<?php echo $fecha_inscripcion ?>" type="text" class="form-control formu">                                
    </div>
    <div class="col-xs-12 col-sm-12 col-lg-3">
        <label>Fecha Inicio Actividad</label>
        <input name="fecha_inicio" id="fecha_inicio" type="text" value="<?php echo $fecha_inicio ?>" class="form-control formu">                                
    </div>
</div>    

<div class="row mb-3">
    <div class="col-xs-12 col-sm-12 col-lg-9">
        <label> Tiene inscripción en otros organismos, cuáles ?</label>
        <input name="otrosregistros" id="otrosregistros" type="text" value="<?php echo $otrosregistros ?>" class="form-control formu mayus" placeholder="Indique en que otros organismos, ej. ATER, Municipalidad, Otros."> 
    </div>
    <div class="col-xs-12 col-sm-12 col-lg-3">
        <label> Nro Exportador, si lo es.</label>
        <input name="nroexportador" id="nroexportador" type="text" value="<?php echo $nroexportador ?>" class="form-control formu">                                
    </div>
</div>