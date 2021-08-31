<?php 
session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/desarrolloemprendedor/accesorios/accesos_bd.php');

$con = conectar();

$id_solicitante = $_SESSION['id_usuario'];

// INICIALIZO DATOS DE LA EMPRESA
$id_empresa			= NULL;
$razon_social       = NULL;
$cuite              = NULL;
$id_tipo_sociedad   = NULL;
$fecha_inscripcion  = NULL;
$fecha_inicio       = NULL;
$domiciliol         = NULL;
$nrol               = NULL;
$id_ciudadl         = NULL;
$domicilior         = NULL;
$nror               = NULL;
$id_ciudadr         = NULL;
$representante      = NULL;
$codigoafip         = NULL;
$actividadafip      = NULL;
$otrosregistros     = NULL;
$nroexportador      = NULL;  

// ACCEDO A LOS DATOS DE LA EMPRESA (SI CORRESPONDE)
$tabla_empresa = mysqli_query($con, "SELECT * FROM rel_solicitante_empresas relac INNER JOIN maestro_empresas mae ON relac.id_empresa = mae.id INNER JOIN tipo_sociedad tipo ON mae.id_tipo_sociedad = tipo.id_tipo WHERE relac.id_solicitante = $id_solicitante");
$registro_empresa = mysqli_fetch_array($tabla_empresa);

if (isset($registro_empresa)) {

    $id_empresa         = $registro_empresa['id'];
    $razon_social       = $registro_empresa['razon_social'];
    $cuite              = $registro_empresa['cuit'];
    $id_tipo_sociedad   = $registro_empresa['id_tipo_sociedad'];
    
    if(!$id_tipo_sociedad){
        $id_tipo_sociedad   = 0;
    }    
    
    $tabla_sociedades   = mysqli_query($con, "select forma from tipo_forma_juridica where id_forma = $id_tipo_sociedad");
    $registro_sociedad  = mysqli_fetch_array($tabla_sociedades, MYSQLI_BOTH);
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
    $tabla_localidades   = mysqli_query($con, "select loc.nombre, dep.id as id_departamento, dep.nombre as departamento
    from localidades loc inner join departamentos dep on loc.departamento_id = dep.id where loc.id = $id_ciudadl");
    $registro_localidades= mysqli_fetch_array($tabla_localidades, MYSQLI_BOTH);

    $ciudadl = $registro_localidades['nombre'];
    $id_departamentol = $registro_localidades['id_departamento'];
    $departamentol = $registro_localidades['departamento'];


    $domicilior         = $registro_empresa['domicilio_actividad'];
    $nror               = $registro_empresa['nro_actividad'];
    $id_ciudadr         = $registro_empresa['id_localidad_actividad'];

    if(!$id_ciudadr){
        $id_ciudadr = 0;
    }
    
    $tabla_localidades   = mysqli_query($con, "select loc.nombre, dep.id as id_departamento, dep.nombre as departamento
    from localidades loc inner join departamentos dep on loc.departamento_id = dep.id where loc.id = $id_ciudadr");
    $registro_localidades= mysqli_fetch_array($tabla_localidades, MYSQLI_BOTH);

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

<!-- Datos de la Empresa -->

    <div class="card-header">
        <div class="row">
            <div class="col">
                <h4>Datos del emprendimiento</h4>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col">
                <label class="p-3">Nombre de la Empresa o Razón Social</label>
                <input name="id_empresa" id="id_empresa" type="hidden" value="<?php echo $id_empresa ?>">
                <input name="razon_social" id="razon_social" type="text" class="form-control" value="<?php echo $razon_social ?>">
            </div>
            <div class="col">
                <label class="p-3">Nro de CUIT</label>
                <input name="cuite"  type="text" id="cuite" class="form-control" maxlength="11" value="<?php echo $cuite ?>" placeholder="Ingrese Nro sin puntos" >
            </div>
            <div class="col">
                <label class="p-3">Tipo Sociedad</label>
                <select id="id_tipo_sociedad" name="id_tipo_sociedad" size="1" class="form-control">
                    <?php
                    $tipo_sociedades = "select id_forma, forma from tipo_forma_juridica order by forma";
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
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col">
                <label>Domicilio Legal</label>
                <input type="text" name="domiciliol" id="domiciliol" value="<?php echo $domiciliol ?>" class="form-control">
            </div>
            <div class="col">
                <label>Nro</label>
                <input type="text" name="nrol" id="nrol" value="<?php echo $nrol ?>" class="form-control">
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col">
                <label>Departamento</label>
                <select name="departamento" id="departamento"  onchange="from(this.value,'ciudadl','ciudades.php')" class="form-control">
                <?php
                    $departamentos = "select id, nombre from departamentos where provincia_id = 7 order by nombre";
                    $registro = mysqli_query($con, $departamentos);
                    while ($fila = mysqli_fetch_array($registro)) {
                        
                        if($fila[0] == $id_departamentol){
                            echo "<option value=".$id_departamentol." selected \>".$departamentol."</option>\n";
                        }else{
                            echo "<option value=".$fila[0].">".$fila[1]."</option>\n";
                        }  
                    }
                ?>
                </select>
            </div>
            <div class="col">
                <label>Localidad</label>
                <div id="ciudadl">
                <select name="id_ciudadl"  id="id_ciudadl" class="form-control" >
                    <option value="<?php echo $id_ciudadl;?> " selected><?php echo $ciudadl; ?></option>
                </select>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col">
                <label>Representante Legal</label>
                <input name="representante" type="text" id="representante" value="<?php echo $representante ?>" class="form-control" placeholder="Datos del representante">
            </div>
        </div>    
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col">
                <hr style="border-color: grey">
            </div>
        </div> 
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col">
                <label>Domicilio radicación de la empresa</label>
                <input type="text" name="domicilior" id="domicilior" value="<?php echo $domicilior ?>" class="form-control">
            </div>
            <div class="col">
                <label>Nro</label>
                <input type="text" name="nror" id="nror" value="<?php echo $nror ?>" class="form-control">
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col">
                <label>Departamento</label>
                <select name="departamentor" id="departamentor"  onchange="from(this.value,'ciudadr','ciudades.php')" class="form-control">
                <option value="" disabled selected></option>
                <?php
                $departamentos = "select id, nombre from departamentos where provincia_id = 7 order by nombre";
                $registro = mysqli_query($con, $departamentos);

                while ($fila = mysqli_fetch_array($registro)) {
                    if($fila[0] == $id_departamentor){
                        echo "<option value=".$id_departamentor." selected \>".$departamentor."</option>\n";
                    }else{
                        echo "<option value=".$fila[0].">".$fila[1]."</option>\n";
                    }
                }
                ?>
                </select>
            </div>
            <div class="col">
                <label>Localidad</label>
                <div id="ciudadr">
                <select name="id_ciudadr"  id="id_ciudadr" class="form-control">
                <option value="<?php echo $id_ciudadr;?> " selected><?php echo $ciudadr; ?></option>
                </select>
                </div>
            </div>
        </div>
    </div>
        
    <div class="form-group">
        <div class="row">
            <div class="col">
                <hr style="border-color: grey">
            </div>
        </div>    
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-lg-2">
                <label>Codigo Afip</label>
                <input name="codigoafip" type="text" id="codigoafip" value="<?php echo $codigoafip ?>" class="form-control" >
            </div>
            <div class="col-lg-4">
                <label>Actividad Codigo Afip</label>
                <input name="actividadafip" type="text" id="actividadafip" value="<?php echo $codigoafip ?>" class="form-control">
            </div>
            <div class="col-lg-3">
                <label>Fecha Inscripción</label>
                <input name="fecha_inscripcion" id="fecha_inscripcion" value="<?php echo $fecha_inscripcion ?>" type="text" class="form-control">                                
            </div>
            <div class="col-lg-3">
                <label>Fecha Inicio Actividad</label>
                <input name="fecha_inicio" id="fecha_inicio" type="text" value="<?php echo $fecha_inicio ?>" class="form-control">                                
            </div>
        </div>    
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-lg-9">
                <label> Tiene inscripción en otros organismos, cuáles ?</label>
                <input name="otrosregistros" id="otrosregistros" type="text" value="<?php echo $otrosregistros ?>" class="form-control" placeholder="Indique en que otros organismos, ej. ATER, Municipalidad, Otros."> 
            </div>
            <div class="col-lg-3">
                <label> Nro Exportador, si lo es.</label>
                <input name="nroexportador" id="nroexportador" type="text" value="<?php echo $nroexportador ?>" class="form-control">                                
            </div>
        </div>                                
    </div>                

<?php    mysqli_close($con);
